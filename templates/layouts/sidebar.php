<?php
// Sidebar — include di setiap halaman
$current = $_SERVER['REQUEST_URI'];

function nav_active(string $path): string {
    global $current;
    return str_contains($current, $path) ? 'active' : '';
}
?>
<div class="sidebar">

    <!-- Brand -->
    <div class="sidebar-brand">
        <div class="brand-icon"></div>
        <div>
            <div class="brand-name">NEXANET</div>
            <div class="brand-sub">ISP / RT RW Net</div>
        </div>
    </div>

    <!-- Nav Utama -->
    <p class="sidebar-section-label">Menu Utama</p>
    <ul class="sidebar-nav">
        <li>
            <a href="/isp-management/templates/dashboard/index.php"
               class="<?= nav_active('dashboard') ?>">
                Dashboard
            </a>
        </li>
        <li>
            <a href="/isp-management/templates/search.php"
               class="<?= nav_active('search') ?>">
                Pencarian Global
            </a>
        </li>
        <li>
            <a href="/isp-management/templates/pelanggan/index.php"
               class="<?= nav_active('pelanggan') ?>">
                Pelanggan
            </a>
        </li>
        <li>
            <a href="/isp-management/templates/paket/index.php"
               class="<?= nav_active('paket') ?>">
                Paket Internet
            </a>
        </li>
        <li>
            <a href="/isp-management/templates/queue/index.php"
               class="<?= nav_active('queue') ?>">
                Queue / Mikrotik
            </a>
        </li>
        <li>
            <a href="/isp-management/templates/billing/index.php"
               class="<?= nav_active('billing') ?>">
                Billing
            </a>
        </li>
    </ul>

    <!-- Nav Inventaris -->
    <p class="sidebar-section-label">Inventaris</p>
    <ul class="sidebar-nav">
        <li>
            <a href="/isp-management/templates/modem/index.php"
               class="<?= nav_active('modem') ?>">
                Modem
            </a>
        </li>
        <li>
            <a href="/isp-management/templates/router/index.php"
               class="<?= nav_active('router') ?>">
                Router
            </a>
        </li>
    </ul>

    <!-- Nav SDM -->
    <p class="sidebar-section-label">SDM & Operasional</p>
    <ul class="sidebar-nav">
        <li>
            <a href="/isp-management/templates/teknisi/index.php"
               class="<?= nav_active('teknisi') ?>">
                Teknisi
            </a>
        </li>
        <li>
            <a href="/isp-management/templates/maintenance/index.php"
               class="<?= nav_active('maintenance') ?>">
                Maintenance
            </a>
        </li>
        <li>
            <a href="/isp-management/templates/alat_mt/index.php"
               class="<?= nav_active('alat_mt') ?>">
                Alat Maintenance
            </a>
        </li>
    </ul>

    <!-- Logout -->
    <div class="sidebar-footer">
        <a href="/isp-management/backend/auth/logout.php">
            Logout
        </a>
    </div>

</div>
