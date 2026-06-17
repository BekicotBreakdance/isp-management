<?php
// ============================================================
// DASHBOARD — ISP Management System
// Data diambil dari database MySQL via PHP Native procedural
// ============================================================

include __DIR__ . '/../../backend/config/connect.php';
include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
include __DIR__ . '/../layouts/navbar.php';

// ============================================================
// 1. STAT CARDS — query COUNT & SUM dari database
// ============================================================

// Total Pelanggan
$q_total_pelanggan = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pelanggan");
$total_pelanggan   = mysqli_fetch_assoc($q_total_pelanggan)['total'] ?? 0;

// Paket Aktif (jumlah jenis paket yang tersedia)
$q_paket_aktif = mysqli_query($conn, "SELECT COUNT(*) AS total FROM paket");
$paket_aktif   = mysqli_fetch_assoc($q_paket_aktif)['total'] ?? 0;

// Router Terkoneksi
$q_router = mysqli_query($conn, "SELECT COUNT(*) AS total FROM router");
$total_router = mysqli_fetch_assoc($q_router)['total'] ?? 0;

// Total Tagihan Bulan Ini
// Catatan: tabel billing tidak punya field nominal.
// Kita SUM harga paket dari pelanggan yang punya tagihan bulan ini.
$q_tagihan = mysqli_query($conn, "
    SELECT SUM(pk.harga) AS total
    FROM billing b
    JOIN pelanggan p  ON b.id_pelanggan = p.id_pelanggan
    JOIN paket pk     ON p.id_paket     = pk.id_paket
    WHERE MONTH(b.tanggal_tagihan) = MONTH(CURDATE())
      AND YEAR(b.tanggal_tagihan)  = YEAR(CURDATE())
");
$total_tagihan = mysqli_fetch_assoc($q_tagihan)['total'] ?? 0;

// ============================================================
// 2. PELANGGAN TERBARU — 5 data terbaru, JOIN paket + modem + router
// ============================================================
$q_pelanggan = mysqli_query($conn, "
    SELECT
        p.id_pelanggan,
        p.nama,
        p.status,
        pk.jenis_paket,
        pk.kecepatan_bandwidth,
        m.merk  AS merk_modem,
        r.merk  AS merk_router
    FROM pelanggan p
    LEFT JOIN paket  pk ON p.id_paket  = pk.id_paket
    LEFT JOIN modem  m  ON p.id_modem  = m.id_modem
    LEFT JOIN router r  ON p.id_router = r.id_router
    ORDER BY p.id_pelanggan DESC
    LIMIT 5
");

// ============================================================
// 3. PAKET INTERNET — semua paket dari tabel paket
// ============================================================
$q_paket = mysqli_query($conn, "
    SELECT id_paket, jenis_paket, kecepatan_bandwidth, harga
    FROM paket
    ORDER BY harga ASC
");

// ============================================================
// 4. QUEUE / MIKROTIK — JOIN ke pelanggan dan paket
// ============================================================
$q_queue = mysqli_query($conn, "
    SELECT
        q.ip_address,
        q.jenis_ip,
        q.username_mikrotik,
        q.status,
        pk.jenis_paket,
        pk.kecepatan_bandwidth
        -- Catatan: tabel queue tidak punya field status.
        -- Status ditampilkan sebagai 'Aktif' (dummy) untuk semua baris.
    FROM queue q
    LEFT JOIN pelanggan p  ON q.id_pelanggan = p.id_pelanggan
    LEFT JOIN paket     pk ON p.id_paket      = pk.id_paket
    ORDER BY q.id_queue DESC
    LIMIT 5
");

// ============================================================
// 5. MAINTENANCE TERBARU — JOIN pelanggan + teknisi
// ============================================================
$q_maintenance = mysqli_query($conn, "
    SELECT
        m.tanggal_mt,
        p.nama       AS nama_pelanggan,
        t.nama       AS nama_teknisi,
        m.detail_kendala_singkat,
        m.status
    FROM maintenance m
    LEFT JOIN pelanggan p ON m.id_pelanggan = p.id_pelanggan
    LEFT JOIN teknisi   t ON m.id_teknisi   = t.id_teknisi
    ORDER BY m.tanggal_mt DESC
    LIMIT 4
");

// ============================================================
// 6. BILLING JATUH TEMPO — status belum lunas / belum bayar
//    JOIN ke pelanggan dan paket untuk mendapatkan harga
// ============================================================
$q_billing = mysqli_query($conn, "
    SELECT
        b.tanggal_tagihan,
        b.status,
        p.nama       AS nama_pelanggan,
        pk.jenis_paket,
        pk.harga
        -- Catatan: tabel billing tidak punya field nominal.
        -- Harga diambil dari paket pelanggan sebagai estimasi tagihan.
    FROM billing b
    LEFT JOIN pelanggan p  ON b.id_pelanggan = p.id_pelanggan
    LEFT JOIN paket     pk ON p.id_paket     = pk.id_paket
    WHERE b.status != 'Lunas'
    ORDER BY b.tanggal_tagihan DESC
    LIMIT 5
");
?>

<!-- ===================== MAIN CONTENT ===================== -->
<div class="main-content">
    <div class="page-body">

        <!-- Page Header -->
        <div class="page-title">Sistem Management ISP / RT RW Net — Dashboard</div>
        <div class="page-subtitle">Selamat datang, ringkasan data sistem hari ini.</div>

        <!-- ===== STAT CARDS ===== -->
        <div class="stat-cards">

            <div class="stat-card">
                <div>
                    <div class="stat-label">Total Pelanggan</div>
                    <div class="stat-value"><?= number_format($total_pelanggan) ?></div>
                </div>
                <div class="stat-icon blue">👤</div>
            </div>

            <div class="stat-card">
                <div>
                    <div class="stat-label">Paket Tersedia</div>
                    <div class="stat-value"><?= number_format($paket_aktif) ?></div>
                </div>
                <div class="stat-icon green">📶</div>
            </div>

            <div class="stat-card">
                <div>
                    <div class="stat-label">Router Terkoneksi</div>
                    <div class="stat-value"><?= number_format($total_router) ?></div>
                </div>
                <div class="stat-icon yellow">🔀</div>
            </div>

            <div class="stat-card">
                <div>
                    <div class="stat-label">Estimasi Tagihan Bulan Ini</div>
                    <div class="stat-value money">
                        <?= $total_tagihan > 0
                            ? 'Rp ' . number_format($total_tagihan, 0, ',', '.')
                            : 'Rp 0' ?>
                    </div>
                </div>
                <div class="stat-icon red">💳</div>
            </div>

        </div>
        <!-- END STAT CARDS -->

        <!-- ===== DASHBOARD GRID ===== -->
        <div class="dashboard-grid">

            <!-- ==============================
             KOLOM KIRI: Pelanggan + Maintenance
             ============================== -->

            <!-- Pelanggan Terbaru -->
            <div class="panel" style="grid-column: 1;">
                <div class="panel-header">
                    <div>
                        <div class="section-badge">PELANGGAN</div>
                        <div class="panel-title">Pelanggan Terbaru</div>
                    </div>
                    <a href="/isp-management/templates/pelanggan/index.php">
                        <button class="btn-primary-sm">➕ Tambah Pelanggan</button>
                    </a>
                </div>

                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Pelanggan</th>
                            <th>Paket</th>
                            <th>Modem / Router</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($q_pelanggan && mysqli_num_rows($q_pelanggan) > 0): ?>
                            <?php while ($p = mysqli_fetch_assoc($q_pelanggan)): ?>
                                <tr>
                                    <td><span style="color:var(--gray-400);font-size:12px;"><?= str_pad($p['id_pelanggan'], 3, '0', STR_PAD_LEFT) ?></span></td>
                                    <td style="font-weight:600"><?= htmlspecialchars($p['nama']) ?></td>
                                    <td>
                                        <?= htmlspecialchars($p['jenis_paket'] ?? '-') ?>
                                        <?php if ($p['kecepatan_bandwidth']): ?>
                                            <span style="color:var(--gray-400);font-size:11px;">(<?= $p['kecepatan_bandwidth'] ?> Mbps)</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="color:var(--gray-600);font-size:12px;">
                                        <?= htmlspecialchars($p['merk_modem'] ?? '-') ?>
                                        <?php if ($p['merk_router']): ?>
                                            / <?= htmlspecialchars($p['merk_router']) ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge <?= ($p['status'] ?? 'Aktif') === 'Aktif' ? 'badge-green' : 'badge-red' ?>">
                                            <?= htmlspecialchars($p['status'] ?? 'Aktif') ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div style="display:flex;gap:5px;align-items:center;">
                                            <a href="/isp-management/templates/pelanggan/index.php?aksi=edit&id=<?= $p['id_pelanggan'] ?>"
                                                class="btn-action btn-edit" title="Edit">✏️</a>
                                            <a href="/isp-management/backend/pelanggan/hapus.php?id=<?= $p['id_pelanggan'] ?>"
                                                class="btn-action btn-hapus" title="Hapus"
                                                onclick="return confirm('Hapus pelanggan ini?')">🗑️</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align:center;color:var(--gray-400);padding:20px;">Belum ada data pelanggan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div style="padding:10px 14px;text-align:right;">
                    <a href="/isp-management/templates/pelanggan/index.php"
                        style="font-size:12px;color:var(--blue-mid);font-weight:600;">Lihat semua pelanggan →</a>
                </div>
            </div>

            <!-- Maintenance Terbaru -->
            <div class="panel" style="grid-column: 1;">
                <div class="panel-header">
                    <div>
                        <div class="section-badge">MAINTENANCE</div>
                        <div class="panel-title">Aktivitas Maintenance Terbaru</div>
                    </div>
                    <a href="/isp-management/templates/maintenance/index.php">
                        <button class="btn-primary-sm">🔧 Input Maintenance Baru</button>
                    </a>
                </div>

                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Teknisi</th>
                            <th>Kendala</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($q_maintenance && mysqli_num_rows($q_maintenance) > 0): ?>
                            <?php while ($m = mysqli_fetch_assoc($q_maintenance)): ?>
                                <tr>
                                    <td style="font-size:12px;white-space:nowrap;">
                                        <?= htmlspecialchars($m['tanggal_mt']) ?>
                                    </td>
                                    <td style="font-weight:600"><?= htmlspecialchars($m['nama_pelanggan'] ?? '-') ?></td>
                                    <td style="color:var(--gray-600)"><?= htmlspecialchars($m['nama_teknisi'] ?? '-') ?></td>
                                    <td style="font-size:12px;color:var(--gray-600);max-width:180px;">
                                        <?= htmlspecialchars($m['detail_kendala_singkat']) ?>
                                    </td>
                                    <td>
                                        <?php
                                        $mBadge = match ($m['status'] ?? 'Proses') {
                                            'Proses'  => 'status-proses',
                                            'Pending' => 'badge-yellow',
                                            'Selesai' => 'badge-green',
                                            default   => 'badge-gray',
                                        };
                                        ?>
                                        <span class="<?= str_starts_with($mBadge, 'status-') ? 'status-pill ' : 'badge ' ?><?= $mBadge ?>">
                                            <?= htmlspecialchars($m['status'] ?? 'Proses') ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align:center;color:var(--gray-400);padding:20px;">Belum ada data maintenance.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>


            <!-- ==============================
             KOLOM KANAN: Paket + Queue + Billing
             ============================== -->

            <!-- Paket Internet -->
            <div class="panel" style="grid-row: 1; grid-column: 2;">
                <div class="panel-header">
                    <div>
                        <div class="section-badge">PAKET INTERNET</div>
                        <div class="panel-title">Daftar Paket</div>
                    </div>
                    <a href="/isp-management/templates/paket/index.php">
                        <button class="btn-primary-sm">➕ Tambah Paket</button>
                    </a>
                </div>

                <div class="paket-list">
                    <?php if ($q_paket && mysqli_num_rows($q_paket) > 0): ?>
                        <?php while ($pk = mysqli_fetch_assoc($q_paket)): ?>
                            <div class="paket-row">
                                <div>
                                    <div class="paket-name">
                                        <?= htmlspecialchars($pk['jenis_paket']) ?>
                                        <span style="font-weight:400;color:var(--gray-400);font-size:12px;">
                                            — <?= $pk['kecepatan_bandwidth'] ?> Mbps
                                        </span>
                                    </div>
                                    <div class="paket-price">Rp <?= number_format($pk['harga'], 0, ',', '.') ?>/bln</div>
                                </div>
                                <div class="paket-actions">
                                    <a href="/isp-management/templates/paket/index.php?aksi=edit&id=<?= $pk['id_paket'] ?>"
                                        class="btn-action btn-edit" title="Edit">✏️</a>
                                    <a href="/isp-management/backend/paket/hapus.php?id=<?= $pk['id_paket'] ?>"
                                        class="btn-action btn-hapus" title="Hapus"
                                        onclick="return confirm('Hapus paket ini?')">🗑️</a>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div style="padding:20px;text-align:center;color:var(--gray-400);">Belum ada data paket.</div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Queue / Mikrotik -->
            <div class="panel" style="grid-column: 2;">
                <div class="panel-header">
                    <div>
                        <div class="section-badge">QUEUE / MIKROTIK</div>
                        <div class="panel-title">Status Queue Mikrotik</div>
                    </div>
                    <a href="/isp-management/templates/queue/index.php">
                        <button class="btn-primary-sm">➕ Tambah Queue</button>
                    </a>
                </div>

                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>IP Address</th>
                            <th>Jenis</th>
                            <th>Username Mikrotik</th>
                            <th>Paket</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($q_queue && mysqli_num_rows($q_queue) > 0): ?>
                            <?php while ($q = mysqli_fetch_assoc($q_queue)): ?>
                                <tr>
                                    <td style="font-family:monospace;font-size:12px"><?= htmlspecialchars($q['ip_address']) ?></td>
                                    <td><span class="badge badge-blue"><?= htmlspecialchars($q['jenis_ip']) ?></span></td>
                                    <td style="font-family:monospace;font-size:12px"><?= htmlspecialchars($q['username_mikrotik']) ?></td>
                                    <td>
                                        <?= htmlspecialchars($q['jenis_paket'] ?? '-') ?>
                                        <?php if ($q['kecepatan_bandwidth']): ?>
                                            <span style="color:var(--gray-400);font-size:11px;">(<?= $q['kecepatan_bandwidth'] ?> Mbps)</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $qdb = match ($q['status'] ?? 'Aktif') {
                                            'Aktif'   => 'badge-green',
                                            'Suspend' => 'badge-yellow',
                                            'Isolir'  => 'badge-red',
                                            default   => 'badge-gray',
                                        };
                                        ?>
                                        <span class="badge <?= $qdb ?>"><?= htmlspecialchars($q['status'] ?? 'Aktif') ?></span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align:center;color:var(--gray-400);padding:20px;">Belum ada data queue.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Billing Jatuh Tempo -->
            <div class="panel billing-alert" style="grid-column: 2;">
                <div class="panel-header" style="border-bottom-color:rgba(220,38,38,.2);">
                    <div>
                        <div class="section-badge" style="color:var(--red)">BILLING</div>
                        <div class="panel-title">Tagihan Belum Lunas</div>
                    </div>
                    <a href="/isp-management/templates/billing/index.php">
                        <button class="btn-primary-sm" style="background:var(--red)">➕ Tambah Billing</button>
                    </a>
                </div>

                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>Tgl Tagihan</th>
                            <th>Pelanggan</th>
                            <th>Paket</th>
                            <th>Estimasi Tagihan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($q_billing && mysqli_num_rows($q_billing) > 0): ?>
                            <?php while ($b = mysqli_fetch_assoc($q_billing)): ?>
                                <tr style="background:#fff5f5;">
                                    <td style="font-size:12px"><?= htmlspecialchars($b['tanggal_tagihan']) ?></td>
                                    <td style="font-weight:600"><?= htmlspecialchars($b['nama_pelanggan'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($b['jenis_paket'] ?? '-') ?></td>
                                    <td style="font-weight:600">
                                        <?= $b['harga']
                                            ? 'Rp ' . number_format($b['harga'], 0, ',', '.')
                                            : '-' ?>
                                    </td>
                                    <td>
                                        <span class="badge badge-red"><?= htmlspecialchars($b['status']) ?></span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align:center;color:var(--gray-400);padding:20px;">
                                    Tidak ada tagihan yang belum lunas.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
        <!-- END DASHBOARD GRID -->

    </div>
</div>
<!-- END MAIN CONTENT -->

<!-- Bootstrap JS -->

</body>

</html>