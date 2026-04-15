@echo off
setlocal EnableExtensions EnableDelayedExpansion
chcp 65001 >nul
title Landing AD - Deploy

call :fn_init_colors

REM ================================================================
REM  CONFIG
REM ================================================================

set "SERVER_HOST=83.217.203.66"
set "SERVER_USER=avtodostavka_usr"
set "SERVER_PATH=/var/www/avtodostavka_usr/data/www/avtodostavka.su"
set "GIT_BRANCH=main"
set "GIT_REMOTE=origin"
set "GIT_REPO_SSH_URL=git@github.com:44mmnrw/landing_ad.git"

set "DEFAULT_ACTION=2"
set "AUTO_MODE=0"
set "AUTO_COMMIT=y"
set "AUTO_COMMIT_MSG=AutoDeploy"
set "NONINTERACTIVE=0"

set "PROD_DB_NAME=land_avtodostavka"
set "PROD_DB_USER=land_avtodos_usr"
set "PROD_DB_PASS=>LFM]Jd9]tAYwNO0"

set "SSH_KEY_PATH=%USERPROFILE%\.ssh\id_ed25519_work_prod_2026"
set "SSH_KEY_PASSPHRASE=wwwdev"

set "GIT_SSH_KEY_PATH=%USERPROFILE%\.ssh\id_ed25519_work_prod_2026"
set "GIT_SSH_KEY_PASSPHRASE=wwwdev"

set "LOCAL_DB_HOST="
set "LOCAL_DB_NAME="
set "LOCAL_DB_USER="
set "LOCAL_DB_PASS="

for %%I in ("%~dp0..") do set "LOCAL_PROJECT=%%~fI"

REM DB settings will be loaded lazily only for DB import actions

REM ================================================================
REM  ARGUMENTS
REM ================================================================

if /I "%~1"=="--help" goto :help
if /I "%~1"=="-h" goto :help

REM Direct mode shortcuts: avoid any ambiguity in argument parsing.
if "%~1"=="1" (
	call :fn_import_db
	goto :done
)
if "%~1"=="2" (
	call :fn_deploy_code
	goto :done
)
if "%~1"=="3" (
	echo [INFO] Safe mode: skip DB import, run deploy with migrations only.
	call :fn_deploy_code
	goto :done
)
if "%~1"=="0" goto :done

if /I "%~1"=="--auto" (
	set "AUTO_MODE=1"
	set "NONINTERACTIVE=1"
	set "CHOICE=%DEFAULT_ACTION%"

	if not "%~2"=="" (
		if "%~2"=="1" set "CHOICE=1"
		if "%~2"=="2" set "CHOICE=2"
		if "%~2"=="3" set "CHOICE=3"
		if "%~2"=="0" set "CHOICE=0"

		if /I "%~2"=="y" set "AUTO_COMMIT=y"
		if /I "%~2"=="n" set "AUTO_COMMIT=n"
	)

	if not "%~3"=="" set "AUTO_COMMIT=%~3"
	if not "%~4"=="" set "AUTO_COMMIT_MSG=%~4"
)

REM ================================================================
REM  MENU
REM ================================================================

if not defined CHOICE (
	cls
	echo.
	echo %C_CYAN%==============================================%C_RESET%
	echo %C_BOLD%%C_WHITE%  Landing AD - Deploy to Production%C_RESET%
	echo %C_DIM%  Server : %C_YELLOW%%SERVER_HOST%%C_RESET%
	echo %C_DIM%  Branch : %C_GREEN%%GIT_BRANCH%%C_RESET%
	echo %C_CYAN%==============================================%C_RESET%
	echo.
	echo %C_YELLOW%  1.%C_RESET% %C_WHITE%Import DB%C_RESET%       %C_DIM%^(local -^> production^)%C_RESET%
	echo %C_GREEN%  2.%C_RESET% %C_WHITE%Deploy code%C_RESET%     %C_DIM%^(git push + pull on server^)%C_RESET%
	echo %C_BLUE%  3.%C_RESET% %C_WHITE%Deploy code + migrate only%C_RESET% %C_DIM%^(safe DB mode^)%C_RESET%
	echo %C_RED%  0.%C_RESET% %C_WHITE%Exit%C_RESET%
	echo.
	set /p "CHOICE=%C_BOLD%%C_WHITE%Select [0-3]: %C_RESET%"
)

