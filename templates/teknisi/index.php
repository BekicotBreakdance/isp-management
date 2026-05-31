<?php
include __DIR__ . '/../../backend/config/connect.php';
include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
include __DIR__ . '/../layouts/navbar.php';

$result = mysqli_query($conn, "SELECT * FROM teknisi ORDER BY id_teknisi ASC");
$pesan  = $_GET['pesan'] ?? '';
$notif  = [
    'tambah_berhasil' => ['teks' => '✅ Teknisi berhasil ditambahkan!', 'class' => 'notif-success'],
    'tambah_gagal'    => ['teks' => '❌ Gagal menambahkan teknisi.',    'class' => 'notif-error'],
    'edit_berhasil'   => ['teks' => '✅ Teknisi berhasil diperbarui!',  'class' => 'notif-success'],
    'edit_gagal'      => ['teks' => '❌ Gagal memperbarui teknisi.',    'class' => 'notif-error'],
    'hapus_berhasil'  => ['teks' => '✅ Teknisi berhasil dihapus!',    'class' => 'notif-success'],
    'hapus_gagal'     => ['teks' => '❌ Gagal menghapus teknisi.',      'class' => 'notif-error'],
    'hapus_gagal_relasi' => ['teks' => '⚠️ Teknisi tidak bisa dihapus karena masih memiliki riwayat maintenance.', 'class' => 'notif-error'],
];
?>
<div class="main-content">
<div class="page-body">

    <div class="page-actions">
        <div>
            <div class="page-title">Data Teknisi</div>
            <div class="page-subtitle">Kelola data teknisi lapangan.</div>
        </div>
        <a href="tambah.php"><button class="btn-primary-sm">➕ Tambah Teknisi</button></a>
    </div>

    <?php if ($pesan && isset($notif[$pesan])): ?>
        <div class="notif <?= $notif[$pesan]['class'] ?>"><?= $notif[$pesan]['teks'] ?></div>
    <?php endif; ?>

    <div class="panel">
        <div class="panel-header"><div class="panel-title">Daftar Teknisi</div></div>
        <table class="dash-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Jenis Kelamin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td style="color:var(--gray-400)"><?= $row['id_teknisi'] ?></td>
                    <td style="font-weight:600"><?= htmlspecialchars($row['nama']) ?></td>
                    <td style="color:var(--gray-600)"><?= htmlspecialchars($row['alamat']) ?></td>
                    <td>
                        <span class="badge <?= $row['jenis_kelamin'] === 'Laki-laki' ? 'badge-blue' : 'badge-green' ?>">
                            <?= htmlspecialchars($row['jenis_kelamin']) ?>
                        </span>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px">
                            <a href="edit.php?id=<?= $row['id_teknisi'] ?>" class="btn-action btn-edit" title="Edit">✏️</a>
                            <a href="../../backend/teknisi/hapus.php?id=<?= $row['id_teknisi'] ?>"
                               class="btn-action btn-hapus" title="Hapus"
                               onclick="return confirm('Hapus teknisi ini?')">🗑️</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="5" class="empty-state">Belum ada data teknisi.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
