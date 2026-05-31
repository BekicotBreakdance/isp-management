<?php
/**
 * backend/pelanggan/hapus.php
 * Menghapus data pelanggan dari database.
 * Validasi: pelanggan tidak bisa dihapus jika masih punya
 *   data billing, queue, atau maintenance aktif.
 */

session_start();
include __DIR__ . '/../config/connect.php';
include __DIR__ . '/../config/auth_check.php';

$id = (int)($_GET['id'] ?? 0);

if ($id > 0) {

    // Cek apakah pelanggan masih punya data di tabel lain
    $cek_billing     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM billing     WHERE id_pelanggan = $id"))['c'];
    $cek_queue       = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM queue       WHERE id_pelanggan = $id"))['c'];
    $cek_maintenance = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM maintenance WHERE id_pelanggan = $id"))['c'];

    if ($cek_billing > 0 || $cek_queue > 0 || $cek_maintenance > 0) {
        // Ada relasi — tidak bisa dihapus, beri pesan informatif
        header("Location: ../../templates/pelanggan/index.php?pesan=hapus_gagal_relasi");
        exit;
    }

    // Aman untuk dihapus
    $hasil = mysqli_query($conn, "DELETE FROM pelanggan WHERE id_pelanggan = $id");
    header($hasil
        ? "Location: ../../templates/pelanggan/index.php?pesan=hapus_berhasil"
        : "Location: ../../templates/pelanggan/index.php?pesan=hapus_gagal"
    );

} else {
    header("Location: ../../templates/pelanggan/index.php");
}
exit;
