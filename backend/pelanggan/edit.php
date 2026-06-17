<?php

// Sertakan file koneksi database
session_start();
include __DIR__ . '/../config/connect.php';
include __DIR__ . '/../config/auth_check.php';

// Cek apakah request method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil dan bersihkan data dari form
    $id_pelanggan = (int)$_POST['id_pelanggan'];
    $nama         = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat       = mysqli_real_escape_string($conn, $_POST['alamat']);
    $id_modem     = !empty($_POST['id_modem'])  ? (int)$_POST['id_modem']  : 'NULL';
    $id_router    = !empty($_POST['id_router']) ? (int)$_POST['id_router'] : 'NULL';
    $id_paket     = (int)$_POST['id_paket'];
    $status       = mysqli_real_escape_string($conn, $_POST['status'] ?? 'Aktif');

    // Buat query UPDATE
    $query = "UPDATE pelanggan
              SET nama       = '$nama',
                  alamat     = '$alamat',
                  id_modem   = $id_modem,
                  id_router  = $id_router,
                  id_paket   = $id_paket,
                  status     = '$status'
              WHERE id_pelanggan = $id_pelanggan";

    // Jalankan query
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        // Redirect ke halaman daftar pelanggan jika berhasil
        header("Location: ../../templates/pelanggan/index.php?pesan=edit_berhasil");
    } else {
        // Redirect dengan pesan error jika gagal
        header("Location: ../../templates/pelanggan/index.php?pesan=edit_gagal");
    }

} else {
    // Jika bukan POST, redirect ke halaman pelanggan
    header("Location: ../../templates/pelanggan/index.php");
}

exit;
?>
