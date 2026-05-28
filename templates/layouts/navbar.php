<?php
// Navbar — include di setiap halaman setelah sidebar
$username = $_SESSION['user']['username'] ?? 'Admin';
$initial  = strtoupper(substr($username, 0, 1));
?>
<nav class="navbar-top">

    <!-- Search -->
    <div class="navbar-search">
        <span class="search-icon">🔍</span>
        <input type="text" placeholder="Cari pelanggan, paket...">
    </div>

    <!-- Right side -->
    <div class="navbar-right">

        <!-- Notifikasi -->
        <div class="navbar-notif">
            🔔
            <span class="notif-badge">3</span>
        </div>

        <!-- User -->
        <div class="navbar-user">
            <div class="user-avatar"><?= htmlspecialchars($initial) ?></div>
            <div class="user-info">
                <div class="user-name"><?= htmlspecialchars($username) ?></div>
                <div class="user-role">Administrator</div>
            </div>
        </div>

    </div>
</nav>
