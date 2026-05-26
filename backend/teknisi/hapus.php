<?php

// Sertakan file koneksi database
include __DIR__ . '/../config/connect.php';

// Ambil id dari URL (GET parameter)
if (isset($_GET['id'])) {

    $id_teknisi = (int)$_GET['id'];

    // Buat query DELETE
    $query = "DELETE FROM teknisi WHERE id_teknisi = $id_teknisi";

    // Jalankan query
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: ../../templates/teknisi/index.php?pesan=hapus_berhasil");
    } else {
        header("Location: ../../templates/teknisi/index.php?pesan=hapus_gagal");
    }

} else {
    header("Location: ../../templates/teknisi/index.php");
}

exit;
?>