if "%CHOICE%"=="1" (
	call :fn_import_db
	goto :done
)

if "%CHOICE%"=="2" (
	call :fn_deploy_code
	goto :done
)

if "%CHOICE%"=="3" (
	echo [INFO] Safe mode: skip DB import, run deploy with migrations only.
	call :fn_deploy_code
	goto :done
)

if "%CHOICE%"=="0" goto :done

echo.
echo [ERROR] Invalid choice. Exit.
goto :done


REM ================================================================
REM  FUNCTION: IMPORT DB  ^(local -^> production^)
REM ================================================================
:fn_import_db
echo.
echo ---- IMPORT DB -------------------------------------------------
echo [0/4] Unlock SSH key...
call :fn_unlock_ssh_key
if errorlevel 1 exit /b 1

call :fn_require_db_config
if errorlevel 1 exit /b 1

echo [1/4] Create local dump "%LOCAL_DB_NAME%"...

for /f "tokens=1-3 delims=." %%a in ("%DATE%") do set "_date=%%c%%b%%a"
for /f "tokens=1-2 delims=:." %%a in ("%TIME: =0%") do set "_time=%%a%%b"
set "DUMP_FILE=%TEMP%\avto_dost_%_date%_%_time%.sql"
set "DUMP_ERR=%TEMP%\avto_dost_%_date%_%_time%.err"
set "DUMP_IGNORE_TABLE=--ignore-table=%LOCAL_DB_NAME%.integration_settings"

if "%LOCAL_DB_PASS%"=="" (
	mysqldump -h %LOCAL_DB_HOST% -u %LOCAL_DB_USER% --single-transaction --no-tablespaces %DUMP_IGNORE_TABLE% %LOCAL_DB_NAME% > "%DUMP_FILE%" 2> "%DUMP_ERR%"
) else (
	mysqldump -h %LOCAL_DB_HOST% -u %LOCAL_DB_USER% -p"%LOCAL_DB_PASS%" --single-transaction --no-tablespaces %DUMP_IGNORE_TABLE% %LOCAL_DB_NAME% > "%DUMP_FILE%" 2> "%DUMP_ERR%"
)

if errorlevel 1 (
	echo [ERROR] Failed to create local dump.
	if exist "%DUMP_ERR%" type "%DUMP_ERR%"
	del "%DUMP_FILE%" 2>nul
	del "%DUMP_ERR%" 2>nul
	exit /b 1
)

if exist "%DUMP_ERR%" del "%DUMP_ERR%" 2>nul

echo [OK] Dump created: %DUMP_FILE%

echo [2/4] Upload dump to server via SCP...
call :fn_run_scp "%DUMP_FILE%" "%SERVER_USER%@%SERVER_HOST%:/tmp/avto_dump.sql"
if errorlevel 1 (
	echo [ERROR] SCP failed.
	del "%DUMP_FILE%" 2>nul
	exit /b 1
)

echo [2.5/4] Upload MySQL auth config to server...
set "MYSQL_CNF_LOCAL=%TEMP%\avto_mysql_prod_%_date%_%_time%.cnf"
set "MYSQL_CNF_REMOTE=/tmp/avto_mysql_prod.cnf"
(
	echo [client]
	echo user=%PROD_DB_USER%
	<nul set /p "=password=%PROD_DB_PASS%"
	echo.
) > "%MYSQL_CNF_LOCAL%"

call :fn_run_scp "%MYSQL_CNF_LOCAL%" "%SERVER_USER%@%SERVER_HOST%:%MYSQL_CNF_REMOTE%"
if errorlevel 1 (
	echo [ERROR] Failed to upload MySQL auth config.
	del "%MYSQL_CNF_LOCAL%" 2>nul
	del "%DUMP_FILE%" 2>nul
	exit /b 1
)

