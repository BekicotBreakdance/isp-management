<?php

// Sertakan file koneksi database
include __DIR__ . '/../config/connect.php';

// Ambil id dari URL (GET parameter)
if (isset($_GET['id'])) {

    $id_queue = (int)$_GET['id'];

    // Buat query DELETE
    $query = "DELETE FROM queue WHERE id_queue = $id_queue";

    // Jalankan query
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: ../../templates/queue/index.php?pesan=hapus_berhasil");
    } else {
        header("Location: ../../templates/queue/index.php?pesan=hapus_gagal");
    }

} else {
    header("Location: ../../templates/queue/index.php");
}

exit;
?>
