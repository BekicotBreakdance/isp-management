<?php

// Sertakan file koneksi database
include __DIR__ . '/../config/connect.php';

// Cek apakah request method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil dan bersihkan data dari form
    $id_teknisi    = (int)$_POST['id_teknisi'];
    $nama          = mysqli_real_escape_string($conn, $_POST['nama']);
    $alamat        = mysqli_real_escape_string($conn, $_POST['alamat']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);

    // Buat query UPDATE
    $query = "UPDATE teknisi
              SET nama          = '$nama',
                  alamat        = '$alamat',
                  jenis_kelamin = '$jenis_kelamin'
              WHERE id_teknisi = $id_teknisi";

    // Jalankan query
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: ../../templates/teknisi/index.php?pesan=edit_berhasil");
    } else {
        header("Location: ../../templates/teknisi/index.php?pesan=edit_gagal");
    }

} else {
    header("Location: ../../templates/teknisi/index.php");
}

exit;
?>