call :fn_run_ssh "%SERVER_USER%@%SERVER_HOST%" "chmod 600 %MYSQL_CNF_REMOTE%"
if errorlevel 1 (
	echo [ERROR] Failed to protect MySQL auth config permissions.
	call :fn_run_ssh "%SERVER_USER%@%SERVER_HOST%" "rm -f %MYSQL_CNF_REMOTE% /tmp/avto_dump.sql"
	del "%MYSQL_CNF_LOCAL%" 2>nul
	del "%DUMP_FILE%" 2>nul
	exit /b 1
)

echo [3/4] Import dump on production server...
call :fn_run_ssh "%SERVER_USER%@%SERVER_HOST%" "mysql --defaults-extra-file=%MYSQL_CNF_REMOTE% %PROD_DB_NAME% --execute='SOURCE /tmp/avto_dump.sql'"
if errorlevel 1 (
	echo [ERROR] Production DB import failed.
	call :fn_run_ssh "%SERVER_USER%@%SERVER_HOST%" "rm -f %MYSQL_CNF_REMOTE% /tmp/avto_dump.sql"
	del "%MYSQL_CNF_LOCAL%" 2>nul
	del "%DUMP_FILE%" 2>nul
	exit /b 1
)

echo [4/4] Cleanup temp files...
call :fn_run_ssh "%SERVER_USER%@%SERVER_HOST%" "rm -f /tmp/avto_dump.sql %MYSQL_CNF_REMOTE%"
del "%MYSQL_CNF_LOCAL%" 2>nul
del "%DUMP_FILE%" 2>nul

echo [OK] Production DB updated.
exit /b 0


REM ================================================================
REM  FUNCTION: DEPLOY CODE
REM ================================================================
:fn_deploy_code
echo.
echo ---- DEPLOY CODE -----------------------------------------------
cd /d "%LOCAL_PROJECT%"

echo [0/4] Unlock SSH key...
call :fn_unlock_ssh_key
if errorlevel 1 exit /b 1

if /I not "%GIT_SSH_KEY_PATH%"=="%SSH_KEY_PATH%" (
	echo [0.1/4] Unlock Git SSH key...
	call :fn_unlock_git_ssh_key
	if errorlevel 1 exit /b 1
)

echo [0.2/4] Ensure git remote URL for private repository...
for /f "delims=" %%R in ('git remote get-url %GIT_REMOTE% 2^>nul') do set "CURRENT_REMOTE=%%R"
if not defined CURRENT_REMOTE (
	echo [ERROR] Git remote "%GIT_REMOTE%" not found.
	exit /b 1
)
if /I not "!CURRENT_REMOTE!"=="%GIT_REPO_SSH_URL%" (
	echo [INFO] Update "%GIT_REMOTE%" URL to %GIT_REPO_SSH_URL%
	git remote set-url %GIT_REMOTE% %GIT_REPO_SSH_URL%
	if errorlevel 1 (
		echo [ERROR] Failed to set git remote URL.
		exit /b 1
	)
)

echo [1/4] Check git status...
git status --short > "%TEMP%\git_status.tmp" 2>&1
for %%A in ("%TEMP%\git_status.tmp") do set "_size=%%~zA"
del "%TEMP%\git_status.tmp" 2>nul

if %_size% gtr 0 (
	echo.
	echo Uncommitted changes found:
	git status --short
	echo.

	if "%NONINTERACTIVE%"=="1" (
		set "COMMIT_CHOICE=%AUTO_COMMIT%"
		echo [AUTO] Commit choice: !COMMIT_CHOICE!
	) else (
		set /p "COMMIT_CHOICE=Commit and push changes? ^(y/n^): "
	)

	if /I "!COMMIT_CHOICE!"=="y" (
		if "%NONINTERACTIVE%"=="1" (
			set "COMMIT_MSG=%AUTO_COMMIT_MSG%"
		) else (
			set /p "COMMIT_MSG=Commit message ^(Enter = deploy: update^): "
		)

		if "!COMMIT_MSG!"=="" set "COMMIT_MSG=deploy: update"
		git add -A
		git commit -m "!COMMIT_MSG!"
		if errorlevel 1 (
			echo [ERROR] git commit failed.
			exit /b 1
		)

		call :fn_run_git_push %GIT_REMOTE% %GIT_BRANCH%
		if errorlevel 1 (
			echo [ERROR] git push failed.
			exit /b 1
		)

		echo [OK] Changes pushed to GitHub.
	) else (
		echo [INFO] Skip commit. Deploy current HEAD.
	)
) else (
	echo [OK] Working tree is clean.
	call :fn_run_git_push %GIT_REMOTE% %GIT_BRANCH% >nul 2>&1
)

