@echo off
setlocal EnableExtensions EnableDelayedExpansion

cd /d "%~dp0.."

if "%~1"=="/?" goto :usage
if /I "%~1"=="-h" goto :usage
if /I "%~1"=="--help" goto :usage

set "COMMIT_MSG=%~1"
if "%COMMIT_MSG%"=="" set "COMMIT_MSG=chore: deploy %DATE% %TIME%"

set "SSH_HOST=83.217.203.66"
set "SSH_USER=avtodostavka_usr"
set "APP_DIR=/var/www/avtodostavka_usr/data/www/avtodostavka.su"

set "BRANCH=%~2"
if "%BRANCH%"=="" (
  for /f "delims=" %%i in ('git branch --show-current') do set "BRANCH=%%i"
)

set "REPO_URL="
for /f "delims=" %%i in ('git remote get-url origin 2^>nul') do set "REPO_URL=%%i"

if "%BRANCH%"=="" (
  echo [ERROR] Cannot detect git branch.
  exit /b 1
)

if "%REPO_URL%"=="" (
  echo [ERROR] Cannot detect git origin URL.
  exit /b 1
)

echo [STEP 1/5] Commit all changes...
git add -A
if errorlevel 1 (
  echo [ERROR] git add failed.
  exit /b 1
)

git diff --cached --quiet
if errorlevel 1 (
  git commit -m "%COMMIT_MSG%"
  if errorlevel 1 (
    echo [ERROR] git commit failed.
    exit /b 1
  )
) else (
  echo [INFO] Nothing new to commit.
)

echo [STEP 2/5] Push to GitHub branch %BRANCH%...
git push origin "%BRANCH%"
if errorlevel 1 (
  echo [ERROR] git push failed.
  exit /b 1
)

echo [STEP 3/5] Pull on production server...
echo [STEP 4/5] Build on server...
echo [STEP 5/5] Clear caches on server...
ssh %SSH_USER%@%SSH_HOST% "set -e; APP_DIR='%APP_DIR%'; BRANCH='%BRANCH%'; REPO_URL='%REPO_URL%'; mkdir -p \"$APP_DIR\"; if [ ! -f \"$APP_DIR/script_ai/deploy_server.sh\" ]; then if [ -n \"$(find \"$APP_DIR\" -mindepth 1 -maxdepth 1 -print -quit 2>/dev/null)\" ]; then BACKUP=\"${APP_DIR%/}_bootstrap_backup_$(date +%Y%m%d-%H%M%S)\"; mkdir -p \"$BACKUP\"; shopt -s dotglob nullglob; mv \"$APP_DIR\"/* \"$BACKUP\"/; shopt -u dotglob nullglob; fi; if echo \"$REPO_URL\" | grep -q '^git@github.com:'; then REPO_URL=\"https://github.com/${REPO_URL#git@github.com:}\"; fi; git clone --branch \"$BRANCH\" --single-branch \"$REPO_URL\" \"$APP_DIR\"; fi; cd \"$APP_DIR\"; APP_DIR=\"$APP_DIR\" REPO_URL=\"$REPO_URL\" bash script_ai/deploy_server.sh \"$BRANCH\""
if errorlevel 1 (
  echo [ERROR] Remote deploy failed.
  exit /b 1
)

echo [OK] Deploy completed successfully.
exit /b 0

:usage
echo Usage: script_ai\deploy.bat [commit_message] [branch]
echo Example: script_ai\deploy.bat "chore: release" main
exit /b 0
