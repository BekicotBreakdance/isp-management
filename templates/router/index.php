<?php
include __DIR__ . '/../../backend/config/connect.php';
include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
include __DIR__ . '/../layouts/navbar.php';

$result = mysqli_query($conn, "SELECT * FROM router ORDER BY id_router ASC");

$pesan = $_GET['pesan'] ?? '';
$notif = [
    'tambah_berhasil' => ['teks' => '✅ Router berhasil ditambahkan!', 'class' => 'notif-success'],
    'tambah_gagal'    => ['teks' => '❌ Gagal menambahkan router.',    'class' => 'notif-error'],
    'edit_berhasil'   => ['teks' => '✅ Router berhasil diperbarui!',  'class' => 'notif-success'],
    'edit_gagal'      => ['teks' => '❌ Gagal memperbarui router.',    'class' => 'notif-error'],
    'hapus_berhasil'  => ['teks' => '✅ Router berhasil dihapus!',    'class' => 'notif-success'],
    'hapus_gagal'     => ['teks' => '❌ Gagal menghapus router.',      'class' => 'notif-error'],
    'hapus_gagal_relasi' => ['teks' => '⚠️ Router tidak bisa dihapus karena masih terpasang pada pelanggan aktif.', 'class' => 'notif-error'],
];
?>
<div class="main-content">
<div class="page-body">

    <div class="page-actions">
        <div>
            <div class="page-title">Data Router</div>
            <div class="page-subtitle">Kelola inventaris router yang tersedia.</div>
        </div>
        <a href="tambah.php"><button class="btn-primary-sm">➕ Tambah Router</button></a>
    </div>

    <?php if ($pesan && isset($notif[$pesan])): ?>
        <div class="notif <?= $notif[$pesan]['class'] ?>"><?= $notif[$pesan]['teks'] ?></div>
    <?php endif; ?>

    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">Daftar Router</div>
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
                    <td style="color:var(--gray-400)"><?= $row['id_router'] ?></td>
                    <td style="font-weight:600"><?= htmlspecialchars($row['merk']) ?></td>
                    <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                    <td>
                        <div style="display:flex;gap:6px">
                            <a href="edit.php?id=<?= $row['id_router'] ?>" class="btn-action btn-edit" title="Edit">✏️</a>
                            <a href="../../backend/router/hapus.php?id=<?= $row['id_router'] ?>"
                               class="btn-action btn-hapus" title="Hapus"
                               onclick="return confirm('Hapus router ini?')">🗑️</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4" class="empty-state">Belum ada data router.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
