<?php
/**
 * backend/alat_mt/hapus.php
 * Menghapus data alat maintenance.
 * Validasi: alat tidak bisa dihapus jika masih dipakai di detail maintenance.
 */

session_start();
include __DIR__ . '/../config/connect.php';
include __DIR__ . '/../config/auth_check.php';

$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {

    // Cek apakah alat masih dipakai di detail_alat_mt
    $cek = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM detail_alat_mt WHERE id_alat = $id"))['c'];

    if ($cek > 0) {
        header("Location: ../../templates/alat_mt/index.php?pesan=hapus_gagal_relasi");
        exit;
    }

    $hasil = mysqli_query($conn, "DELETE FROM alat_mt WHERE id_alat = $id");
    header($hasil
        ? "Location: ../../templates/alat_mt/index.php?pesan=hapus_berhasil"
        : "Location: ../../templates/alat_mt/index.php?pesan=hapus_gagal"
    );

} else {
    header("Location: ../../templates/alat_mt/index.php");
}
exit;
