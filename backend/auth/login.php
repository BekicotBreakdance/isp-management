<?php
// Simple login handler for student project
include __DIR__ . '/../config/connect.php';
session_start();

// Create users table if not exists
$create_sql = "CREATE TABLE IF NOT EXISTS users (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
mysqli_query($conn, $create_sql);

// Ensure default admin exists
$check = mysqli_query($conn, "SELECT COUNT(*) AS c FROM users");
$row = mysqli_fetch_assoc($check);
if ($row['c'] == 0) {
    $default_user = 'admin';
    $default_pass = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, 'ss', $default_user, $default_pass);
    mysqli_stmt_execute($stmt);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Fetch user
    $stmt = mysqli_prepare($conn, "SELECT id, username, password FROM users WHERE username = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $user, $hash);
    if (mysqli_stmt_fetch($stmt)) {
        if (password_verify($password, $hash ?? '')) {
            // success
            $_SESSION['user'] = ['id' => $id, 'username' => $user];
            header('Location: /isp-management/templates/dashboard/index.php');
            exit;
        }
    }
    // failed
    header('Location: /isp-management/templates/auth/login.html?pesan=invalid');
    exit;
} else {
    header('Location: /isp-management/templates/auth/login.html');
    exit;
}
