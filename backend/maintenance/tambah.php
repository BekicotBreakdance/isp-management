<?php

// Sertakan file koneksi database
include __DIR__ . '/../config/connect.php';

// Cek apakah request method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil dan bersihkan data dari form
    $id_teknisi            = (int)$_POST['id_teknisi'];
    $id_pelanggan          = (int)$_POST['id_pelanggan'];
    $tanggal_mt            = mysqli_real_escape_string($conn, $_POST['tanggal_mt']);
    $detail_kendala_singkat = mysqli_real_escape_string($conn, $_POST['detail_kendala_singkat']);

    // Buat query INSERT
    $query = "INSERT INTO maintenance (id_teknisi, id_pelanggan, tanggal_mt, detail_kendala_singkat)
              VALUES ($id_teknisi, $id_pelanggan, '$tanggal_mt', '$detail_kendala_singkat')";

    // Jalankan query
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: ../../templates/maintenance/index.php?pesan=tambah_berhasil");
    } else {
        header("Location: ../../templates/maintenance/index.php?pesan=tambah_gagal");
    }

} else {
    header("Location: ../../templates/maintenance/index.php");
}

exit;
?>
