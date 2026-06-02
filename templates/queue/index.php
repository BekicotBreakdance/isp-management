<?php
include __DIR__ . '/../../backend/config/connect.php';
include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
include __DIR__ . '/../layouts/navbar.php';

$result = mysqli_query($conn, "
    SELECT q.*, p.nama AS nama_pelanggan, pk.jenis_paket, pk.kecepatan_bandwidth
    FROM queue q
    LEFT JOIN pelanggan p  ON q.id_pelanggan = p.id_pelanggan
    LEFT JOIN paket     pk ON p.id_paket      = pk.id_paket
    ORDER BY q.id_queue ASC
");

$pesan = $_GET['pesan'] ?? '';
$notif = [
    'tambah_berhasil' => ['teks' => 'Queue berhasil ditambahkan!', 'class' => 'notif-success'],
    'tambah_gagal'    => ['teks' => 'Gagal menambahkan queue.',    'class' => 'notif-error'],
    'edit_berhasil'   => ['teks' => 'Queue berhasil diperbarui!',  'class' => 'notif-success'],
    'edit_gagal'      => ['teks' => 'Gagal memperbarui queue.',    'class' => 'notif-error'],
    'hapus_berhasil'  => ['teks' => 'Queue berhasil dihapus!',    'class' => 'notif-success'],
    'hapus_gagal'     => ['teks' => 'Gagal menghapus queue.',      'class' => 'notif-error'],
];
?>
<div class="main-content">
<div class="page-body">

    <div class="page-actions">
        <div>
            <div class="page-title">Queue / Mikrotik</div>
            <div class="page-subtitle">Kelola data queue dan IP pelanggan di Mikrotik.</div>
        </div>
        <a href="tambah.php"><button class="btn-primary-sm">➕ Tambah Queue</button></a>
    </div>

    <?php if ($pesan && isset($notif[$pesan])): ?>
        <div class="notif <?= $notif[$pesan]['class'] ?>"><?= $notif[$pesan]['teks'] ?></div>
    <?php endif; ?>

    <div class="panel">
        <div class="panel-header"><div class="panel-title">Daftar Queue</div></div>
        <table class="dash-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>IP Address</th>
                    <th>Jenis IP</th>
                    <th>Username Mikrotik</th>
                    <th>Pelanggan</th>
                    <th>Paket</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if ($result && mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td style="color:var(--gray-400)"><?= $row['id_queue'] ?></td>
                    <td style="font-family:monospace;font-size:12px;font-weight:600"><?= htmlspecialchars($row['ip_address']) ?></td>
                    <td><span class="badge badge-blue"><?= htmlspecialchars($row['jenis_ip']) ?></span></td>
                    <td style="font-family:monospace;font-size:12px"><?= htmlspecialchars($row['username_mikrotik']) ?></td>
                    <td style="font-weight:600"><?= htmlspecialchars($row['nama_pelanggan'] ?? '-') ?></td>
                    <td>
                        <?php if ($row['jenis_paket']): ?>
                            <span class="badge badge-blue"><?= htmlspecialchars($row['jenis_paket']) ?> (<?= $row['kecepatan_bandwidth'] ?> Mbps)</span>
                        <?php else: ?> - <?php endif; ?>
                    </td>
                    <td>
                        <?php
                        $qBadge = match($row['status'] ?? 'Aktif') {
                            'Aktif'   => 'badge-green',
                            'Suspend' => 'badge-yellow',
                            'Isolir'  => 'badge-red',
                            default   => 'badge-gray',
                        };
                        ?>
                        <span class="badge <?= $qBadge ?>"><?= htmlspecialchars($row['status'] ?? 'Aktif') ?></span>
                    </td>
                    <td>
                        <div style="display:flex;gap:6px">
                            <a href="edit.php?id=<?= $row['id_queue'] ?>" class="btn-action btn-edit" title="Edit">✏️</a>
                            <a href="../../backend/queue/hapus.php?id=<?= $row['id_queue'] ?>"
                               class="btn-action btn-hapus" title="Hapus"
                               onclick="return confirm('Hapus queue ini?')">🗑️</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8" class="empty-state">Belum ada data queue.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
