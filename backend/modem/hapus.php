<?php

// Sertakan file koneksi database
include __DIR__ . '/../config/connect.php';

// Ambil id dari URL (GET parameter)
if (isset($_GET['id'])) {

    $id_modem = (int)$_GET['id'];

    // Buat query DELETE
    $query = "DELETE FROM modem WHERE id_modem = $id_modem";

    // Jalankan query
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: ../../templates/modem/index.php?pesan=hapus_berhasil");
    } else {
        header("Location: ../../templates/modem/index.php?pesan=hapus_gagal");
    }

} else {
    header("Location: ../../templates/modem/index.php");
}

exit;
?>
