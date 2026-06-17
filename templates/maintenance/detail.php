<?php
include __DIR__ . '/../../backend/config/connect.php';

$id  = (int)($_GET['id'] ?? 0);
$res = mysqli_query($conn, "
    SELECT m.*, p.nama AS nama_pelanggan, t.nama AS nama_teknisi
    FROM maintenance m
    LEFT JOIN pelanggan p ON m.id_pelanggan = p.id_pelanggan
    LEFT JOIN teknisi   t ON m.id_teknisi   = t.id_teknisi
    WHERE m.id_mt = $id
");
$mt = mysqli_fetch_assoc($res);
if (!$mt) { header('Location: index.php'); exit; }

// Alat yang sudah dipakai di maintenance ini
$detail_res = mysqli_query($conn, "
    SELECT d.id_detail, d.jumlah, a.nama_alat
    FROM detail_alat_mt d
    LEFT JOIN alat_mt a ON d.id_alat = a.id_alat
    WHERE d.id_mt = $id
    ORDER BY d.id_detail ASC
");

// Semua alat (untuk dropdown tambah)
$alat_res = mysqli_query($conn, "SELECT id_alat, nama_alat FROM alat_mt ORDER BY nama_alat ASC");

$pesan = $_GET['pesan'] ?? '';
$notif = [
    'alat_ditambahkan' => ['teks' => 'Alat berhasil ditambahkan!',  'class' => 'notif-success'],
    'alat_gagal'       => ['teks' => 'Gagal menambahkan alat.',     'class' => 'notif-error'],
    'alat_dihapus'     => ['teks' => 'Alat berhasil dihapus!',     'class' => 'notif-success'],
    'alat_hapus_gagal' => ['teks' => 'Gagal menghapus alat.',       'class' => 'notif-error'],
];

include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
include __DIR__ . '/../layouts/navbar.php';
?>
<div class="main-content">
<div class="page-body">

    <a href="index.php" class="btn-back">← Kembali ke Daftar Maintenance</a>

    <?php if ($pesan && isset($notif[$pesan])): ?>
        <div class="notif <?= $notif[$pesan]['class'] ?>"><?= $notif[$pesan]['teks'] ?></div>
    <?php endif; ?>

    <!-- Info maintenance -->
    <div class="panel" style="margin-bottom:20px">
        <div class="panel-header">
            <div>
                <div class="section-badge">DETAIL MAINTENANCE</div>
                <div class="panel-title">MT #<?= $mt['id_mt'] ?> — <?= htmlspecialchars($mt['nama_pelanggan'] ?? '-') ?></div>
            </div>
            <a href="edit.php?id=<?= $mt['id_mt'] ?>">
                <button class="btn-primary-sm">✏️ Edit Maintenance</button>
            </a>
        </div>
        <div style="padding:20px;display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px">
            <div>
                <div style="font-size:11px;color:var(--gray-400);text-transform:uppercase;font-weight:700;margin-bottom:4px">Pelanggan</div>
                <div style="font-weight:600"><?= htmlspecialchars($mt['nama_pelanggan'] ?? '-') ?></div>
            </div>
            <div>
                <div style="font-size:11px;color:var(--gray-400);text-transform:uppercase;font-weight:700;margin-bottom:4px">Teknisi</div>
                <div style="font-weight:600"><?= htmlspecialchars($mt['nama_teknisi'] ?? '-') ?></div>
            </div>
            <div>
                <div style="font-size:11px;color:var(--gray-400);text-transform:uppercase;font-weight:700;margin-bottom:4px">Tanggal</div>
                <div style="font-weight:600"><?= htmlspecialchars($mt['tanggal_mt']) ?></div>
            </div>
            <div style="grid-column:1/-1">
                <div style="font-size:11px;color:var(--gray-400);text-transform:uppercase;font-weight:700;margin-bottom:4px">Detail Kendala</div>
                <div style="color:var(--gray-600)"><?= htmlspecialchars($mt['detail_kendala_singkat']) ?></div>
            </div>
        </div>
    </div>

    <!-- Alat yang digunakan -->
    <div class="panel">
        <div class="panel-header">
            <div class="panel-title">⚙️ Alat yang Digunakan</div>
        </div>

        <table class="dash-table">
            <thead>
                <tr><th>Nama Alat</th><th>Jumlah</th><th>Hapus</th></tr>
            </thead>
            <tbody>
            <?php if ($detail_res && mysqli_num_rows($detail_res) > 0): ?>
                <?php while ($d = mysqli_fetch_assoc($detail_res)): ?>
                <tr>
                    <td style="font-weight:600"><?= htmlspecialchars($d['nama_alat']) ?></td>
                    <td><span class="badge badge-blue"><?= $d['jumlah'] ?> pcs</span></td>
                    <td>
                        <a href="../../backend/detail_alat_mt/hapus.php?id=<?= $d['id_detail'] ?>&id_mt=<?= $id ?>"
                           class="btn-action btn-hapus" title="Hapus alat ini"
                           onclick="return confirm('Hapus alat dari daftar ini?')">🗑️</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="3" class="empty-state">Belum ada alat yang dicatat.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>

        <!-- Form tambah alat -->
        <div style="padding:16px 20px;border-top:1px solid var(--gray-200);background:var(--gray-50)">
            <div style="font-size:13px;font-weight:700;color:var(--gray-600);margin-bottom:12px">➕ Tambah Alat yang Digunakan</div>
            <?php if (mysqli_num_rows($alat_res) > 0): ?>
            <form action="../../backend/detail_alat_mt/tambah.php" method="POST"
                  style="display:flex;gap:10px;align-items:flex-end;flex-wrap:wrap">
                <input type="hidden" name="id_mt" value="<?= $id ?>">
                <div>
                    <label style="font-size:12px;font-weight:600;color:var(--gray-600);display:block;margin-bottom:4px">Pilih Alat</label>
                    <select name="id_alat" class="form-select" style="font-size:13px;min-width:200px" required>
                        <option value="">-- Pilih Alat --</option>
                        <?php while ($a = mysqli_fetch_assoc($alat_res)): ?>
                        <option value="<?= $a['id_alat'] ?>"><?= htmlspecialchars($a['nama_alat']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div>
                    <label style="font-size:12px;font-weight:600;color:var(--gray-600);display:block;margin-bottom:4px">Jumlah</label>
                    <input type="number" name="jumlah" value="1" min="1"
                           class="form-control" style="width:80px;font-size:13px" required>
                </div>
                <button type="submit" class="btn-submit" style="margin-bottom:1px">Tambahkan</button>
            </form>
            <?php else: ?>
                <div style="font-size:13px;color:var(--gray-400)">
                    Belum ada alat di database.
                    <a href="../alat_mt/tambah.php" style="color:var(--blue-mid)">→ Tambah Alat terlebih dahulu</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

</div>
</div>

</body>
</html>
