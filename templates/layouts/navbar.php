<?php
// Navbar — include di setiap halaman setelah sidebar
$username = $_SESSION['user']['username'] ?? 'Admin';
$initial  = strtoupper(substr($username, 0, 1));

// Notifikasi: hitung billing belum lunas (dinamis dari DB)
$notif_count = 0;
if (isset($conn)) {
    $q_notif = mysqli_query($conn, "SELECT COUNT(*) AS c FROM billing WHERE status != 'Lunas'");
    if ($q_notif) {
        $notif_count = (int)(mysqli_fetch_assoc($q_notif)['c'] ?? 0);
    }
}
?>
<nav class="navbar-top">

    <!-- Search global — mengarah ke halaman hasil pencarian -->
    <form class="navbar-search" method="GET" action="/isp-management/templates/search.php">
        <span class="search-icon">🔍</span>
        <input type="text" name="q"
               value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
               placeholder="Cari pelanggan, paket, teknisi..."
               autocomplete="off">
    </form>

    <!-- Right side -->
    <div class="navbar-right">



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
