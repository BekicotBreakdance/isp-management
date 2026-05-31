<?php
include __DIR__ . '/../config/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_alat = mysqli_real_escape_string($conn, $_POST['nama_alat']);

    $query = "INSERT INTO alat_mt (nama_alat) VALUES ('$nama_alat')";
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: ../../templates/alat_mt/index.php?pesan=tambah_berhasil");
    } else {
        header("Location: ../../templates/alat_mt/index.php?pesan=tambah_gagal");
    }
} else {
    header("Location: ../../templates/alat_mt/index.php");
}
exit;
