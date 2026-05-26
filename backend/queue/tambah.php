<?php

// Sertakan file koneksi database
include __DIR__ . '/../config/connect.php';

// Cek apakah request method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil dan bersihkan data dari form
    $ip_address         = mysqli_real_escape_string($conn, $_POST['ip_address']);
    $jenis_ip           = mysqli_real_escape_string($conn, $_POST['jenis_ip']);
    $username_mikrotik  = mysqli_real_escape_string($conn, $_POST['username_mikrotik']);
    $id_pelanggan       = (int)$_POST['id_pelanggan'];

    // Buat query INSERT
    $query = "INSERT INTO queue (ip_address, jenis_ip, username_mikrotik, id_pelanggan)
              VALUES ('$ip_address', '$jenis_ip', '$username_mikrotik', $id_pelanggan)";

    // Jalankan query
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: ../../templates/queue/index.php?pesan=tambah_berhasil");
    } else {
        header("Location: ../../templates/queue/index.php?pesan=tambah_gagal");
    }

} else {
    header("Location: ../../templates/queue/index.php");
}

exit;
?>
