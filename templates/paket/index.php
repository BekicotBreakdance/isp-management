<?php
include __DIR__ . '/../../backend/config/connect.php';
include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
include __DIR__ . '/../layouts/navbar.php';

$result = mysqli_query($conn, "SELECT * FROM paket ORDER BY harga ASC");

$pesan = $_GET['pesan'] ?? '';
$notif = [
    'tambah_berhasil' => ['teks' => '✅ Paket berhasil ditambahkan!', 'class' => 'notif-success'],
    'tambah_gagal'    => ['teks' => '❌ Gagal menambahkan paket.',    'class' => 'notif-error'],
    'edit_berhasil'   => ['teks' => '✅ Paket berhasil diperbarui!',  'class' => 'notif-success'],
    'edit_gagal'      => ['teks' => '❌ Gagal memperbarui paket.',    'class' => 'notif-error'],
    'hapus_berhasil'  => ['teks' => '✅ Paket berhasil dihapus!',    'class' => 'notif-success'],
    'hapus_gagal'     => ['teks' => '❌ Gagal menghapus paket.',      'class' => 'notif-error'],
];
?>
<div class="main-content">
<div class="page-body">

    <div class="page-actions">
        <div>
            <div class="page-title">Paket Internet</div>
            <div class="page-subtitle">Kelola daftar paket layanan internet.</div>
        </div>
        <a href="tambah.php"><button class="btn-primary-sm">➕ Tambah Paket</button></a>
    </div>

    <?php if ($pesan && isset($notif[$pesan])): ?>
        <div class="notif <?= $notif[$pesan]['class'] ?>"><?= $notif[$pesan]['teks'] ?></div>
    <?php endif; ?>

    <div class="panel">
        <div class="panel-header"><div class="panel-title">Daftar Paket</div></div>
        <table class="dash-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Jenis Paket</th>
                    <th>Kecepatan</th>
                    <th>Harga / Bulan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td style="color:var(--gray-400)"><?= $row['id_paket'] ?></td>
                    <td style="font-weight:600"><?= htmlspecialchars($row['jenis_paket']) ?></td>
                    <td><span class="badge badge-blue"><?= $row['kecepatan_bandwidth'] ?> Mbps</span></td>
                    <td style="font-weight:600">Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                    <td>
                        <div style="display:flex;gap:6px">
                            <a href="edit.php?id=<?= $row['id_paket'] ?>" class="btn-action btn-edit" title="Edit">✏️</a>
                            <a href="../../backend/paket/hapus.php?id=<?= $row['id_paket'] ?>"
                               class="btn-action btn-hapus" title="Hapus"
                               onclick="return confirm('Hapus paket ini?')">🗑️</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" class="empty-state">Belum ada data paket.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
