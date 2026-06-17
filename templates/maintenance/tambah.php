<?php
include __DIR__ . '/../../backend/config/connect.php';
include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
include __DIR__ . '/../layouts/navbar.php';

$pelanggan_list = mysqli_query($conn, "SELECT id_pelanggan, nama FROM pelanggan ORDER BY nama ASC");
$teknisi_list   = mysqli_query($conn, "SELECT id_teknisi, nama FROM teknisi ORDER BY nama ASC");
?>
<div class="main-content">
<div class="page-body">

    <a href="index.php" class="btn-back">← Kembali ke Daftar Maintenance</a>

    <div class="panel">
        <div class="panel-header">
            <div>
                <div class="section-badge">MAINTENANCE</div>
                <div class="panel-title">Input Maintenance Baru</div>
            </div>
        </div>
        <div class="form-wrap">
            <form action="../../backend/maintenance/tambah.php" method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Pelanggan <span style="color:var(--red)">*</span></label>
                        <select name="id_pelanggan" class="form-select" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            <?php while ($p = mysqli_fetch_assoc($pelanggan_list)): ?>
                            <option value="<?= $p['id_pelanggan'] ?>"><?= htmlspecialchars($p['nama']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Teknisi <span style="color:var(--red)">*</span></label>
                        <select name="id_teknisi" class="form-select" required>
                            <option value="">-- Pilih Teknisi --</option>
                            <?php while ($t = mysqli_fetch_assoc($teknisi_list)): ?>
                            <option value="<?= $t['id_teknisi'] ?>"><?= htmlspecialchars($t['nama']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Maintenance</label>
                        <input type="date" name="tanggal_mt" class="form-control"
                               value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status <span style="color:var(--red)">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="Proses">Proses</option>
                            <option value="Pending">Pending</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Detail Kendala</label>
                        <textarea name="detail_kendala_singkat" class="form-control"
                                  placeholder="Jelaskan kendala yang dialami pelanggan..." required></textarea>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-submit">💾 Simpan</button>
                    <a href="index.php" class="btn-cancel">Batal</a>
                </div>
            </form>
        </div>
    </div>

</div>
</div>

</body>
</html>
