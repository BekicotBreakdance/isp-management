<?php
include __DIR__ . '/../../backend/config/connect.php';
include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
include __DIR__ . '/../layouts/navbar.php';

$result = mysqli_query($conn, "
    SELECT b.id_billing, b.tanggal_tagihan, b.tanggal_bayar, b.status,
           p.nama AS nama_pelanggan,
           pk.jenis_paket, pk.kecepatan_bandwidth, pk.harga
    FROM billing b
    LEFT JOIN pelanggan p  ON b.id_pelanggan = p.id_pelanggan
    LEFT JOIN paket     pk ON p.id_paket     = pk.id_paket
    ORDER BY b.tanggal_tagihan DESC
");

$pesan = $_GET['pesan'] ?? '';
$notif = [
    'tambah_berhasil' => ['teks' => '✅ Billing berhasil ditambahkan!', 'class' => 'notif-success'],
    'tambah_gagal'    => ['teks' => '❌ Gagal menambahkan billing.',    'class' => 'notif-error'],
    'edit_berhasil'   => ['teks' => '✅ Billing berhasil diperbarui!',  'class' => 'notif-success'],
    'edit_gagal'      => ['teks' => '❌ Gagal memperbarui billing.',    'class' => 'notif-error'],
    'hapus_berhasil'  => ['teks' => '✅ Billing berhasil dihapus!',    'class' => 'notif-success'],
    'hapus_gagal'     => ['teks' => '❌ Gagal menghapus billing.',      'class' => 'notif-error'],
];
?>
<div class="main-content">
<div class="page-body">

    <div class="page-actions">
        <div>
            <div class="page-title">Billing</div>
            <div class="page-subtitle">Kelola tagihan dan status pembayaran pelanggan.</div>
        </div>
        <a href="tambah.php"><button class="btn-primary-sm">➕ Tambah Tagihan</button></a>
    </div>

    <?php if ($pesan && isset($notif[$pesan])): ?>
        <div class="notif <?= $notif[$pesan]['class'] ?>"><?= $notif[$pesan]['teks'] ?></div>
    <?php endif; ?>

    <div class="panel">
        <div class="panel-header"><div class="panel-title">Daftar Tagihan</div></div>
        <table class="dash-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pelanggan</th>
                    <th>Paket</th>
                    <th>Estimasi Tagihan</th>
                    <th>Tgl Tagihan</th>
                    <th>Tgl Bayar</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td style="color:var(--gray-400)"><?= $row['id_billing'] ?></td>
                    <td style="font-weight:600"><?= htmlspecialchars($row['nama_pelanggan'] ?? '-') ?></td>
                    <td>
                        <?php if ($row['jenis_paket']): ?>
                            <span class="badge badge-blue"><?= htmlspecialchars($row['jenis_paket']) ?></span>
                        <?php else: ?> - <?php endif; ?>
                    </td>
                    <td style="font-weight:600">
                        <?= $row['harga'] ? 'Rp ' . number_format($row['harga'], 0, ',', '.') : '-' ?>
                    </td>
                    <td style="font-size:12px"><?= htmlspecialchars($row['tanggal_tagihan']) ?></td>
                    <td style="font-size:12px;color:var(--gray-400)">
                        <?= $row['tanggal_bayar'] ? htmlspecialchars($row['tanggal_bayar']) : '<span style="color:var(--red)">Belum</span>' ?>
                    </td>
                    <td>
                        <?php
                        $status = $row['status'];
                        $badge  = match(strtolower($status)) {
                            'lunas'         => 'badge-green',
                            'belum lunas'   => 'badge-red',
                            default         => 'badge-yellow',
                        };
                        ?>
                        <span class="badge <?= $badge ?>"><?= htmlspecialchars($status) ?></span>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px">
                            <a href="edit.php?id=<?= $row['id_billing'] ?>" class="btn-action btn-edit" title="Edit">✏️</a>
                            <a href="../../backend/billing/hapus.php?id=<?= $row['id_billing'] ?>"
                               class="btn-action btn-hapus" title="Hapus"
                               onclick="return confirm('Hapus tagihan ini?')">🗑️</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8" class="empty-state">Belum ada data billing.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
