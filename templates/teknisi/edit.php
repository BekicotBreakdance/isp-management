<?php
include __DIR__ . '/../../backend/config/connect.php';

$id   = (int)($_GET['id'] ?? 0);
$res  = mysqli_query($conn, "SELECT * FROM teknisi WHERE id_teknisi = $id");
$data = mysqli_fetch_assoc($res);
if (!$data) { header('Location: index.php'); exit; }

include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
include __DIR__ . '/../layouts/navbar.php';
?>
<div class="main-content">
<div class="page-body">

    <a href="index.php" class="btn-back">← Kembali ke Daftar Teknisi</a>

    <div class="panel">
        <div class="panel-header">
            <div>
                <div class="section-badge">TEKNISI</div>
                <div class="panel-title">Edit Teknisi</div>
            </div>
        </div>
        <div class="form-wrap">
            <form action="../../backend/teknisi/edit.php" method="POST">
                <input type="hidden" name="id_teknisi" value="<?= $data['id_teknisi'] ?>">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Teknisi</label>
                        <input type="text" name="nama" class="form-control"
                               value="<?= htmlspecialchars($data['nama']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control"
                               value="<?= htmlspecialchars($data['alamat']) ?>" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="Laki-laki"  <?= $data['jenis_kelamin'] === 'Laki-laki'  ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="Perempuan"  <?= $data['jenis_kelamin'] === 'Perempuan'  ? 'selected' : '' ?>>Perempuan</option>
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
