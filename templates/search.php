<?php
/**
 * templates/search.php
 * Halaman hasil pencarian global.
 * Mencari keyword di: pelanggan, paket, teknisi, queue, maintenance, billing.
 */

include __DIR__ . '/../backend/config/connect.php';
include __DIR__ . '/layouts/header.php';
include __DIR__ . '/layouts/sidebar.php';
include __DIR__ . '/layouts/navbar.php';

// Ambil keyword dari GET, bersihkan
$q = trim($_GET['q'] ?? '');

// Jika kosong, tampilkan halaman kosong
if ($q === '') {
    $keyword = '';
} else {
    $keyword = mysqli_real_escape_string($conn, $q);
}
?>
<div class="main-content">
<div class="page-body">

    <div class="page-title">Hasil Pencarian</div>
    <div class="page-subtitle">
        <?php if ($q !== ''): ?>
            Menampilkan hasil untuk kata kunci: <strong>"<?= htmlspecialchars($q) ?>"</strong>
        <?php else: ?>
            Ketik kata kunci di kotak pencarian di atas.
        <?php endif; ?>
    </div>

<?php if ($q !== ''): ?>

    <?php
    // ── 1. PELANGGAN ─────────────────────────────────────
    $r_pelanggan = mysqli_query($conn, "
        SELECT p.id_pelanggan, p.nama, p.alamat, pk.jenis_paket
        FROM pelanggan p
        LEFT JOIN paket pk ON p.id_paket = pk.id_paket
        WHERE p.nama LIKE '%$keyword%' OR p.alamat LIKE '%$keyword%'
        LIMIT 10
    ");
    $jml_pelanggan = mysqli_num_rows($r_pelanggan);
    ?>

    <!-- PELANGGAN -->
    <div class="panel" style="margin-bottom:20px">
        <div class="panel-header">
            <div>
                <div class="section-badge">PELANGGAN</div>
                <div class="panel-title">
                    Pelanggan
                    <span style="font-size:12px;font-weight:400;color:var(--gray-400)">(<?= $jml_pelanggan ?> hasil)</span>
                </div>
            </div>
            <?php if ($jml_pelanggan > 0): ?>
            <a href="/isp-management/templates/pelanggan/index.php?cari=<?= urlencode($q) ?>">
                <button class="btn-primary-sm">Lihat semua →</button>
            </a>
            <?php endif; ?>
        </div>

        <?php if ($jml_pelanggan > 0): ?>
        <table class="dash-table">
            <thead><tr><th>ID</th><th>Nama</th><th>Alamat</th><th>Paket</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($r_pelanggan)): ?>
            <tr>
                <td style="color:var(--gray-400)"><?= $row['id_pelanggan'] ?></td>
                <td style="font-weight:600"><?= htmlspecialchars($row['nama']) ?></td>
                <td style="font-size:12px;color:var(--gray-600)"><?= htmlspecialchars($row['alamat']) ?></td>
                <td><span class="badge badge-blue"><?= htmlspecialchars($row['jenis_paket'] ?? '-') ?></span></td>
                <td>
                    <a href="/isp-management/templates/pelanggan/edit.php?id=<?= $row['id_pelanggan'] ?>"
                       class="btn-action btn-edit" title="Edit">✏️</a>
                </td>
            </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="empty-state">Tidak ada pelanggan dengan kata kunci tersebut.</div>
        <?php endif; ?>
    </div>

    <?php
    // ── 2. PAKET ─────────────────────────────────────────
    $r_paket = mysqli_query($conn, "
        SELECT * FROM paket
        WHERE jenis_paket LIKE '%$keyword%'
        LIMIT 10
    ");
    $jml_paket = mysqli_num_rows($r_paket);
    ?>

    <!-- PAKET -->
    <div class="panel" style="margin-bottom:20px">
        <div class="panel-header">
            <div>
                <div class="section-badge">PAKET</div>
                <div class="panel-title">
                    Paket Internet
                    <span style="font-size:12px;font-weight:400;color:var(--gray-400)">(<?= $jml_paket ?> hasil)</span>
                </div>
            </div>
        </div>
        <?php if ($jml_paket > 0): ?>
        <table class="dash-table">
            <thead><tr><th>ID</th><th>Jenis Paket</th><th>Kecepatan</th><th>Harga</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($r_paket)): ?>
            <tr>
                <td style="color:var(--gray-400)"><?= $row['id_paket'] ?></td>
                <td style="font-weight:600"><?= htmlspecialchars($row['jenis_paket']) ?></td>
                <td><span class="badge badge-blue"><?= $row['kecepatan_bandwidth'] ?> Mbps</span></td>
                <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                <td>
                    <a href="/isp-management/templates/paket/edit.php?id=<?= $row['id_paket'] ?>"
                       class="btn-action btn-edit" title="Edit">✏️</a>
                </td>
            </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="empty-state">Tidak ada paket dengan kata kunci tersebut.</div>
        <?php endif; ?>
    </div>

    <?php
    // ── 3. TEKNISI ────────────────────────────────────────
    $r_teknisi = mysqli_query($conn, "
        SELECT * FROM teknisi
        WHERE nama LIKE '%$keyword%' OR alamat LIKE '%$keyword%'
        LIMIT 10
    ");
    $jml_teknisi = mysqli_num_rows($r_teknisi);
    ?>

    <!-- TEKNISI -->
    <div class="panel" style="margin-bottom:20px">
        <div class="panel-header">
            <div>
                <div class="section-badge">TEKNISI</div>
                <div class="panel-title">
                    Teknisi
                    <span style="font-size:12px;font-weight:400;color:var(--gray-400)">(<?= $jml_teknisi ?> hasil)</span>
                </div>
            </div>
        </div>
        <?php if ($jml_teknisi > 0): ?>
        <table class="dash-table">
            <thead><tr><th>ID</th><th>Nama</th><th>Alamat</th><th>Kelamin</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($r_teknisi)): ?>
            <tr>
                <td style="color:var(--gray-400)"><?= $row['id_teknisi'] ?></td>
                <td style="font-weight:600"><?= htmlspecialchars($row['nama']) ?></td>
                <td style="font-size:12px;color:var(--gray-600)"><?= htmlspecialchars($row['alamat']) ?></td>
                <td><span class="badge badge-<?= $row['jenis_kelamin'] === 'Laki-laki' ? 'blue' : 'green' ?>">
                    <?= htmlspecialchars($row['jenis_kelamin']) ?></span>
                </td>
                <td>
                    <a href="/isp-management/templates/teknisi/edit.php?id=<?= $row['id_teknisi'] ?>"
                       class="btn-action btn-edit" title="Edit">✏️</a>
                </td>
            </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="empty-state">Tidak ada teknisi dengan kata kunci tersebut.</div>
        <?php endif; ?>
    </div>

    <?php
    // ── 4. QUEUE ──────────────────────────────────────────
    $r_queue = mysqli_query($conn, "
        SELECT q.*, p.nama AS nama_pelanggan
        FROM queue q
        LEFT JOIN pelanggan p ON q.id_pelanggan = p.id_pelanggan
        WHERE q.ip_address LIKE '%$keyword%'
           OR q.username_mikrotik LIKE '%$keyword%'
           OR p.nama LIKE '%$keyword%'
        LIMIT 10
    ");
    $jml_queue = mysqli_num_rows($r_queue);
    ?>

    <!-- QUEUE -->
    <div class="panel" style="margin-bottom:20px">
        <div class="panel-header">
            <div>
                <div class="section-badge">QUEUE</div>
                <div class="panel-title">
                    Queue / Mikrotik
                    <span style="font-size:12px;font-weight:400;color:var(--gray-400)">(<?= $jml_queue ?> hasil)</span>
                </div>
            </div>
        </div>
        <?php if ($jml_queue > 0): ?>
        <table class="dash-table">
            <thead><tr><th>IP Address</th><th>Jenis</th><th>Username</th><th>Pelanggan</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($r_queue)): ?>
            <tr>
                <td style="font-family:monospace;font-size:12px;font-weight:600"><?= htmlspecialchars($row['ip_address']) ?></td>
                <td><span class="badge badge-blue"><?= htmlspecialchars($row['jenis_ip']) ?></span></td>
                <td style="font-family:monospace;font-size:12px"><?= htmlspecialchars($row['username_mikrotik']) ?></td>
                <td><?= htmlspecialchars($row['nama_pelanggan'] ?? '-') ?></td>
                <td>
                    <a href="/isp-management/templates/queue/edit.php?id=<?= $row['id_queue'] ?>"
                       class="btn-action btn-edit" title="Edit">✏️</a>
                </td>
            </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="empty-state">Tidak ada queue dengan kata kunci tersebut.</div>
        <?php endif; ?>
    </div>

    <?php
    // ── 5. MAINTENANCE ────────────────────────────────────
    $r_mt = mysqli_query($conn, "
        SELECT m.id_mt, m.tanggal_mt, m.detail_kendala_singkat,
               p.nama AS nama_pelanggan, t.nama AS nama_teknisi
        FROM maintenance m
        LEFT JOIN pelanggan p ON m.id_pelanggan = p.id_pelanggan
        LEFT JOIN teknisi   t ON m.id_teknisi   = t.id_teknisi
        WHERE m.detail_kendala_singkat LIKE '%$keyword%'
           OR p.nama LIKE '%$keyword%'
           OR t.nama LIKE '%$keyword%'
        LIMIT 10
    ");
    $jml_mt = mysqli_num_rows($r_mt);
    ?>

    <!-- MAINTENANCE -->
    <div class="panel" style="margin-bottom:20px">
        <div class="panel-header">
            <div>
                <div class="section-badge">MAINTENANCE</div>
                <div class="panel-title">
                    Maintenance
                    <span style="font-size:12px;font-weight:400;color:var(--gray-400)">(<?= $jml_mt ?> hasil)</span>
                </div>
            </div>
        </div>
        <?php if ($jml_mt > 0): ?>
        <table class="dash-table">
            <thead><tr><th>Tanggal</th><th>Pelanggan</th><th>Teknisi</th><th>Kendala</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($r_mt)): ?>
            <tr>
                <td style="font-size:12px;white-space:nowrap"><?= htmlspecialchars($row['tanggal_mt']) ?></td>
                <td style="font-weight:600"><?= htmlspecialchars($row['nama_pelanggan'] ?? '-') ?></td>
                <td style="color:var(--gray-600)"><?= htmlspecialchars($row['nama_teknisi'] ?? '-') ?></td>
                <td style="font-size:12px;color:var(--gray-600);max-width:200px"><?= htmlspecialchars($row['detail_kendala_singkat']) ?></td>
                <td>
                    <a href="/isp-management/templates/maintenance/detail.php?id=<?= $row['id_mt'] ?>"
                       class="btn-action btn-lihat" title="Detail">🔍</a>
                </td>
            </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="empty-state">Tidak ada maintenance dengan kata kunci tersebut.</div>
        <?php endif; ?>
    </div>

    <?php
    // ── 6. BILLING ────────────────────────────────────────
    $r_billing = mysqli_query($conn, "
        SELECT b.id_billing, b.tanggal_tagihan, b.status,
               p.nama AS nama_pelanggan, pk.jenis_paket, pk.harga
        FROM billing b
        LEFT JOIN pelanggan p  ON b.id_pelanggan = p.id_pelanggan
        LEFT JOIN paket     pk ON p.id_paket      = pk.id_paket
        WHERE p.nama LIKE '%$keyword%'
           OR b.status LIKE '%$keyword%'
        LIMIT 10
    ");
    $jml_billing = mysqli_num_rows($r_billing);
    ?>

    <!-- BILLING -->
    <div class="panel">
        <div class="panel-header">
            <div>
                <div class="section-badge">BILLING</div>
                <div class="panel-title">
                    Billing
                    <span style="font-size:12px;font-weight:400;color:var(--gray-400)">(<?= $jml_billing ?> hasil)</span>
                </div>
            </div>
            <?php if ($jml_billing > 0): ?>
            <a href="/isp-management/templates/billing/index.php?cari=<?= urlencode($q) ?>">
                <button class="btn-primary-sm">Lihat semua →</button>
            </a>
            <?php endif; ?>
        </div>
        <?php if ($jml_billing > 0): ?>
        <table class="dash-table">
            <thead><tr><th>Pelanggan</th><th>Paket</th><th>Tagihan</th><th>Tgl Tagihan</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php while ($row = mysqli_fetch_assoc($r_billing)): ?>
            <?php
            $badge = match(strtolower($row['status'])) {
                'lunas'       => 'badge-green',
                'belum lunas' => 'badge-red',
                default       => 'badge-yellow',
            };
            ?>
            <tr>
                <td style="font-weight:600"><?= htmlspecialchars($row['nama_pelanggan'] ?? '-') ?></td>
                <td><span class="badge badge-blue"><?= htmlspecialchars($row['jenis_paket'] ?? '-') ?></span></td>
                <td>Rp <?= $row['harga'] ? number_format($row['harga'], 0, ',', '.') : '-' ?></td>
                <td style="font-size:12px"><?= htmlspecialchars($row['tanggal_tagihan']) ?></td>
                <td><span class="badge <?= $badge ?>"><?= htmlspecialchars($row['status']) ?></span></td>
                <td>
                    <a href="/isp-management/templates/billing/edit.php?id=<?= $row['id_billing'] ?>"
                       class="btn-action btn-edit" title="Edit">✏️</a>
                </td>
            </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="empty-state">Tidak ada billing dengan kata kunci tersebut.</div>
        <?php endif; ?>
    </div>

<?php else: ?>
    <!-- Tampilan awal saat keyword kosong -->
    <div class="panel">
        <div style="text-align:center;padding:60px 20px">
            <div style="font-size:48px;margin-bottom:16px">🔍</div>
            <div style="font-size:16px;font-weight:600;color:var(--gray-600);margin-bottom:8px">Cari Data di Seluruh Sistem</div>
            <div style="font-size:13px;color:var(--gray-400)">
                Ketik nama pelanggan, IP address, username Mikrotik, jenis paket, atau nama teknisi
                di kotak pencarian di atas.
            </div>
            <div style="margin-top:24px;display:flex;flex-wrap:wrap;gap:10px;justify-content:center">
                <span style="background:var(--gray-100);padding:6px 14px;border-radius:20px;font-size:12px;color:var(--gray-600)">👤 Nama Pelanggan</span>
                <span style="background:var(--gray-100);padding:6px 14px;border-radius:20px;font-size:12px;color:var(--gray-600)">📶 Jenis Paket</span>
                <span style="background:var(--gray-100);padding:6px 14px;border-radius:20px;font-size:12px;color:var(--gray-600)">🔧 Nama Teknisi</span>
                <span style="background:var(--gray-100);padding:6px 14px;border-radius:20px;font-size:12px;color:var(--gray-600)">🌐 IP Address</span>
                <span style="background:var(--gray-100);padding:6px 14px;border-radius:20px;font-size:12px;color:var(--gray-600)">💳 Status Billing</span>
            </div>
        </div>
    </div>
<?php endif; ?>

</div>
</div>

</body>
</html>
