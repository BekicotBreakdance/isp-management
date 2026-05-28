<?php
// Sidebar — include di setiap halaman
// Deteksi halaman aktif berdasarkan URL
$current = $_SERVER['REQUEST_URI'];

function nav_active(string $path): string {
    global $current;
    return str_contains($current, $path) ? 'active' : '';
}
?>
<div class="sidebar">

    <!-- Brand -->
    <div class="sidebar-brand">
        <div class="brand-icon">📡</div>
        <div>
            <div class="brand-name">NEXANET</div>
            <div class="brand-sub">ISP / RT RW Net</div>
        </div>
    </div>

    <!-- Nav Utama -->
    <p class="sidebar-section-label">Menu Utama</p>
    <ul class="sidebar-nav">
        <li>
            <a href="/isp-management/templates/dashboard/index.php" class="<?= nav_active('dashboard') ?>">
                <span class="nav-icon">🏠</span> Dashboard
            </a>
        </li>
        <li>
            <a href="/isp-management/templates/pelanggan/index.php" class="<?= nav_active('pelanggan') ?>">
                <span class="nav-icon">👤</span> Pelanggan
            </a>
        </li>
        <li>
            <a href="/isp-management/templates/paket/index.php" class="<?= nav_active('paket') ?>">
                <span class="nav-icon">📶</span> Paket Internet
            </a>
        </li>
        <li>
            <a href="/isp-management/templates/queue/index.php" class="<?= nav_active('queue') ?>">
                <span class="nav-icon">🔀</span> Queue / Mikrotik
            </a>
        </li>
        <li>
            <a href="/isp-management/templates/modem/index.php" class="<?= nav_active('modem') ?>">
                <span class="nav-icon">📦</span> Modem
            </a>
        </li>
        <li>
            <a href="/isp-management/templates/teknisi/index.php" class="<?= nav_active('teknisi') ?>">
                <span class="nav-icon">🔧</span> Teknisi
            </a>
        </li>
    </ul>

    <!-- Nav Lanjutan -->
    <p class="sidebar-section-label">Lainnya</p>
    <ul class="sidebar-nav">
        <li>
            <a href="/isp-management/templates/maintenance/index.php" class="<?= nav_active('maintenance') ?>">
                <span class="nav-icon">🛠️</span> Maintenance
            </a>
        </li>
        <li>
            <a href="/isp-management/templates/billing/index.php" class="<?= nav_active('billing') ?>">
                <span class="nav-icon">💳</span> Billing
            </a>
        </li>
    </ul>

    <!-- Logout -->
    <div class="sidebar-footer">
        <a href="/isp-management/backend/auth/logout.php">
            <span style="font-size:16px">🚪</span> Logout
        </a>
    </div>

</div>
