<?php
include __DIR__ . '/../../backend/config/connect.php';
include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
include __DIR__ . '/../layouts/navbar.php';

$paket_list  = mysqli_query($conn, "SELECT id_paket, jenis_paket, kecepatan_bandwidth FROM paket ORDER BY harga ASC");
$modem_list  = mysqli_query($conn, "SELECT id_modem, merk FROM modem ORDER BY merk ASC");
$router_list = mysqli_query($conn, "SELECT id_router, merk FROM router ORDER BY merk ASC");
?>
<div class="main-content">
<div class="page-body">

    <a href="index.php" class="btn-back">← Kembali ke Daftar Pelanggan</a>

    <div class="panel">
        <div class="panel-header">
            <div>
                <div class="section-badge">PELANGGAN</div>
                <div class="panel-title">Tambah Pelanggan Baru</div>
            </div>
        </div>
        <div class="form-wrap">
            <form action="../../backend/pelanggan/tambah.php" method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Pelanggan</label>
                        <input type="text" name="nama" class="form-control"
                               placeholder="Nama lengkap pelanggan" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control"
                               placeholder="Alamat lengkap" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Paket Internet <span style="color:var(--red)">*</span></label>
                        <select name="id_paket" class="form-select" required>
                            <option value="">-- Pilih Paket --</option>
                            <?php while ($pk = mysqli_fetch_assoc($paket_list)): ?>
                            <option value="<?= $pk['id_paket'] ?>">
                                <?= htmlspecialchars($pk['jenis_paket']) ?> (<?= $pk['kecepatan_bandwidth'] ?> Mbps)
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Modem <small style="color:var(--gray-400)">(opsional)</small></label>
                        <select name="id_modem" class="form-select">
                            <option value="">-- Tidak Ada --</option>
                            <?php while ($m = mysqli_fetch_assoc($modem_list)): ?>
                            <option value="<?= $m['id_modem'] ?>"><?= htmlspecialchars($m['merk']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Router <small style="color:var(--gray-400)">(opsional)</small></label>
                        <select name="id_router" class="form-select">
                            <option value="">-- Tidak Ada --</option>
                            <?php while ($r = mysqli_fetch_assoc($router_list)): ?>
                            <option value="<?= $r['id_router'] ?>"><?= htmlspecialchars($r['merk']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status <span style="color:var(--red)">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
