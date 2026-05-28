<?php
include __DIR__ . '/../../backend/config/connect.php';

$id = (int)($_GET['id'] ?? 0);
$res = mysqli_query($conn, "SELECT * FROM modem WHERE id_modem = $id");
$data = mysqli_fetch_assoc($res);
if (!$data) { header('Location: index.php'); exit; }

include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
include __DIR__ . '/../layouts/navbar.php';
?>
<div class="main-content">
<div class="page-body">

    <a href="index.php" class="btn-back">← Kembali ke Daftar Modem</a>

    <div class="panel">
        <div class="panel-header">
            <div>
                <div class="section-badge">MODEM</div>
                <div class="panel-title">Edit Modem</div>
            </div>
        </div>
        <div class="form-wrap">
            <form action="../../backend/modem/edit.php" method="POST">
                <input type="hidden" name="id_modem" value="<?= $data['id_modem'] ?>">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Merk Modem</label>
                        <input type="text" name="merk" class="form-control"
                               value="<?= htmlspecialchars($data['merk']) ?>" required>
                    </div>
                    <div class="col-md-6">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
