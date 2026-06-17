<?php

// Sertakan file koneksi database
session_start();
include __DIR__ . '/../config/connect.php';
include __DIR__ . '/../config/auth_check.php';

// Cek apakah request method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil dan bersihkan data dari form
    $id_modem = (int)$_POST['id_modem'];
    $merk     = mysqli_real_escape_string($conn, $_POST['merk']);
    $harga    = (int)$_POST['harga'];

    // Buat query UPDATE
    $query = "UPDATE modem
              SET merk  = '$merk',
                  harga = $harga
              WHERE id_modem = $id_modem";

    // Jalankan query
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: ../../templates/modem/index.php?pesan=edit_berhasil");
    } else {
        header("Location: ../../templates/modem/index.php?pesan=edit_gagal");
    }

} else {
    header("Location: ../../templates/modem/index.php");
}

exit;
?>
