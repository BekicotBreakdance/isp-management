<?php

// Sertakan file koneksi database
include __DIR__ . '/../config/connect.php';

// Ambil id dari URL (GET parameter)
if (isset($_GET['id'])) {

    $id_billing = (int)$_GET['id'];

    // Buat query DELETE
    $query = "DELETE FROM billing WHERE id_billing = $id_billing";

    // Jalankan query
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: ../../templates/billing/index.php?pesan=hapus_berhasil");
    } else {
        header("Location: ../../templates/billing/index.php?pesan=hapus_gagal");
    }

} else {
    header("Location: ../../templates/billing/index.php");
}

exit;
?>
