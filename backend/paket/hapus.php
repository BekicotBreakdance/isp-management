<?php
/**
 * backend/paket/hapus.php
 * Menghapus data paket internet.
 * Validasi: paket tidak bisa dihapus jika masih dipakai pelanggan.
 */

session_start();
include __DIR__ . '/../config/connect.php';
include __DIR__ . '/../config/auth_check.php';

$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {

    // Cek apakah paket masih dipakai pelanggan
    $cek = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM pelanggan WHERE id_paket = $id"))['c'];

    if ($cek > 0) {
        header("Location: ../../templates/paket/index.php?pesan=hapus_gagal_relasi");
        exit;
    }

    $hasil = mysqli_query($conn, "DELETE FROM paket WHERE id_paket = $id");
    header($hasil
        ? "Location: ../../templates/paket/index.php?pesan=hapus_berhasil"
        : "Location: ../../templates/paket/index.php?pesan=hapus_gagal"
    );

} else {
    header("Location: ../../templates/paket/index.php");
}
exit;
