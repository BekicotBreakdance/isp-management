<?php
include __DIR__ . '/../../backend/config/connect.php';

$id   = (int)($_GET['id'] ?? 0);
$res  = mysqli_query($conn, "SELECT * FROM billing WHERE id_billing = $id");
$data = mysqli_fetch_assoc($res);
if (!$data) { header('Location: index.php'); exit; }

$pelanggan_list = mysqli_query($conn, "SELECT id_pelanggan, nama FROM pelanggan ORDER BY nama ASC");

include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
include __DIR__ . '/../layouts/navbar.php';
?>
<div class="main-content">
<div class="page-body">

    <a href="index.php" class="btn-back">← Kembali ke Daftar Billing</a>

    <div class="panel">
        <div class="panel-header">
            <div>
                <div class="section-badge">BILLING</div>
                <div class="panel-title">Edit Tagihan</div>
            </div>
        </div>
        <div class="form-wrap">
            <form action="../../backend/billing/edit.php" method="POST">
                <input type="hidden" name="id_billing" value="<?= $data['id_billing'] ?>">
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
                    <div class="col-md-3">
                        <label class="form-label">Status Pembayaran</label>
                        <select name="status" class="form-select" required>
                            <option value="Belum Lunas" <?= $data['status'] === 'Belum Lunas' ? 'selected' : '' ?>>Belum Lunas</option>
                            <option value="Lunas"       <?= $data['status'] === 'Lunas'       ? 'selected' : '' ?>>Lunas</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Tagihan</label>
                        <input type="date" name="tanggal_tagihan" class="form-control"
                               value="<?= htmlspecialchars($data['tanggal_tagihan']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Bayar <small style="color:var(--gray-400)">(opsional)</small></label>
                        <input type="date" name="tanggal_bayar" class="form-control"
                               value="<?= htmlspecialchars($data['tanggal_bayar'] ?? '') ?>">
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
