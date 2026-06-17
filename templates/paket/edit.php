<?php
include __DIR__ . '/../../backend/config/connect.php';

$id   = (int)($_GET['id'] ?? 0);
$res  = mysqli_query($conn, "SELECT * FROM paket WHERE id_paket = $id");
$data = mysqli_fetch_assoc($res);
if (!$data) { header('Location: index.php'); exit; }

include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
include __DIR__ . '/../layouts/navbar.php';
?>
<div class="main-content">
<div class="page-body">

    <a href="index.php" class="btn-back">← Kembali ke Daftar Paket</a>

    <div class="panel">
        <div class="panel-header">
            <div>
                <div class="section-badge">PAKET INTERNET</div>
                <div class="panel-title">Edit Paket</div>
            </div>
        </div>
        <div class="form-wrap">
            <form action="../../backend/paket/edit.php" method="POST">
                <input type="hidden" name="id_paket" value="<?= $data['id_paket'] ?>">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Jenis Paket</label>
                        <input type="text" name="jenis_paket" class="form-control"
                               value="<?= htmlspecialchars($data['jenis_paket']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kecepatan Bandwidth (Mbps)</label>
                        <input type="number" name="kecepatan_bandwidth" class="form-control"
                               value="<?= $data['kecepatan_bandwidth'] ?>" min="1" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control"
                               value="<?= $data['harga'] ?>" min="0" required>
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

</body>
</html>