echo.
echo [1.5/4] Check git access on server for private repo...
call :fn_run_ssh "%SERVER_USER%@%SERVER_HOST%" "cd %SERVER_PATH% && GIT_SSH_COMMAND='ssh -o BatchMode=yes -o StrictHostKeyChecking=accept-new' git ls-remote --heads %GIT_REMOTE% %GIT_BRANCH% > /dev/null"
if errorlevel 1 (
	echo [ERROR] Server has no git access to private repository.
	echo [HINT] Add deploy key on server and register it in GitHub repo Deploy keys.
	echo [HINT] Check server key: ssh -T git@github.com
	exit /b 1
)

echo.
echo [2/4] Update code on server ^(git pull^)...
set "REMOTE_CMD=cd %SERVER_PATH% && if git status --porcelain | grep -q .; then echo [WARN] Server working tree has local changes. Auto-stashing before deploy...; git stash push -m deploy-auto-stash; fi && git pull --ff-only %GIT_REMOTE% %GIT_BRANCH%"
call :fn_run_ssh "%SERVER_USER%@%SERVER_HOST%" "!REMOTE_CMD!"
if errorlevel 1 (
	echo [ERROR] git pull failed on server.
	exit /b 1
)
echo [OK] Server code updated.

echo.
echo [3/4] Build frontend on server ^(npm ci ^&^& npm run build^)...
set "REMOTE_CMD=cd %SERVER_PATH% && if command -v npm >/dev/null 2>&1; then npm ci && npm run build; elif [ -x node/bin/node ] && [ -x node/bin/npm ]; then PATH=\"$PWD/node/bin:$PATH\" npm ci && PATH=\"$PWD/node/bin:$PATH\" npm run build; else echo [ERROR] npm is not available and portable Node.js was not found in node/bin; exit 1; fi"
call :fn_run_ssh "%SERVER_USER%@%SERVER_HOST%" "!REMOTE_CMD!"
if errorlevel 1 (
	echo [ERROR] Frontend build failed on server.
	exit /b 1
)
echo [OK] Frontend built.

echo.
echo [4/4] Composer + migrate + cache on server...
call :fn_run_ssh "%SERVER_USER%@%SERVER_HOST%" "cd %SERVER_PATH% && composer install --no-dev --optimize-autoloader --no-interaction"
if errorlevel 1 (
	echo [ERROR] composer install failed on server.
	exit /b 1
)

call :fn_run_ssh "%SERVER_USER%@%SERVER_HOST%" "cd %SERVER_PATH% && php artisan optimize:clear"
if errorlevel 1 (
	echo [ERROR] php artisan optimize:clear failed on server.
	exit /b 1
)

call :fn_run_ssh "%SERVER_USER%@%SERVER_HOST%" "cd %SERVER_PATH% && php artisan migrate --force"
if errorlevel 1 (
	echo [ERROR] php artisan migrate failed on server.
	exit /b 1
)

call :fn_run_ssh "%SERVER_USER%@%SERVER_HOST%" "cd %SERVER_PATH%; php artisan config:cache"
if errorlevel 1 (
	echo [ERROR] php artisan config:cache failed on server.
	exit /b 1
)

call :fn_run_ssh "%SERVER_USER%@%SERVER_HOST%" "cd %SERVER_PATH%; php artisan route:cache"
if errorlevel 1 (
	echo [ERROR] php artisan route:cache failed on server.
	exit /b 1
)

call :fn_run_ssh "%SERVER_USER%@%SERVER_HOST%" "cd %SERVER_PATH%; php artisan view:cache"
if errorlevel 1 (
	echo [ERROR] Final server commands failed.
	exit /b 1
)

