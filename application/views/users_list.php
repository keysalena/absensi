<!DOCTYPE html>
<!-- HTML5 document declaration -->
<html lang="en">
<!-- Language set to English -->

<head>
    <!-- Document metadata -->
    <meta charset="UTF-8">
    <!-- Character encoding -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Responsive viewport settings -->
    <title>Daftar Pengguna</title>
    <!-- Page title -->
    
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Font Awesome icons -->
</head>

<body>
    <!-- Main container with margin -->
    <div class="container my-5">
        <!-- Header row with user list title and action buttons -->
        <div class="row g-3 align-items-center">
            <div class="col-auto">
                <h2>Daftar Pengguna</h2>
                <!-- Page heading -->
            </div>
            
            <!-- Print report button -->
            <div class="col-auto ms-auto mr-3">
                <a href="<?= base_url('print'); ?>" class="btn btn-primary" title="Cetak Laporan">
                    <i class="fa-thin fa-print"></i>
                    <!-- Print icon -->
                </a>
            </div>
            
            <!-- Logout button -->
            <div class="col-auto ms-auto">
                <a href="<?= base_url('logout'); ?>" class="btn btn-danger" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <!-- Logout icon -->
                </a>
            </div>
        </div>
        
        <!-- Users table -->
        <table class="table table-responsive">
            <!-- Responsive table -->
            <thead>
                <!-- Table header -->
                <tr>
                    <th>ID</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- PHP loop to display users -->
                <?php
                $no = 1; // Counter initialization
                foreach ($users as $user):
                ?>
                    <tr>
                        <td><?= $no++ ?></td> <!-- Incrementing ID -->
                        <td><?= $user['nama']; ?></td> <!-- Full name -->
                        <td><?= $user['username']; ?></td> <!-- Username -->
                        <td><?= $user['role']; ?></td> <!-- User role -->
                        <td>
                            <!-- Attendance view button with modal trigger -->
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

    <!-- Attendance Modal -->
    <div class="modal fade" id="absensiModal" tabindex="-1" aria-labelledby="absensiModalLabel" aria-hidden="true">
        <!-- Modal dialog (large size) -->
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Modal header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="absensiModalLabel">Absensi Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                    <h5 id="user-name"></h5> <!-- Will display selected user's name -->
                    
                    <!-- Month selection dropdown -->
                    <div class="mb-3">
                        <label for="month-select" class="form-label">Pilih Bulan:</label>
                        <select id="month-select" class="form-select">
                            <option value="01">Januari</option>
                            <!-- Month options -->
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
                    
                    <!-- Attendance table -->
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
                            <!-- Attendance data will be loaded here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <!-- Popper.js for Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Axios for HTTP requests -->

    <!-- Custom JavaScript -->
    <script>
        // Main function that runs when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            // Get modal and month select elements
            const absensiModal = document.getElementById('absensiModal');
            const monthSelect = document.getElementById('month-select');
            let currentUserId = null; // Variable to store current user ID

            // Set default month to current month
            const currentMonth = (new Date()).getMonth() + 1;
            monthSelect.value = String(currentMonth).padStart(2, '0');

            // Event listener for when modal is shown
            absensiModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // Button that triggered modal
                currentUserId = button.getAttribute('data-user-id'); // Get user ID
                const userName = button.getAttribute('data-user-name'); // Get user name

                // Update modal title with user's name
                document.getElementById('absensiModalLabel').textContent = `Absensi: ${userName}`;
                loadAbsensiData(); // Load attendance data
            });

            // Event listener for month selection change
            monthSelect.addEventListener('change', loadAbsensiData);

            // Function to load attendance data
            function loadAbsensiData() {
                if (!currentUserId) return; // Exit if no user selected

                const selectedMonth = monthSelect.value;
                const currentYear = new Date().getFullYear();
                const tbody = document.getElementById('absensi-data');

                // Show loading message
                tbody.innerHTML = '<tr><td colspan="4" class="text-center">Loading...</td></tr>';

                // Fetch attendance data from server
                fetch('<?= base_url("admin/get_absensi"); ?>?user_id=' + currentUserId + 
                      '&month=' + selectedMonth + '&year=' + currentYear)
                    .then(response => response.json())
                    .then(data => {
                        tbody.innerHTML = ''; // Clear loading message

                        // Show message if no data
                        if (!data || data.length === 0) {
                            tbody.innerHTML = '<tr><td colspan="4" class="text-center">Tidak ada data absensi</td></tr>';
                            return;
                        }

                        // Process and display each attendance record
                        data.forEach(absensi => {
                            const date = new Date(absensi.tanggal);
                            // Format date in Indonesian locale
                            const formattedDate = date.toLocaleDateString('id-ID', {
                                weekday: 'long',
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            });

                            // Create table row with attendance data
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
                        // Show error message
                        tbody.innerHTML = '<tr><td colspan="4" class="text-center text-danger">Error loading data</td></tr>';
                    });
            }
        });
    </script>
</body>
</html>