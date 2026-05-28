<?php
include __DIR__ . '/../../backend/config/connect.php';
include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
include __DIR__ . '/../layouts/navbar.php';
?>
<div class="main-content">
<div class="page-body">

    <a href="index.php" class="btn-back">← Kembali ke Daftar Router</a>

    <div class="panel">
        <div class="panel-header">
            <div>
                <div class="section-badge">ROUTER</div>
                <div class="panel-title">Tambah Router Baru</div>
            </div>
        </div>
        <div class="form-wrap">
            <form action="../../backend/router/tambah.php" method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Merk Router</label>
                        <input type="text" name="merk" class="form-control" placeholder="cth: MikroTik RB941" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" placeholder="cth: 500000" min="0" required>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
