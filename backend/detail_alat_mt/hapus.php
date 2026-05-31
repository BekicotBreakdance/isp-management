<?php
include __DIR__ . '/../config/connect.php';

$id_detail = (int)($_GET['id'] ?? 0);
$id_mt     = (int)($_GET['id_mt'] ?? 0);

if ($id_detail > 0) {
    $query = "DELETE FROM detail_alat_mt WHERE id_detail = $id_detail";
    $hasil = mysqli_query($conn, $query);
    header("Location: ../../templates/maintenance/detail.php?id=$id_mt&pesan=" .
           ($hasil ? 'alat_dihapus' : 'alat_hapus_gagal'));
} else {
    header("Location: ../../templates/maintenance/index.php");
}
exit;
