<?php
/**
 * backend/modem/hapus.php
 * Menghapus data modem.
 * Validasi: modem tidak bisa dihapus jika masih dipasang di pelanggan.
 */

session_start();
include __DIR__ . '/../config/connect.php';
include __DIR__ . '/../config/auth_check.php';

$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {

    // Cek apakah modem masih digunakan pelanggan
    $cek = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM pelanggan WHERE id_modem = $id"))['c'];

    if ($cek > 0) {
        header("Location: ../../templates/modem/index.php?pesan=hapus_gagal_relasi");
        exit;
    }

    $hasil = mysqli_query($conn, "DELETE FROM modem WHERE id_modem = $id");
    header($hasil
        ? "Location: ../../templates/modem/index.php?pesan=hapus_berhasil"
        : "Location: ../../templates/modem/index.php?pesan=hapus_gagal"
    );

} else {
    header("Location: ../../templates/modem/index.php");
}
exit;
