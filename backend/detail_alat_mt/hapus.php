<?php
/**
 * backend/detail_alat_mt/hapus.php
 * Menghapus satu baris detail alat dari maintenance.
 */

session_start();
include __DIR__ . '/../config/connect.php';
include __DIR__ . '/../config/auth_check.php';

$id_detail = (int)($_GET['id']    ?? 0);
$id_mt     = (int)($_GET['id_mt'] ?? 0);

if ($id_detail > 0) {
    $hasil = mysqli_query($conn, "DELETE FROM detail_alat_mt WHERE id_detail = $id_detail");
    header("Location: ../../templates/maintenance/detail.php?id=$id_mt&pesan=" .
           ($hasil ? 'alat_dihapus' : 'alat_hapus_gagal'));
} else {
    header("Location: ../../templates/maintenance/index.php");
}
exit;
