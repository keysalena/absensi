<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <?php
    date_default_timezone_set('Asia/Jakarta'); // Set zona waktu ke WIB
    ?>
    <div class="container py-5">
        <h4>Selamat datang, <?= htmlspecialchars($user['nama']); ?>!</h4>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
        <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <div class="card shadow">
            <div class="card-body">
                <form method="POST" action="<?= base_url('attendance'); ?>">
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                            <label for="filterBulan" class="form-label">Filter Bulan:</label>
                        </div>
                        <div class="col-auto">
                            <select class="form-select" id="filterBulan" name="bulan" onchange="this.form.submit()">
                                <?php foreach ($bulan as $key => $nama_bulan): ?>
                                    <option value="<?= $key; ?>" <?= $key == $bulan_pilih ? 'selected' : ''; ?>>
                                        <?= $nama_bulan . ' ' . date('Y'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-auto ms-auto">
                            <a href="<?= base_url('logout'); ?>" class="btn btn-danger" title="Logout">
                                <i class="fas fa-sign-out-alt"></i>
                            </a>
                        </div>
                    </div>
                </form>

                <div class="mt-3">
                    <button
                        class="btn btn-success"
                        onclick="window.location.href='<?= base_url('attendance/process_absen/masuk?time=' . urlencode(date('H:i:s'))); ?>'"
                        <?= ($today_attendance && isset($today_attendance['waktu_masuk'])) ? 'disabled' : ''; ?>>
                        Masuk
                    </button>
                    <button class="btn btn-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#kegiatanModal"
                        <?= !$today_attendance || !isset($today_attendance['waktu_masuk']) || isset($today_attendance['waktu_pulang']) ? 'disabled' : ''; ?>>
                        Pulang
                    </button>
                </div>
                <table class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th>Hari</th>
                            <th>Jam Masuk</th>
                            <th>Jam Pulang</th>
                            <th>Kegiatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($attendance_records as $absensi): ?>
                            <tr>
                                <?php
                                $date = new DateTime($absensi['tanggal']);
                                $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                                $formatter->setPattern('EEEE, d MMMM yyyy');
                                $formatted_date = $formatter->format($date);
                                ?>
                                <td><?= $formatted_date; ?></td>
                                <td><?= $absensi['waktu_masuk'] ?? '-'; ?></td>
                                <td><?= $absensi['waktu_pulang'] ?? '-'; ?></td>
                                <td><?= $absensi['log_kegiatan'] ?? '-'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
<div class="modal fade" id="kegiatanModal" tabindex="-1" aria-labelledby="kegiatanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="logKegiatanForm" method="POST" action="<?= base_url('attendance/process_absen/pulang?time=' . urlencode(date('H:i:s'))); ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="kegiatanModalLabel">Isi Kegiatan Hari Ini</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="logKegiatan" class="form-label">Log Kegiatan</label>
                        <textarea class="form-control" id="logKegiatan" name="log_kegiatan" rows="4" required></textarea>
                    </div>
                </div>
                <!-- <input type="hidden" name="time" value="<?= date('H:i:s'); ?>"> -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Simpan & Pulang</button>
                </div>
            </form>
        </div>
    </div>
</div>