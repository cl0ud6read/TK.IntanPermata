@echo off
echo ========================================================
echo   MENGIRIM KODE KE GITHUB UNTUK ANGGOTA KELOMPOK
echo ========================================================
echo.
echo Pastikan Anda sudah membuat repository KOSONG di GitHub.com
set /p url="Masukkan Link Repository GitHub Anda (contoh: https://github.com/nama/repo.git): "

echo.
echo Menyambungkan ke GitHub...
"C:\Program Files\Git\cmd\git.exe" remote remove origin 2>nul
"C:\Program Files\Git\cmd\git.exe" remote add origin %url%

echo Mengirim kode ke internet...
"C:\Program Files\Git\cmd\git.exe" push -u origin main

echo.
echo Jika tidak ada tulisan error merah, maka kode Anda BERHASIL diunggah ke GitHub!
echo Anggota kelompok Anda sekarang bisa meng-clone atau mem-pull kode tersebut.
echo ========================================================
pause
