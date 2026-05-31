<?php
/**
 * backend/maintenance/hapus.php
 * Menghapus data maintenance.
 * Cascade: hapus dulu semua detail_alat_mt terkait, baru hapus maintenance.
 */

session_start();
include __DIR__ . '/../config/connect.php';
include __DIR__ . '/../config/auth_check.php';

$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {

    // Hapus dulu semua detail alat yang terkait maintenance ini (cascade manual)
    mysqli_query($conn, "DELETE FROM detail_alat_mt WHERE id_mt = $id");

    // Baru hapus maintenance-nya
    $hasil = mysqli_query($conn, "DELETE FROM maintenance WHERE id_mt = $id");
    header($hasil
        ? "Location: ../../templates/maintenance/index.php?pesan=hapus_berhasil"
        : "Location: ../../templates/maintenance/index.php?pesan=hapus_gagal"
    );

} else {
    header("Location: ../../templates/maintenance/index.php");
}
exit;
