<!DOCTYPE html>
<!-- Deklarasi tipe dokumen HTML5 -->
<html lang="en">
<!-- Tag pembuka HTML dengan atribut bahasa Inggris -->

<head>
    <!-- Bagian HEAD untuk metadata dan resource -->
    <meta charset="UTF-8"> 
    <!-- Penentuan encoding karakter UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Pengaturan viewport untuk responsif di perangkat mobile -->
    <title>Login</title>
    <!-- Judul halaman yang muncul di tab browser -->
    
    <!-- Load CSS Bootstrap dari CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <!-- Bagian BODY dengan class background light Bootstrap -->
    
    <!-- Container utama dengan flexbox untuk posisi tengah vertikal dan horizontal -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <!-- Card untuk form login -->
        <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
            <!-- Judul form -->
            <h3 class="text-center mb-4">Login</h3>
            
            <!-- Menampilkan pesan error jika ada -->
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <!-- Menampilkan pesan error dari session flashdata -->
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>
            
            <!-- Form login dengan method POST -->
            <form action="<?= site_url('login/process'); ?>" method="POST">
                <!-- Input field untuk username -->
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                    <!-- 
                        type="text" - Input teks biasa
                        class="form-control" - Styling Bootstrap
                        id="username" - Identifier untuk label
                        name="username" - Nama variabel saat dikirim ke server
                        required - Wajib diisi
                    -->
                </div>
                
                <!-- Input field untuk password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <!-- 
                        type="password" - Input password (tersamar)
                        atribut lainnya sama dengan field username
                    -->
                </div>
                
                <!-- Tombol submit -->
                <button type="submit" class="btn btn-primary w-100">Login</button>
                <!-- 
                    type="submit" - Untuk submit form
                    class="btn btn-primary" - Tombol biru Bootstrap
                    w-100 - Lebar 100%
                -->
                
                <!-- Link ke halaman registrasi -->
                <div class="mt-3 text-center">
                    <p>Belum punya akun? <a href="register">Daftar</a></p>
                    <!-- Link ke halaman registrasi -->
                </div>
            </form>
        </div>
    </div>
</body>

</html>