<?php

// Sertakan file koneksi database
include __DIR__ . '/../config/connect.php';

// Cek apakah request method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil dan bersihkan data dari form
    $nama       = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat     = mysqli_real_escape_string($conn, $_POST['alamat']);
    $id_modem   = !empty($_POST['id_modem'])  ? (int)$_POST['id_modem']  : 'NULL';
    $id_router  = !empty($_POST['id_router']) ? (int)$_POST['id_router'] : 'NULL';
    $id_paket   = (int)$_POST['id_paket'];

    // Buat query INSERT
    $query = "INSERT INTO pelanggan (nama, alamat, id_modem, id_router, id_paket)
              VALUES ('$nama', '$alamat', $id_modem, $id_router, $id_paket)";

    // Jalankan query
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        // Redirect ke halaman daftar pelanggan jika berhasil
        header("Location: ../../templates/pelanggan/index.php?pesan=tambah_berhasil");
    } else {
        // Redirect dengan pesan error jika gagal
        header("Location: ../../templates/pelanggan/index.php?pesan=tambah_gagal");
    }

} else {
    // Jika bukan POST, redirect ke halaman pelanggan
    header("Location: ../../templates/pelanggan/index.php");
}

exit;
?>
