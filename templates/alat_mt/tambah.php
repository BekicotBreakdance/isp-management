<?php
include __DIR__ . '/../../backend/config/connect.php';
include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
include __DIR__ . '/../layouts/navbar.php';
?>
<div class="main-content">
<div class="page-body">
    <a href="index.php" class="btn-back">← Kembali ke Daftar Alat</a>
    <div class="panel">
        <div class="panel-header">
            <div><div class="section-badge">ALAT MAINTENANCE</div><div class="panel-title">Tambah Alat Baru</div></div>
        </div>
        <div class="form-wrap">
            <form action="../../backend/alat_mt/tambah.php" method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Alat</label>
                        <input type="text" name="nama_alat" class="form-control"
                               placeholder="cth: Tang Krimping, Kabel UTP, dll." required>
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
