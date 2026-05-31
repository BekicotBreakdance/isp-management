<?php
/**
 * backend/teknisi/hapus.php
 * Menghapus data teknisi.
 * Validasi: teknisi tidak bisa dihapus jika masih punya riwayat maintenance.
 */

session_start();
include __DIR__ . '/../config/connect.php';
include __DIR__ . '/../config/auth_check.php';

$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {

    // Cek apakah teknisi masih punya riwayat maintenance
    $cek = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM maintenance WHERE id_teknisi = $id"))['c'];

    if ($cek > 0) {
        header("Location: ../../templates/teknisi/index.php?pesan=hapus_gagal_relasi");
        exit;
    }

    $hasil = mysqli_query($conn, "DELETE FROM teknisi WHERE id_teknisi = $id");
    header($hasil
        ? "Location: ../../templates/teknisi/index.php?pesan=hapus_berhasil"
        : "Location: ../../templates/teknisi/index.php?pesan=hapus_gagal"
    );

} else {
    header("Location: ../../templates/teknisi/index.php");
}
exit;
