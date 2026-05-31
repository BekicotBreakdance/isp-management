<?php
include __DIR__ . '/../config/connect.php';

$id_alat = (int)($_GET['id'] ?? 0);
if ($id_alat > 0) {
    $query = "DELETE FROM alat_mt WHERE id_alat = $id_alat";
    $hasil = mysqli_query($conn, $query);
    header($hasil
        ? "Location: ../../templates/alat_mt/index.php?pesan=hapus_berhasil"
        : "Location: ../../templates/alat_mt/index.php?pesan=hapus_gagal"
    );
} else {
    header("Location: ../../templates/alat_mt/index.php");
}
exit;
