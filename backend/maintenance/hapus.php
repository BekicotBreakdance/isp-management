<?php

// Sertakan file koneksi database
include __DIR__ . '/../config/connect.php';

// Ambil id dari URL (GET parameter)
if (isset($_GET['id'])) {

    $id_mt = (int)$_GET['id'];

    // Buat query DELETE
    $query = "DELETE FROM maintenance WHERE id_mt = $id_mt";

    // Jalankan query
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: ../../templates/maintenance/index.php?pesan=hapus_berhasil");
    } else {
        header("Location: ../../templates/maintenance/index.php?pesan=hapus_gagal");
    }

} else {
    header("Location: ../../templates/maintenance/index.php");
}

exit;
?>
