<?php
include __DIR__ . '/../../backend/config/connect.php';

$id   = (int)($_GET['id'] ?? 0);
$res  = mysqli_query($conn, "SELECT * FROM maintenance WHERE id_mt = $id");
$data = mysqli_fetch_assoc($res);
if (!$data) { header('Location: index.php'); exit; }

$pelanggan_list = mysqli_query($conn, "SELECT id_pelanggan, nama FROM pelanggan ORDER BY nama ASC");
$teknisi_list   = mysqli_query($conn, "SELECT id_teknisi, nama FROM teknisi ORDER BY nama ASC");

include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
include __DIR__ . '/../layouts/navbar.php';
?>
<div class="main-content">
<div class="page-body">

    <a href="index.php" class="btn-back">← Kembali ke Daftar Maintenance</a>

    <div class="panel">
        <div class="panel-header">
            <div>
                <div class="section-badge">MAINTENANCE</div>
                <div class="panel-title">Edit Maintenance</div>
            </div>
        </div>
        <div class="form-wrap">
            <form action="../../backend/maintenance/edit.php" method="POST">
                <input type="hidden" name="id_mt" value="<?= $data['id_mt'] ?>">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Pelanggan</label>
                        <select name="id_pelanggan" class="form-select" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            <?php while ($p = mysqli_fetch_assoc($pelanggan_list)): ?>
                            <option value="<?= $p['id_pelanggan'] ?>"
                                <?= $data['id_pelanggan'] == $p['id_pelanggan'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($p['nama']) ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Teknisi</label>
                        <select name="id_teknisi" class="form-select" required>
                            <option value="">-- Pilih Teknisi --</option>
                            <?php while ($t = mysqli_fetch_assoc($teknisi_list)): ?>
                            <option value="<?= $t['id_teknisi'] ?>"
                                <?= $data['id_teknisi'] == $t['id_teknisi'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($t['nama']) ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Maintenance</label>
                        <input type="date" name="tanggal_mt" class="form-control"
                               value="<?= htmlspecialchars($data['tanggal_mt']) ?>" required>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Detail Kendala</label>
                        <textarea name="detail_kendala_singkat" class="form-control" required><?= htmlspecialchars($data['detail_kendala_singkat']) ?></textarea>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-submit">💾 Simpan Perubahan</button>
                    <a href="index.php" class="btn-cancel">Batal</a>
                </div>
            </form>
        </div>
    </div>

</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
