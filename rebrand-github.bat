@echo off
echo ========================================================
echo   MENGHAPUS JEJAK LAMA DAN MENGIRIM KODE KE GITHUB
echo ========================================================
echo.
echo Pastikan Anda sudah membuat repository KOSONG di GitHub.com
set /p url="Masukkan Link Repository GitHub Anda (contoh: https://github.com/cl0ud6read/TK.IntanPermata.git): "

echo.
echo Menghapus riwayat Git lama...
rd /s /q .git

echo Menginisialisasi identitas baru...
"C:\Program Files\Git\cmd\git.exe" config --global user.name "Intan Permata"
"C:\Program Files\Git\cmd\git.exe" config --global user.email "intan@admin.com"

"C:\Program Files\Git\cmd\git.exe" init
"C:\Program Files\Git\cmd\git.exe" add .
"C:\Program Files\Git\cmd\git.exe" commit -m "Initial Commit - TK.IntanPermata"
"C:\Program Files\Git\cmd\git.exe" branch -M main

echo.
echo Menyambungkan ke GitHub...
"C:\Program Files\Git\cmd\git.exe" remote add origin %url%

echo Mengirim kode ke internet secara paksa (force)...
"C:\Program Files\Git\cmd\git.exe" push -u origin main --force

echo.
echo ========================================================
echo SELESAI! Semua jejak lama sudah terhapus bersih dari GitHub.
echo ========================================================
pause
