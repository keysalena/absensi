<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <h2>Daftar Pengguna</h2>
            </div>
 
            <div class="col-auto ms-auto mr-3 ">
                <a href="<?= base_url('print'); ?>" class="btn btn-primary" title="Cetak Laporan">  
                <i class="fa-thin fa-print"></i>
                </a>
            </div>
            <div class="col-auto ms-auto">
                <a href="<?= base_url('logout'); ?>" class="btn btn-danger" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1; 
                foreach ($users as $user):
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $user['nama']; ?></td>
                        <td><?= $user['username']; ?></td>
                        <td><?= $user['role']; ?></td>
                        <td>
                            <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                data-bs-target="#absensiModal" data-user-id="<?= $user['id']; ?>"
                                data-user-name="<?= $user['nama']; ?>">
                                Lihat Absensi
                            </button>
                        </td>
                    </tr>
                <?php
                endforeach;
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal untuk Menampilkan Absensi -->
    <div class="modal fade" id="absensiModal" tabindex="-1" aria-labelledby="absensiModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="absensiModalLabel">Absensi Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 id="user-name"></h5>
                    <div class="mb-3">
                        <label for="month-select" class="form-label">Pilih Bulan:</label>
                        <select id="month-select" class="form-select">
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Waktu Masuk</th>
                                <th>Waktu Keluar</th>
                                <th>Kegiatan</th>
                            </tr>
                        </thead>
                        <tbody id="absensi-data">
                            <!-- Data will be loaded here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const absensiModal = document.getElementById('absensiModal');
            const monthSelect = document.getElementById('month-select');
            let currentUserId = null;

            const currentMonth = (new Date()).getMonth() + 1;
            monthSelect.value = String(currentMonth).padStart(2, '0');

            absensiModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                currentUserId = button.getAttribute('data-user-id');
                const userName = button.getAttribute('data-user-name');

                document.getElementById('absensiModalLabel').textContent = `Absensi: ${userName}`;
                loadAbsensiData();
            });

            monthSelect.addEventListener('change', loadAbsensiData);

            function loadAbsensiData() {
                if (!currentUserId) return;

                const selectedMonth = monthSelect.value;
                const currentYear = new Date().getFullYear();
                const tbody = document.getElementById('absensi-data');

                tbody.innerHTML = '<tr><td colspan="3" class="text-center">Loading...</td></tr>';

                fetch('<?= base_url("admin/get_absensi"); ?>?user_id=' + currentUserId + '&month=' + selectedMonth + '&year=' + currentYear)
                    .then(response => response.json())
                    .then(data => {
                        tbody.innerHTML = '';

                        if (!data || data.length === 0) {
                            tbody.innerHTML = '<tr><td colspan="3" class="text-center">Tidak ada data absensi</td></tr>';
                            return;
                        }

                        data.forEach(absensi => {
                            const date = new Date(absensi.tanggal);
                            const formattedDate = date.toLocaleDateString('id-ID', {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });

                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${formattedDate}</td>
                                <td>${absensi.waktu_masuk || '-'}</td>
                                <td>${absensi.waktu_pulang || '-'}</td>
                                <td>${absensi.log_kegiatan || '-'}</td>
                            `;
                            tbody.appendChild(row);
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        tbody.innerHTML = '<tr><td colspan="3" class="text-center text-danger">Error loading data</td></tr>';
                    });
            }
        });
    </script>
</body>

</html>