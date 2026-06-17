<?php
include __DIR__ . '/../../backend/config/connect.php';
include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
include __DIR__ . '/../layouts/navbar.php';

$result = mysqli_query($conn, "SELECT * FROM modem ORDER BY id_modem ASC");

$pesan = $_GET['pesan'] ?? '';
$notif = [
    'tambah_berhasil' => ['teks' => 'Modem berhasil ditambahkan!', 'class' => 'notif-success'],
    'tambah_gagal'    => ['teks' => 'Gagal menambahkan modem.',    'class' => 'notif-error'],
    'edit_berhasil'   => ['teks' => 'Modem berhasil diperbarui!',  'class' => 'notif-success'],
    'edit_gagal'      => ['teks' => 'Gagal memperbarui modem.',    'class' => 'notif-error'],
    'hapus_berhasil'  => ['teks' => 'Modem berhasil dihapus!',    'class' => 'notif-success'],
    'hapus_gagal'     => ['teks' => 'Gagal menghapus modem.',      'class' => 'notif-error'],
    'hapus_gagal_relasi' => ['teks' => 'Modem tidak bisa dihapus karena masih terpasang pada pelanggan aktif.', 'class' => 'notif-error'],
];
?>
<div class="main-content">
<div class="page-body">

    <div class="page-actions">
        <div>
            <div class="page-title">Data Modem</div>
            <div class="page-subtitle">Kelola inventaris modem yang tersedia.</div>
        </div>
        <a href="tambah.php"><button class="btn-primary-sm">➕ Tambah Modem</button></a>
    </div>

    <?php if ($pesan && isset($notif[$pesan])): ?>
        <div class="notif <?= $notif[$pesan]['class'] ?>"><?= $notif[$pesan]['teks'] ?></div>
    <?php endif; ?>

    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">Daftar Modem</div>
        </div>
        <table class="dash-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Merk</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td style="color:var(--gray-400)"><?= $row['id_modem'] ?></td>
                    <td style="font-weight:600"><?= htmlspecialchars($row['merk']) ?></td>
                    <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                    <td>
                        <div style="display:flex;gap:6px">
                            <a href="edit.php?id=<?= $row['id_modem'] ?>" class="btn-action btn-edit" title="Edit">✏️</a>
                            <a href="../../backend/modem/hapus.php?id=<?= $row['id_modem'] ?>"
                               class="btn-action btn-hapus" title="Hapus"
                               onclick="return confirm('Hapus modem ini?')">🗑️</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4" class="empty-state">Belum ada data modem.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
</div>

</body>
</html>
