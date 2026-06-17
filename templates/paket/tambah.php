<?php
include __DIR__ . '/../../backend/config/connect.php';
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
                <div class="panel-title">Tambah Paket Baru</div>
            </div>
        </div>
        <div class="form-wrap">
            <form action="../../backend/paket/tambah.php" method="POST">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Jenis Paket</label>
                        <input type="text" name="jenis_paket" class="form-control"
                               placeholder="cth: 20 Mbps / Gaming" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Kecepatan Bandwidth (Mbps)</label>
                        <input type="number" name="kecepatan_bandwidth" class="form-control"
                               placeholder="cth: 20" min="1" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control"
                               placeholder="cth: 150000" min="0" required>
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
