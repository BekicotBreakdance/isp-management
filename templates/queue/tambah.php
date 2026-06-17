<?php
include __DIR__ . '/../../backend/config/connect.php';
include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
include __DIR__ . '/../layouts/navbar.php';

$pelanggan_list = mysqli_query($conn, "SELECT id_pelanggan, nama FROM pelanggan ORDER BY nama ASC");
?>
<div class="main-content">
<div class="page-body">

    <a href="index.php" class="btn-back">← Kembali ke Daftar Queue</a>

    <div class="panel">
        <div class="panel-header">
            <div>
                <div class="section-badge">QUEUE / MIKROTIK</div>
                <div class="panel-title">Tambah Queue Baru</div>
            </div>
        </div>
        <div class="form-wrap">
            <form action="../../backend/queue/tambah.php" method="POST">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">IP Address</label>
                        <input type="text" name="ip_address" class="form-control"
                               placeholder="cth: 192.168.10.5" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jenis IP</label>
                        <select name="jenis_ip" class="form-select" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="PPPoE">PPPoE</option>
                            <option value="DHCP">DHCP</option>
                            <option value="Static">Static</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Username Mikrotik</label>
                        <input type="text" name="username_mikrotik" class="form-control"
                               placeholder="cth: budi_pppoe" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pelanggan <span style="color:var(--red)">*</span></label>
                        <select name="id_pelanggan" class="form-select" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            <?php while ($p = mysqli_fetch_assoc($pelanggan_list)): ?>
                            <option value="<?= $p['id_pelanggan'] ?>"><?= htmlspecialchars($p['nama']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status <span style="color:var(--red)">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="Aktif">Aktif</option>
                            <option value="Suspend">Suspend</option>
                            <option value="Isolir">Isolir</option>
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