call :fn_run_ssh "%SERVER_USER%@%SERVER_HOST%" "cd %SERVER_PATH% && php artisan queue:restart"
if errorlevel 1 (
	echo [ERROR] php artisan queue:restart failed on server.
	exit /b 1
)

echo.
echo [4.1/4] Tracking sender smoke-test...
call :fn_run_ssh "%SERVER_USER%@%SERVER_HOST%" "cd %SERVER_PATH% && php script_ai/check_tracking_sender_verbose.php; rc=$?; if [ $rc -eq 1 ]; then echo [WARN] Tracking smoke-test skipped: no trips found.; exit 0; fi; exit $rc"
if errorlevel 1 (
	echo [ERROR] Tracking smoke-test failed.
	echo [HINT] Check receiver-side env: TRACKING_INTERNAL_ALLOWED_IPS and TRACKING_INTERNAL_HMAC_SECRET.
	echo [HINT] Ensure TRACKING_INTERNAL_HMAC_SECRET equals sender integration_settings tracking_receiver.shared_secret.
	exit /b 1
)

echo [OK] Tracking sender smoke-test passed.

echo [OK] Code deployed successfully.
exit /b 0


REM ================================================================
REM  FINISH
REM ================================================================
:done
echo.
echo ==============================================
echo Done.
echo ==============================================
echo.

if "%NONINTERACTIVE%"=="1" (
	endlocal
	exit /b 0
)

pause
endlocal
exit /b 0


:fn_require_db_config
if exist "%LOCAL_PROJECT%\.env" (
	for /f "usebackq tokens=1,* delims==" %%A in ("%LOCAL_PROJECT%\.env") do (
		if /I "%%A"=="DB_HOST" set "LOCAL_DB_HOST=%%B"
		if /I "%%A"=="DB_DATABASE" set "LOCAL_DB_NAME=%%B"
		if /I "%%A"=="DB_USERNAME" set "LOCAL_DB_USER=%%B"
		if /I "%%A"=="DB_PASSWORD" set "LOCAL_DB_PASS=%%B"
	)
)

if not defined LOCAL_DB_HOST (
	echo [ERROR] DB_HOST not found in .env
	exit /b 1
)
if not defined LOCAL_DB_NAME (
	echo [ERROR] DB_DATABASE not found in .env
	exit /b 1
)
if not defined LOCAL_DB_USER (
	echo [ERROR] DB_USERNAME not found in .env
	exit /b 1
)

exit /b 0


:fn_unlock_ssh_key
call :fn_unlock_specific_ssh_key "%SSH_KEY_PATH%" "%SSH_KEY_PASSPHRASE%" "server"
exit /b %errorlevel%


:fn_unlock_git_ssh_key
call :fn_unlock_specific_ssh_key "%GIT_SSH_KEY_PATH%" "%GIT_SSH_KEY_PASSPHRASE%" "git"
exit /b %errorlevel%


:fn_unlock_specific_ssh_key
set "_KEY_PATH=%~1"
set "_KEY_PASSPHRASE=%~2"
set "_KEY_LABEL=%~3"

if "%_KEY_PATH%"=="" (
	echo [ERROR] SSH key path for %_KEY_LABEL% is empty.
	exit /b 1
)

if not exist "%_KEY_PATH%" (
	echo [ERROR] SSH key not found: %_KEY_PATH%
	exit /b 1
)

where ssh-add >nul 2>&1
if errorlevel 1 (
	echo [ERROR] ssh-add command not found.
	exit /b 1
)

for %%I in ("%_KEY_PATH%") do set "_KEY_NAME=%%~nxI"

ssh-add -l 2>nul | findstr /I /C:"!_KEY_NAME!" >nul
if not errorlevel 1 (
	echo [OK] SSH key already unlocked ^(!_KEY_LABEL!^).
	exit /b 0
)

call :fn_prepare_askpass "%_KEY_PASSPHRASE%"

ssh-add "%_KEY_PATH%" <nul >nul 2>&1
set "_SSH_ADD_RC=%errorlevel%"

call :fn_cleanup_askpass

if not "%_SSH_ADD_RC%"=="0" (
	echo [ERROR] Failed to unlock SSH key automatically ^(!_KEY_LABEL!^).
	exit /b 1
)

