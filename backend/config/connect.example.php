<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "isp_management"
);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>