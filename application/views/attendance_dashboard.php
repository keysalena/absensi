<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags for character set and responsive viewport -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Page title -->
    <title>Dashboard Absensi</title>
    
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    
    <!-- PDF Generation Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
</head>

<body class="bg-light">
    <!-- Set timezone to Indonesia -->
    <?php date_default_timezone_set('Asia/Jakarta'); ?>
    
    <!-- Main Container -->
    <div class="container py-5">
        <!-- Welcome Message with XSS protection -->
        <h4 class="mb-4">Selamat datang, <?= htmlspecialchars($user['nama'] ?? 'Pengguna'); ?>!</h4>
        
        <!-- Flash Message Display -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= htmlspecialchars($this->session->flashdata('success')); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= htmlspecialchars($this->session->flashdata('error')); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <!-- Attendance Card -->
        <div class="card shadow">
            <div class="card-body">
                <!-- Month Filter Form -->
                <form method="GET" action="<?= base_url('attendance'); ?>">
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                            <label for="filterBulan" class="form-label">Filter Bulan:</label>
                        </div>
                        <div class="col-auto">
                            <select class="form-select" id="filterBulan" name="bulan" onchange="this.form.submit()">
                                <?php foreach ($bulan as $key => $nama_bulan): ?>
                                    <option value="<?= (int)$key; ?>" <?= $key == $bulan_pilih ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($nama_bulan . ' ' . date('Y')); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="col-auto ms-auto">
                            <!-- Profile Button -->
                            <a href="<?= base_url('profile'); ?>" class="btn btn-success" title="Profile">
                                <i class="fas fa-user"></i>
                            </a>
                            
                            <!-- Print PDF Button -->
                            <button class="btn btn-primary" onclick="printPDF()" type="button" title="Cetak PDF">
                                <i class="fas fa-print"></i>
                            </button>
                            
                            <!-- Logout Button -->
                            <a href="<?= base_url('logout'); ?>" class="btn btn-danger" title="Logout">
                                <i class="fas fa-sign-out-alt"></i>
                            </a>
                        </div>
                    </div>
                </form>
                
                <!-- Attendance Action Buttons -->
                <div class="mt-3 d-flex gap-2">
                    <!-- Clock In Button -->
                    <button class="btn btn-success" id="btnMasuk"
                        onclick="window.location.href='<?= base_url('attendance/process_absen/masuk?time=' . urlencode(date('H:i:s'))); ?>'"
                        <?= ($today_attendance && isset($today_attendance['waktu_masuk'])) ? 'disabled' : ''; ?>>
                        <i class="fas fa-sign-in-alt me-1"></i> Masuk
                    </button>
                    
                    <!-- Clock Out Button with Modal Trigger -->
                    <button class="btn btn-danger" id="btnPulang"
                        data-bs-toggle="modal"
                        data-bs-target="#kegiatanModal"
                        <?= !$today_attendance || !isset($today_attendance['waktu_masuk']) || isset($today_attendance['waktu_pulang']) ? 'disabled' : ''; ?>>
                        <i class="fas fa-sign-out-alt me-1"></i> Pulang
                    </button>
                </div>
                
                <!-- Attendance Report Section -->
                <div id="laporan" class="mt-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th>Kegiatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($attendance_records)): ?>
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data absensi</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($attendance_records as $absensi): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($absensi['tanggal'] ?? '-'); ?></td>
                                            <td><?= htmlspecialchars($absensi['waktu_masuk'] ?? '-'); ?></td>
                                            <td><?= htmlspecialchars($absensi['waktu_pulang'] ?? '-'); ?></td>
                                            <td><?= htmlspecialchars($absensi['log_kegiatan'] ?? '-'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Scripts -->
    <script>
        /**
         * Generate PDF from attendance report
         */
        function printPDF() {
            const element = document.getElementById('laporan');
            const options = {
                margin: 10,
                filename: 'Laporan_Absensi_<?= date('Y-m-d'); ?>.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            
            html2pdf().set(options).from(element).save();
        }
        
        // Disable form resubmission on page refresh
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
</html>