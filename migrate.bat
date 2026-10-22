@echo off
setlocal
cd /d "%~dp0"

set "PHP_BIN=php"
if exist "%~dp0..\..\php\php.exe" set "PHP_BIN=%~dp0..\..\php\php.exe"

"%PHP_BIN%" spark migrate
if errorlevel 1 (
    echo.
    echo Migration failed. Check the database settings in .env and the error above.
    exit /b 1
)

echo.
echo Database migrations completed.
exit /b 0
