@echo off
setlocal EnableExtensions EnableDelayedExpansion

cd /d "%~dp0.."

set "COMMIT_MSG=%~1"
if "%COMMIT_MSG%"=="" set "COMMIT_MSG=chore: deploy %DATE% %TIME%"

set "BRANCH=%~2"
if "%BRANCH%"=="" (
  for /f "delims=" %%i in ('git branch --show-current') do set "BRANCH=%%i"
)

if "%BRANCH%"=="" (
  echo [ERROR] Cannot detect git branch.
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
ssh axecode_tech_usr@85.239.57.126 "cd /var/www/axecode_tech_usr/data/www/landing-ad.axecode.tech && bash script_ai/deploy_server.sh %BRANCH%"
if errorlevel 1 (
  echo [ERROR] Remote deploy failed.
  exit /b 1
)

echo [OK] Deploy completed successfully.
exit /b 0
