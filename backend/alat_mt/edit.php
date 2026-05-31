<?php
include __DIR__ . '/../config/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_alat   = (int)$_POST['id_alat'];
    $nama_alat = mysqli_real_escape_string($conn, $_POST['nama_alat']);

    $query = "UPDATE alat_mt SET nama_alat = '$nama_alat' WHERE id_alat = $id_alat";
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: ../../templates/alat_mt/index.php?pesan=edit_berhasil");
    } else {
        header("Location: ../../templates/alat_mt/index.php?pesan=edit_gagal");
    }
} else {
    header("Location: ../../templates/alat_mt/index.php");
}
exit;
