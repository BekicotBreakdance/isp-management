<?php

// Sertakan file koneksi database
include __DIR__. '/../config/connect.php';

// Cek apakah request method adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil dan bersihkan data dari form
    $id_paket            = (int)$_POST['id_paket'];
    $jenis_paket         = mysqli_real_escape_string($conn, $_POST['jenis_paket']);
    $kecepatan_bandwidth = (int)$_POST['kecepatan_bandwidth'];
    $harga               = (int)$_POST['harga'];

    // Buat query UPDATE
    $query = "UPDATE paket
              SET jenis_paket         = '$jenis_paket',
                  kecepatan_bandwidth = $kecepatan_bandwidth,
                  harga               = $harga
              WHERE id_paket = $id_paket";

    // Jalankan query
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: ../../templates/paket/index.php?pesan=edit_berhasil");
    } else {
        header("Location: ../../templates/paket/index.php?pesan=edit_gagal");
    }

} else {
    header("Location: ../../templates/paket/index.php");
}

exit;
?>
