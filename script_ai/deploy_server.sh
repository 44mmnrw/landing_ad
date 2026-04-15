#!/usr/bin/env bash
set -Eeuo pipefail

BRANCH="${1:-main}"
APP_DIR="${APP_DIR:-/var/www/avtodostavka_usr/data/www/avtodostavka.su}"
REPO_URL="${REPO_URL:-https://github.com/44mmnrw/landing_ad.git}"

log() {
  printf '[deploy] %s\n' "$1"
}

normalize_repo_url() {
  if [[ "$REPO_URL" == git@github.com:* ]]; then
    local https_url
    https_url="${REPO_URL#git@github.com:}"
    REPO_URL="https://github.com/${https_url}"
  fi
}

bootstrap_repo_if_needed() {
  mkdir -p "$APP_DIR"

  if [[ -d "$APP_DIR/.git" ]]; then
    return 0
  fi

  normalize_repo_url

  if [[ -n "$(find "$APP_DIR" -mindepth 1 -maxdepth 1 -print -quit 2>/dev/null || true)" ]]; then
    local backup_dir
    backup_dir="${APP_DIR%/}_backup_$(date +%Y%m%d-%H%M%S)"
    log "App directory is not empty, moving existing files to backup: $backup_dir"
    mkdir -p "$backup_dir"
    shopt -s dotglob nullglob
    mv "$APP_DIR"/* "$backup_dir"/
    shopt -u dotglob nullglob
  fi

  log "Bootstrapping repository from $REPO_URL (branch: $BRANCH)"
  git clone --branch "$BRANCH" --single-branch "$REPO_URL" "$APP_DIR"
}

ensure_git_origin_access() {
  if git ls-remote --heads origin "$BRANCH" >/dev/null 2>&1; then
    return 0
  fi

  local origin_url
  origin_url="$(git remote get-url origin 2>/dev/null || true)"

  if [[ "$origin_url" == git@github.com:* ]]; then
    local https_url
    https_url="${origin_url#git@github.com:}"
    https_url="https://github.com/${https_url}"

    log "SSH access to origin failed, switching remote to HTTPS: $https_url"
    git remote set-url origin "$https_url"
  fi

  if ! git ls-remote --heads origin "$BRANCH" >/dev/null 2>&1; then
    log "Cannot access git origin for branch $BRANCH"
    exit 1
  fi
}

prepare_clean_worktree() {
  if ! git diff --quiet || ! git diff --cached --quiet || [[ -n "$(git ls-files --others --exclude-standard)" ]]; then
    local stash_name
    stash_name="auto-deploy-$(date +%Y%m%d-%H%M%S)"
    log "Working tree is dirty, creating stash: $stash_name"
    git stash push --include-untracked -m "$stash_name" >/dev/null
  fi
}

bootstrap_repo_if_needed

cd "$APP_DIR"

if [[ ! -f artisan ]]; then
  log "artisan not found in $APP_DIR"
  exit 1
fi

if php --ri intl >/dev/null 2>&1; then
  :
elif php -m 2>/dev/null | grep -qi 'intl'; then
  :
else
  log "PHP extension intl is missing. Install php8.3-intl and restart php8.3-fpm + web server."
  exit 1
fi

ensure_git_origin_access
prepare_clean_worktree

log "Fetching branch $BRANCH"
git fetch origin "$BRANCH"
git checkout "$BRANCH"
git pull --ff-only origin "$BRANCH"

log "Installing PHP dependencies"
composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction

log "Enabling maintenance mode"
php artisan down --retry=60 || true

cleanup() {
  php artisan up || true
}
trap cleanup EXIT

log "Running database migrations"
php artisan migrate --force --no-interaction

if [[ -f package-lock.json ]]; then
  log "Installing Node dependencies"
  npm ci --no-audit --no-fund
  log "Building frontend assets"
  npm run build
fi

log "Refreshing application caches"
php artisan optimize:clear
php artisan config:cache
php artisan view:cache

log "Ensuring storage symlink exists"
php artisan storage:link || true

log "Deployment finished successfully"
