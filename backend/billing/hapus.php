<?php
/**
 * backend/billing/hapus.php
 * Menghapus data tagihan billing.
 */

session_start();
include __DIR__ . '/../config/connect.php';
include __DIR__ . '/../config/auth_check.php';

$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {
    $hasil = mysqli_query($conn, "DELETE FROM billing WHERE id_billing = $id");
    header($hasil
        ? "Location: ../../templates/billing/index.php?pesan=hapus_berhasil"
        : "Location: ../../templates/billing/index.php?pesan=hapus_gagal"
    );
} else {
    header("Location: ../../templates/billing/index.php");
}
exit;
