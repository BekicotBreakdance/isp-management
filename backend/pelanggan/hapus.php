<?php

// Sertakan file koneksi database
include __DIR__ . '/../config/connect.php';

// Ambil id dari URL (GET parameter)
if (isset($_GET['id'])) {

    $id_pelanggan = (int)$_GET['id'];

    // Buat query DELETE
    $query = "DELETE FROM pelanggan WHERE id_pelanggan = $id_pelanggan";

    // Jalankan query
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        // Redirect ke halaman daftar pelanggan jika berhasil
        header("Location: ../../templates/pelanggan/index.php?pesan=hapus_berhasil");
    } else {
        // Redirect dengan pesan error jika gagal
        header("Location: ../../templates/pelanggan/index.php?pesan=hapus_gagal");
    }

} else {
    // Jika tidak ada id, redirect ke halaman pelanggan
    header("Location: ../../templates/pelanggan/index.php");
}

exit;
?>
