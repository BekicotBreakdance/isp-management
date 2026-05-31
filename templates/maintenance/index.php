<?php
include __DIR__ . '/../../backend/config/connect.php';
include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
include __DIR__ . '/../layouts/navbar.php';

$result = mysqli_query($conn, "
    SELECT m.id_mt, m.tanggal_mt, m.detail_kendala_singkat,
           p.nama AS nama_pelanggan,
           t.nama AS nama_teknisi
    FROM maintenance m
    LEFT JOIN pelanggan p ON m.id_pelanggan = p.id_pelanggan
    LEFT JOIN teknisi   t ON m.id_teknisi   = t.id_teknisi
    ORDER BY m.tanggal_mt DESC
");

$pesan = $_GET['pesan'] ?? '';
$notif = [
    'tambah_berhasil' => ['teks' => '✅ Maintenance berhasil ditambahkan!', 'class' => 'notif-success'],
    'tambah_gagal'    => ['teks' => '❌ Gagal menambahkan maintenance.',    'class' => 'notif-error'],
    'edit_berhasil'   => ['teks' => '✅ Maintenance berhasil diperbarui!',  'class' => 'notif-success'],
    'edit_gagal'      => ['teks' => '❌ Gagal memperbarui maintenance.',    'class' => 'notif-error'],
    'hapus_berhasil'  => ['teks' => '✅ Maintenance berhasil dihapus!',    'class' => 'notif-success'],
    'hapus_gagal'     => ['teks' => '❌ Gagal menghapus maintenance.',      'class' => 'notif-error'],
];
?>
<div class="main-content">
<div class="page-body">

    <div class="page-actions">
        <div>
            <div class="page-title">Maintenance</div>
            <div class="page-subtitle">Kelola aktivitas maintenance dan kendala pelanggan.</div>
        </div>
        <a href="tambah.php"><button class="btn-primary-sm">🔧 Input Maintenance</button></a>
    </div>

    <?php if ($pesan && isset($notif[$pesan])): ?>
        <div class="notif <?= $notif[$pesan]['class'] ?>"><?= $notif[$pesan]['teks'] ?></div>
    <?php endif; ?>

    <div class="panel">
        <div class="panel-header"><div class="panel-title">Riwayat Maintenance</div></div>
        <table class="dash-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Teknisi</th>
                    <th>Kendala</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td style="color:var(--gray-400)"><?= $row['id_mt'] ?></td>
                    <td style="white-space:nowrap;font-size:13px"><?= htmlspecialchars($row['tanggal_mt']) ?></td>
                    <td style="font-weight:600"><?= htmlspecialchars($row['nama_pelanggan'] ?? '-') ?></td>
                    <td style="color:var(--gray-600)"><?= htmlspecialchars($row['nama_teknisi'] ?? '-') ?></td>
                    <td style="font-size:12px;color:var(--gray-600);max-width:220px">
                        <?= htmlspecialchars($row['detail_kendala_singkat']) ?>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px">
                            <a href="detail.php?id=<?= $row['id_mt'] ?>" class="btn-action" title="Detail Alat"
                               style="background:#eff6ff;color:var(--blue-mid)">🔍</a>
                            <a href="edit.php?id=<?= $row['id_mt'] ?>" class="btn-action btn-edit" title="Edit">✏️</a>
                            <a href="../../backend/maintenance/hapus.php?id=<?= $row['id_mt'] ?>"
                               class="btn-action btn-hapus" title="Hapus"
                               onclick="return confirm('Hapus data maintenance ini?')">🗑️</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6" class="empty-state">Belum ada data maintenance.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
