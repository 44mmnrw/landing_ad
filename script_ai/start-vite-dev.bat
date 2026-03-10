@echo off
setlocal

cd /d "%~dp0.."

if not exist "node_modules\.bin\vite" (
	echo [INFO] Vite is not installed yet. Installing dependencies...
	npm install
	if errorlevel 1 (
		echo [ERROR] Failed to install dependencies.
		pause
		exit /b 1
	)
)

echo [INFO] Starting Vite dev server...
echo [INFO] Project: %CD%
echo.

npm run dev

echo.
echo [INFO] Vite dev server stopped.
pause
