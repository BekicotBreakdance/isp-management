<?php

// Sertakan file koneksi database
session_start();
include __DIR__ . '/../config/connect.php';
include __DIR__ . '/../config/auth_check.php';

// Cek apakah request method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil dan bersihkan data dari form
    $id_billing      = (int)$_POST['id_billing'];
    $tanggal_tagihan = mysqli_real_escape_string($conn, $_POST['tanggal_tagihan']);
    $tanggal_bayar   = !empty($_POST['tanggal_bayar'])
                        ? "'" . mysqli_real_escape_string($conn, $_POST['tanggal_bayar']) . "'"
                        : 'NULL';
    $status          = mysqli_real_escape_string($conn, $_POST['status']);
    $id_pelanggan    = (int)$_POST['id_pelanggan'];

    // Buat query UPDATE
    $query = "UPDATE billing
              SET tanggal_tagihan = '$tanggal_tagihan',
                  tanggal_bayar  = $tanggal_bayar,
                  status         = '$status',
                  id_pelanggan   = $id_pelanggan
              WHERE id_billing = $id_billing";

    // Jalankan query
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: ../../templates/billing/index.php?pesan=edit_berhasil");
    } else {
        header("Location: ../../templates/billing/index.php?pesan=edit_gagal");
    }

} else {
    header("Location: ../../templates/billing/index.php");
}

exit;
?>
