<?php
include __DIR__ . '/../../backend/config/connect.php';
include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
include __DIR__ . '/../layouts/navbar.php';

$result = mysqli_query($conn, "SELECT * FROM alat_mt ORDER BY id_alat ASC");
$pesan  = $_GET['pesan'] ?? '';
$notif  = [
    'tambah_berhasil' => ['teks' => '✅ Alat berhasil ditambahkan!', 'class' => 'notif-success'],
    'tambah_gagal'    => ['teks' => '❌ Gagal menambahkan alat.',    'class' => 'notif-error'],
    'edit_berhasil'   => ['teks' => '✅ Alat berhasil diperbarui!',  'class' => 'notif-success'],
    'edit_gagal'      => ['teks' => '❌ Gagal memperbarui alat.',    'class' => 'notif-error'],
    'hapus_berhasil'  => ['teks' => '✅ Alat berhasil dihapus!',    'class' => 'notif-success'],
    'hapus_gagal'     => ['teks' => '❌ Gagal menghapus alat.',      'class' => 'notif-error'],
];
?>
<div class="main-content">
<div class="page-body">

    <div class="page-actions">
        <div>
            <div class="page-title">Alat Maintenance</div>
            <div class="page-subtitle">Kelola inventaris alat yang digunakan saat maintenance.</div>
        </div>
        <a href="tambah.php"><button class="btn-primary-sm">➕ Tambah Alat</button></a>
    </div>

    <?php if ($pesan && isset($notif[$pesan])): ?>
        <div class="notif <?= $notif[$pesan]['class'] ?>"><?= $notif[$pesan]['teks'] ?></div>
    <?php endif; ?>

    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">Daftar Alat</div>
            <div style="font-size:12px;color:var(--gray-400)">
                💡 Alat digunakan di halaman <a href="../maintenance/index.php" style="color:var(--blue-mid)">Maintenance → Detail</a>
            </div>
        </div>
        <table class="dash-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Alat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td style="color:var(--gray-400)"><?= $row['id_alat'] ?></td>
                    <td style="font-weight:600"><?= htmlspecialchars($row['nama_alat']) ?></td>
                    <td>
                        <div style="display:flex;gap:6px">
                            <a href="edit.php?id=<?= $row['id_alat'] ?>" class="btn-action btn-edit" title="Edit">✏️</a>
                            <a href="../../backend/alat_mt/hapus.php?id=<?= $row['id_alat'] ?>"
                               class="btn-action btn-hapus" title="Hapus"
                               onclick="return confirm('Hapus alat ini?')">🗑️</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="3" class="empty-state">Belum ada data alat maintenance.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
