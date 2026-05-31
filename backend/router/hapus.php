<?php
/**
 * backend/router/hapus.php
 * Menghapus data router.
 * Validasi: router tidak bisa dihapus jika masih dipasang di pelanggan.
 */

session_start();
include __DIR__ . '/../config/connect.php';
include __DIR__ . '/../config/auth_check.php';

$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {

    // Cek apakah router masih digunakan pelanggan
    $cek = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM pelanggan WHERE id_router = $id"))['c'];

    if ($cek > 0) {
        header("Location: ../../templates/router/index.php?pesan=hapus_gagal_relasi");
        exit;
    }

    $hasil = mysqli_query($conn, "DELETE FROM router WHERE id_router = $id");
    header($hasil
        ? "Location: ../../templates/router/index.php?pesan=hapus_berhasil"
        : "Location: ../../templates/router/index.php?pesan=hapus_gagal"
    );

} else {
    header("Location: ../../templates/router/index.php");
}
exit;
