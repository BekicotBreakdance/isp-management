<?php

// Sertakan file koneksi database
include __DIR__ . '/../config/connect.php';

// Cek apakah request method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil dan bersihkan data dari form
    $tanggal_tagihan = mysqli_real_escape_string($conn, $_POST['tanggal_tagihan']);
    $tanggal_bayar   = !empty($_POST['tanggal_bayar'])
                        ? "'" . mysqli_real_escape_string($conn, $_POST['tanggal_bayar']) . "'"
                        : 'NULL';
    $status          = mysqli_real_escape_string($conn, $_POST['status']);
    $id_pelanggan    = (int)$_POST['id_pelanggan'];

    // Buat query INSERT
    $query = "INSERT INTO billing (tanggal_tagihan, tanggal_bayar, status, id_pelanggan)
              VALUES ('$tanggal_tagihan', $tanggal_bayar, '$status', $id_pelanggan)";

    // Jalankan query
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: ../../templates/billing/index.php?pesan=tambah_berhasil");
    } else {
        header("Location: ../../templates/billing/index.php?pesan=tambah_gagal");
    }

} else {
    header("Location: ../../templates/billing/index.php");
}

exit;
?>
