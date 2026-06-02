<?php
include __DIR__ . '/../../backend/config/connect.php';

$id   = (int)($_GET['id'] ?? 0);
$res  = mysqli_query($conn, "SELECT * FROM queue WHERE id_queue = $id");
$data = mysqli_fetch_assoc($res);
if (!$data) { header('Location: index.php'); exit; }

$pelanggan_list = mysqli_query($conn, "SELECT id_pelanggan, nama FROM pelanggan ORDER BY nama ASC");

include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
include __DIR__ . '/../layouts/navbar.php';
?>
<div class="main-content">
<div class="page-body">

    <a href="index.php" class="btn-back">← Kembali ke Daftar Queue</a>

    <div class="panel">
        <div class="panel-header">
            <div>
                <div class="section-badge">QUEUE / MIKROTIK</div>
                <div class="panel-title">Edit Queue</div>
            </div>
        </div>
        <div class="form-wrap">
            <form action="../../backend/queue/edit.php" method="POST">
                <input type="hidden" name="id_queue" value="<?= $data['id_queue'] ?>">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">IP Address</label>
                        <input type="text" name="ip_address" class="form-control"
                               value="<?= htmlspecialchars($data['ip_address']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jenis IP</label>
                        <select name="jenis_ip" class="form-select" required>
                            <option value="PPPoE"  <?= $data['jenis_ip'] === 'PPPoE'  ? 'selected' : '' ?>>PPPoE</option>
                            <option value="DHCP"   <?= $data['jenis_ip'] === 'DHCP'   ? 'selected' : '' ?>>DHCP</option>
                            <option value="Static" <?= $data['jenis_ip'] === 'Static' ? 'selected' : '' ?>>Static</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Username Mikrotik</label>
                        <input type="text" name="username_mikrotik" class="form-control"
                               value="<?= htmlspecialchars($data['username_mikrotik']) ?>" required>
                    </div>
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
                        <label class="form-label">Status <span style="color:var(--red)">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="Aktif"   <?= ($data['status'] ?? 'Aktif') === 'Aktif'   ? 'selected' : '' ?>>Aktif</option>
                            <option value="Suspend" <?= ($data['status'] ?? 'Aktif') === 'Suspend' ? 'selected' : '' ?>>Suspend</option>
                            <option value="Isolir"  <?= ($data['status'] ?? 'Aktif') === 'Isolir'  ? 'selected' : '' ?>>Isolir</option>
                        </select>
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
