<?php

// Sertakan file koneksi database
session_start();
include __DIR__ . '/../config/connect.php';
include __DIR__ . '/../config/auth_check.php';

// Cek apakah request method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil dan bersihkan data dari form
    $merk  = mysqli_real_escape_string($conn, $_POST['merk']);
    $harga = (int)$_POST['harga'];

    // Buat query INSERT
    $query = "INSERT INTO modem (merk, harga)
              VALUES ('$merk', $harga)";

    // Jalankan query
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: ../../templates/modem/index.php?pesan=tambah_berhasil");
    } else {
        header("Location: ../../templates/modem/index.php?pesan=tambah_gagal");
    }

} else {
    header("Location: ../../templates/modem/index.php");
}

exit;
?>
