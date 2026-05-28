<?php
include __DIR__ . '/../config/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_router = (int)$_POST['id_router'];
    $merk      = mysqli_real_escape_string($conn, $_POST['merk']);
    $harga     = (int)$_POST['harga'];

    $query = "UPDATE router SET merk = '$merk', harga = $harga WHERE id_router = $id_router";
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: ../../templates/router/index.php?pesan=edit_berhasil");
    } else {
        header("Location: ../../templates/router/index.php?pesan=edit_gagal");
    }
} else {
    header("Location: ../../templates/router/index.php");
}
exit;
