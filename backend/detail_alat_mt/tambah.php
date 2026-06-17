<?php
// Tambah detail alat ke maintenance tertentu
session_start();
include __DIR__ . '/../config/connect.php';
include __DIR__ . '/../config/auth_check.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_mt   = (int)$_POST['id_mt'];
    $id_alat = (int)$_POST['id_alat'];
    $jumlah  = (int)$_POST['jumlah'];

    $query = "INSERT INTO detail_alat_mt (id_mt, id_alat, jumlah)
              VALUES ($id_mt, $id_alat, $jumlah)";
    $hasil = mysqli_query($conn, $query);

    header("Location: ../../templates/maintenance/detail.php?id=$id_mt&pesan=" .
           ($hasil ? 'alat_ditambahkan' : 'alat_gagal'));
} else {
    header("Location: ../../templates/maintenance/index.php");
}
exit;
