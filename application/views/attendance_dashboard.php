<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
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

                        <a href="<?= base_url('profile'); ?>" class="btn btn-success" title="profile">             
                        <i class=" fas fa-solid fa-user"></i>
                            </a>
                            </a>
                            <button class="btn btn-primary" onclick="printPDF()" type="button">
                                <i class="fas fa-print"></i> 
                            </button>
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
                <div id="laporan">
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
                                    <td><?= $absensi['tanggal']; ?></td>
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
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function printPDF() {
            const element = document.getElementById('laporan');
            html2pdf().from(element).save('Laporan_Absensi.pdf');
        }
    </script>
</body>
</html>
