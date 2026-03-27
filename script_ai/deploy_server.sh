#!/usr/bin/env bash
set -Eeuo pipefail

BRANCH="${1:-main}"
APP_DIR="${APP_DIR:-/var/www/axecode_tech_usr/data/www/landing-ad.axecode.tech}"

log() {
  printf '[deploy] %s\n' "$1"
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

cd "$APP_DIR"

if [[ ! -f artisan ]]; then
  log "artisan not found in $APP_DIR"
  exit 1
fi

if ! php -m | grep -qi '^intl$'; then
  log "PHP extension intl is missing. Install php8.3-intl and restart php8.3-fpm + web server."
  exit 1
fi

ensure_git_origin_access

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
