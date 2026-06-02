<?php
include __DIR__ . '/../../backend/config/connect.php';

$id   = (int)($_GET['id'] ?? 0);
$res  = mysqli_query($conn, "SELECT * FROM pelanggan WHERE id_pelanggan = $id");
$data = mysqli_fetch_assoc($res);
if (!$data) { header('Location: index.php'); exit; }

$paket_list  = mysqli_query($conn, "SELECT id_paket, jenis_paket, kecepatan_bandwidth FROM paket ORDER BY harga ASC");
$modem_list  = mysqli_query($conn, "SELECT id_modem, merk FROM modem ORDER BY merk ASC");
$router_list = mysqli_query($conn, "SELECT id_router, merk FROM router ORDER BY merk ASC");

include __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../layouts/sidebar.php';
include __DIR__ . '/../layouts/navbar.php';
?>
<div class="main-content">
<div class="page-body">

    <a href="index.php" class="btn-back">← Kembali ke Daftar Pelanggan</a>

    <div class="panel">
        <div class="panel-header">
            <div>
                <div class="section-badge">PELANGGAN</div>
                <div class="panel-title">Edit Pelanggan</div>
            </div>
        </div>
        <div class="form-wrap">
            <form action="../../backend/pelanggan/edit.php" method="POST">
                <input type="hidden" name="id_pelanggan" value="<?= $data['id_pelanggan'] ?>">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Pelanggan</label>
                        <input type="text" name="nama" class="form-control"
                               value="<?= htmlspecialchars($data['nama']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control"
                               value="<?= htmlspecialchars($data['alamat']) ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Paket Internet <span style="color:var(--red)">*</span></label>
                        <select name="id_paket" class="form-select" required>
                            <option value="">-- Pilih Paket --</option>
                            <?php while ($pk = mysqli_fetch_assoc($paket_list)): ?>
                            <option value="<?= $pk['id_paket'] ?>"
                                <?= $data['id_paket'] == $pk['id_paket'] ? 'selected' : '' ?>>
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
                            <option value="<?= $m['id_modem'] ?>"
                                <?= $data['id_modem'] == $m['id_modem'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($m['merk']) ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Router <small style="color:var(--gray-400)">(opsional)</small></label>
                        <select name="id_router" class="form-select">
                            <option value="">-- Tidak Ada --</option>
                            <?php while ($r = mysqli_fetch_assoc($router_list)): ?>
                            <option value="<?= $r['id_router'] ?>"
                                <?= $data['id_router'] == $r['id_router'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($r['merk']) ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status <span style="color:var(--red)">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="Aktif" <?= ($data['status'] ?? 'Aktif') === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="Nonaktif" <?= ($data['status'] ?? 'Aktif') === 'Nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
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
