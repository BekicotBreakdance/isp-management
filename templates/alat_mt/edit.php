<?php
include __DIR__ . '/../../backend/config/connect.php';
$id   = (int)($_GET['id'] ?? 0);
$res  = mysqli_query($conn, "SELECT * FROM alat_mt WHERE id_alat = $id");
$data = mysqli_fetch_assoc($res);
if (!$data) { header('Location: index.php'); exit; }

include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
include __DIR__ . '/../layouts/navbar.php';
?>
<div class="main-content">
<div class="page-body">
    <a href="index.php" class="btn-back">← Kembali ke Daftar Alat</a>
    <div class="panel">
        <div class="panel-header">
            <div><div class="section-badge">ALAT MAINTENANCE</div><div class="panel-title">Edit Alat</div></div>
        </div>
        <div class="form-wrap">
            <form action="../../backend/alat_mt/edit.php" method="POST">
                <input type="hidden" name="id_alat" value="<?= $data['id_alat'] ?>">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Alat</label>
                        <input type="text" name="nama_alat" class="form-control"
                               value="<?= htmlspecialchars($data['nama_alat']) ?>" required>
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
