<?php
include __DIR__ . '/../config/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $merk  = mysqli_real_escape_string($conn, $_POST['merk']);
    $harga = (int)$_POST['harga'];

    $query = "INSERT INTO router (merk, harga) VALUES ('$merk', $harga)";
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: ../../templates/router/index.php?pesan=tambah_berhasil");
    } else {
        header("Location: ../../templates/router/index.php?pesan=tambah_gagal");
    }
} else {
    header("Location: ../../templates/router/index.php");
}
exit;
