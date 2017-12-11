CHECKRES

Dibuat dalam rangka memenuhi tugas RPL.

Bisa cek beberapa resi dalam satu waktu menggunakan API AfterShip.

Beberapa data disimpan di database untuk beberapa keperluan.

Sistemnya:
1. Input nomor resi
2. Cek apakah nomor resi yang diinputkan sudah ada di akun AfterShip.
a) Jika sudah ada, maka tidak perlu insert ke database. Hapus history tracking dan masukkan history baru
b) Jika belum ada, maka:
1) Tambahkan nomor resi ke akun AfterShip.
2) Cek apakah checkpoint nya kosong atau tidak.
(a) Jika kosong, maka nomor resi tidak ditemukan.
(b) Jika tidak, maka ambil data dan tampilkan.

Dibuat menggunakan PHP, dan agak hardcode, jadi mohon maaf.

Yang mau clone, selamat clone.
