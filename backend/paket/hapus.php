<?php

// Sertakan file koneksi database
include __DIR__ . '/../config/connect.php';

// Ambil id dari URL (GET parameter)
if (isset($_GET['id'])) {

    $id_paket = (int)$_GET['id'];

    // Buat query DELETE
    $query = "DELETE FROM paket WHERE id_paket = $id_paket";

    // Jalankan query
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: ../../templates/paket/index.php?pesan=hapus_berhasil");
    } else {
        header("Location: ../../templates/paket/index.php?pesan=hapus_gagal");
    }

} else {
    header("Location: ../../templates/paket/index.php");
}

exit;
?>
