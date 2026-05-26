<?php

// Sertakan file koneksi database
include __DIR__ . '/../config/connect.php';

// Cek apakah request method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil dan bersihkan data dari form
    $nama           = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat         = mysqli_real_escape_string($conn, $_POST['alamat']);
    $jenis_kelamin  = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);

    // Buat query INSERT
    $query = "INSERT INTO teknisi (nama, alamat, jenis_kelamin)
              VALUES ('$nama', '$alamat', '$jenis_kelamin')";

    // Jalankan query
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: ../../templates/teknisi/index.php?pesan=tambah_berhasil");
    } else {
        header("Location: ../../templates/teknisi/index.php?pesan=tambah_gagal");
    }

} else {
    header("Location: ../../templates/teknisi/index.php");
}

exit;
?>
