<?php
include __DIR__ . '/../../backend/config/connect.php';
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
                <div class="panel-title">Tambah Teknisi Baru</div>
            </div>
        </div>
        <div class="form-wrap">
            <form action="../../backend/teknisi/tambah.php" method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Teknisi</label>
                        <input type="text" name="nama" class="form-control"
                               placeholder="Nama lengkap teknisi" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control"
                               placeholder="Alamat teknisi" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
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
