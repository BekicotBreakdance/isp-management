<?php

// Sertakan file koneksi database
include __DIR__ . '/../config/connect.php';

// Cek apakah request method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil dan bersihkan data dari form
    $id_mt                 = (int)$_POST['id_mt'];
    $id_teknisi            = (int)$_POST['id_teknisi'];
    $id_pelanggan          = (int)$_POST['id_pelanggan'];
    $tanggal_mt            = mysqli_real_escape_string($conn, $_POST['tanggal_mt']);
    $detail_kendala_singkat = mysqli_real_escape_string($conn, $_POST['detail_kendala_singkat']);
    $status                 = mysqli_real_escape_string($conn, $_POST['status'] ?? 'Proses');

    // Buat query UPDATE
    $query = "UPDATE maintenance
              SET id_teknisi             = $id_teknisi,
                  id_pelanggan           = $id_pelanggan,
                  tanggal_mt             = '$tanggal_mt',
                  detail_kendala_singkat = '$detail_kendala_singkat',
                  status                 = '$status'
              WHERE id_mt = $id_mt";

    // Jalankan query
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: ../../templates/maintenance/index.php?pesan=edit_berhasil");
    } else {
        header("Location: ../../templates/maintenance/index.php?pesan=edit_gagal");
    }

} else {
    header("Location: ../../templates/maintenance/index.php");
}

exit;
?>
