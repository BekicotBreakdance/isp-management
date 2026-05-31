<?php
include __DIR__ . '/../../backend/config/connect.php';
include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
include __DIR__ . '/../layouts/navbar.php';

// Search / filter
$cari     = trim($_GET['cari'] ?? '');
$where    = '';
if ($cari !== '') {
    $cari_esc = mysqli_real_escape_string($conn, $cari);
    $where    = "WHERE p.nama LIKE '%$cari_esc%' OR p.alamat LIKE '%$cari_esc%'";
}

$result = mysqli_query($conn, "
    SELECT p.*, pk.jenis_paket, pk.kecepatan_bandwidth,
           m.merk AS merk_modem, r.merk AS merk_router
    FROM pelanggan p
    LEFT JOIN paket  pk ON p.id_paket  = pk.id_paket
    LEFT JOIN modem  m  ON p.id_modem  = m.id_modem
    LEFT JOIN router r  ON p.id_router = r.id_router
    $where
    ORDER BY p.id_pelanggan ASC
");

$pesan = $_GET['pesan'] ?? '';
$notif = [
    'tambah_berhasil' => ['teks' => '✅ Pelanggan berhasil ditambahkan!', 'class' => 'notif-success'],
    'tambah_gagal'    => ['teks' => '❌ Gagal menambahkan pelanggan.',    'class' => 'notif-error'],
    'edit_berhasil'   => ['teks' => '✅ Pelanggan berhasil diperbarui!',  'class' => 'notif-success'],
    'edit_gagal'      => ['teks' => '❌ Gagal memperbarui pelanggan.',    'class' => 'notif-error'],
    'hapus_berhasil'  => ['teks' => '✅ Pelanggan berhasil dihapus!',    'class' => 'notif-success'],
    'hapus_gagal'     => ['teks' => '❌ Gagal menghapus pelanggan.',      'class' => 'notif-error'],
];
?>
<div class="main-content">
<div class="page-body">

    <div class="page-actions">
        <div>
            <div class="page-title">Data Pelanggan</div>
            <div class="page-subtitle">Kelola seluruh data pelanggan aktif.</div>
        </div>
        <a href="tambah.php"><button class="btn-primary-sm">➕ Tambah Pelanggan</button></a>
    </div>

    <?php if ($pesan && isset($notif[$pesan])): ?>
        <div class="notif <?= $notif[$pesan]['class'] ?>"><?= $notif[$pesan]['teks'] ?></div>
    <?php endif; ?>

    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">Daftar Pelanggan
                <?php if ($cari !== ''): ?>
                    <span style="font-size:12px;font-weight:400;color:var(--gray-400)">
                        — hasil pencarian "<strong><?= htmlspecialchars($cari) ?></strong>"
                        (<?= mysqli_num_rows($result) ?> data)
                    </span>
                <?php endif; ?>
            </div>
            <!-- Search form -->
            <form method="GET" action="" style="display:flex;gap:8px;align-items:center">
                <input type="text" name="cari" value="<?= htmlspecialchars($cari) ?>"
                       placeholder="Cari nama / alamat..."
                       style="padding:7px 12px;border:1.5px solid var(--gray-200);border-radius:7px;font-size:13px;outline:none;width:220px">
                <button type="submit" class="btn-primary-sm" style="padding:7px 14px">🔍 Cari</button>
                <?php if ($cari !== ''): ?>
                    <a href="index.php" class="btn-cancel" style="padding:7px 12px;font-size:12px">✕ Reset</a>
                <?php endif; ?>
            </form>
        </div>

        <table class="dash-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Paket</th>
                    <th>Modem</th>
                    <th>Router</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td style="color:var(--gray-400)"><?= $row['id_pelanggan'] ?></td>
                    <td style="font-weight:600"><?= htmlspecialchars($row['nama']) ?></td>
                    <td style="color:var(--gray-600);font-size:12px;max-width:150px"><?= htmlspecialchars($row['alamat']) ?></td>
                    <td>
                        <span class="badge badge-blue">
                            <?= htmlspecialchars($row['jenis_paket'] ?? '-') ?>
                            <?php if ($row['kecepatan_bandwidth']): ?>
                                (<?= $row['kecepatan_bandwidth'] ?> Mbps)
                            <?php endif; ?>
                        </span>
                    </td>
                    <td style="font-size:12px"><?= htmlspecialchars($row['merk_modem'] ?? '-') ?></td>
                    <td style="font-size:12px"><?= htmlspecialchars($row['merk_router'] ?? '-') ?></td>
                    <td>
                        <div style="display:flex;gap:6px">
                            <a href="edit.php?id=<?= $row['id_pelanggan'] ?>" class="btn-action btn-edit" title="Edit">✏️</a>
                            <a href="../../backend/pelanggan/hapus.php?id=<?= $row['id_pelanggan'] ?>"
                               class="btn-action btn-hapus" title="Hapus"
                               onclick="return confirm('Hapus pelanggan ini?')">🗑️</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7" class="empty-state">
                    <?= $cari !== '' ? 'Tidak ada pelanggan dengan kata kunci "' . htmlspecialchars($cari) . '".' : 'Belum ada data pelanggan.' ?>
                </td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
