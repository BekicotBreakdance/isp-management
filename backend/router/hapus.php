<?php
include __DIR__ . '/../config/connect.php';

$id_router = (int)($_GET['id'] ?? 0);

if ($id_router > 0) {
    $query = "DELETE FROM router WHERE id_router = $id_router";
    $hasil = mysqli_query($conn, $query);

    if ($hasil) {
        header("Location: ../../templates/router/index.php?pesan=hapus_berhasil");
    } else {
        header("Location: ../../templates/router/index.php?pesan=hapus_gagal");
    }
} else {
    header("Location: ../../templates/router/index.php");
}
exit;
