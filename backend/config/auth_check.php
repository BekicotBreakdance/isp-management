<?php
/**
 * auth_check.php
 * Guard sederhana untuk backend yang butuh autentikasi.
 * Include file ini di bagian atas setiap file backend sensitif.
 *
 * Cara pakai:
 *   session_start();
 *   include __DIR__ . '/../config/auth_check.php';
 */

if (!isset($_SESSION['user'])) {
    // Redirect ke halaman login jika belum login
    header('Location: /isp-management/templates/auth/login.php');
    exit;
}
