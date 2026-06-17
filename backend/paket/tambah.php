<?php

// Sertakan file koneksi database
session_start();
include __DIR__ . '/../config/connect.php';
include __DIR__ . '/../config/auth_check.php';

// Cek apakah request method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil dan bersihkan data dari form
    $jenis_paket         = mysqli_real_escape_string($conn, $_POST['jenis_paket']);
    $kecepatan_bandwidth = (int)$_POST['kecepatan_bandwidth'];
    $harga               = (int)$_POST['harga'];

    // Buat query INSERT
    $query = "INSERT INTO paket (jenis_paket, kecepatan_bandwidth, harga)
              VALUES ('$jenis_paket', $kecepatan_bandwidth, $harga)";

    // Jalankan query
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: ../../templates/paket/index.php?pesan=tambah_berhasil");
    } else {
        header("Location: ../../templates/paket/index.php?pesan=tambah_gagal");
    }

} else {
    header("Location: ../../templates/paket/index.php");
}

exit;
?>