echo [OK] SSH key unlocked ^(!_KEY_LABEL!^).
exit /b 0


:fn_init_colors
set "C_RESET="
set "C_BOLD="
set "C_DIM="
set "C_RED="
set "C_GREEN="
set "C_YELLOW="
set "C_BLUE="
set "C_CYAN="
set "C_WHITE="

for /f %%E in ('echo prompt $E ^| cmd') do set "ESC=%%E"
if not defined ESC exit /b 0

set "C_RESET=%ESC%[0m"
set "C_BOLD=%ESC%[1m"
set "C_DIM=%ESC%[2m"
set "C_RED=%ESC%[31m"
set "C_GREEN=%ESC%[32m"
set "C_YELLOW=%ESC%[33m"
set "C_BLUE=%ESC%[34m"
set "C_CYAN=%ESC%[36m"
set "C_WHITE=%ESC%[97m"
exit /b 0


:fn_prepare_askpass
set "_ASKPASS_PASSPHRASE=%~1"
if "%_ASKPASS_PASSPHRASE%"=="" (
	set "_ASKPASS_FILE="
	set "SSH_ASKPASS="
	set "SSH_ASKPASS_REQUIRE="
	set "DISPLAY="
	exit /b 0
)

set "_ASKPASS_FILE=%TEMP%\avto_dost_askpass.cmd"
>"%_ASKPASS_FILE%" echo @echo %_ASKPASS_PASSPHRASE%
set "SSH_ASKPASS=%_ASKPASS_FILE%"
set "SSH_ASKPASS_REQUIRE=force"
set "DISPLAY=avto-dost"
set "_ASKPASS_PASSPHRASE="
exit /b 0


:fn_cleanup_askpass
if defined _ASKPASS_FILE del "%_ASKPASS_FILE%" 2>nul
set "_ASKPASS_FILE="
set "SSH_ASKPASS="
set "SSH_ASKPASS_REQUIRE="
set "DISPLAY="
exit /b 0


:fn_run_git_push
set "_GIT_SSH_COMMAND=ssh -i \"%GIT_SSH_KEY_PATH%\" -o IdentitiesOnly=yes -o StrictHostKeyChecking=accept-new"
set "GIT_SSH_COMMAND=%_GIT_SSH_COMMAND%"
call :fn_prepare_askpass "%GIT_SSH_KEY_PASSPHRASE%"
git push %* <nul
set "_CMD_RC=%errorlevel%"
call :fn_cleanup_askpass
set "GIT_SSH_COMMAND="
set "_GIT_SSH_COMMAND="
exit /b %_CMD_RC%


:fn_run_ssh
call :fn_prepare_askpass "%SSH_KEY_PASSPHRASE%"
set "_SSH_TARGET=%~1"
set "_SSH_COMMAND=%~2"

if "%_SSH_TARGET%"=="" (
	call :fn_cleanup_askpass
	exit /b 1
)

if "%_SSH_COMMAND%"=="" (
	ssh "%_SSH_TARGET%" <nul
) else (
	ssh "%_SSH_TARGET%" "%_SSH_COMMAND%" <nul
)

set "_CMD_RC=%errorlevel%"
call :fn_cleanup_askpass
exit /b %_CMD_RC%


:fn_run_scp
call :fn_prepare_askpass "%SSH_KEY_PASSPHRASE%"
scp %* <nul
set "_CMD_RC=%errorlevel%"
call :fn_cleanup_askpass
exit /b %_CMD_RC%


:help
echo.
echo Usage:
echo   deploy.bat                  - interactive menu
echo   deploy.bat 1^|2^|3^|0       - run selected action directly
echo   deploy.bat --auto           - automatic mode ^(default action=2, commit=y, msg=AutoDeploy^)
echo   deploy.bat --auto 2 n       - automatic code deploy without auto-commit
echo   deploy.bat --auto 3 y       - automatic safe deploy ^(no DB import, migrations only^) with auto-commit
echo   deploy.bat --auto 3 y MyMsg - automatic mode with custom commit message
echo.
echo Examples:
echo   deploy.bat --auto
echo   deploy.bat --auto 2 n
echo.
endlocal
exit /b 0
