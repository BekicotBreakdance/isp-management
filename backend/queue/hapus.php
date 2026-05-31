<?php
/**
 * backend/queue/hapus.php
 * Menghapus data queue / Mikrotik.
 */

session_start();
include __DIR__ . '/../config/connect.php';
include __DIR__ . '/../config/auth_check.php';

$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {
    $hasil = mysqli_query($conn, "DELETE FROM queue WHERE id_queue = $id");
    header($hasil
        ? "Location: ../../templates/queue/index.php?pesan=hapus_berhasil"
        : "Location: ../../templates/queue/index.php?pesan=hapus_gagal"
    );
} else {
    header("Location: ../../templates/queue/index.php");
}
exit;
