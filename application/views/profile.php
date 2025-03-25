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
    <title>Profile</title>
    <!-- Judul halaman yang muncul di tab browser -->
    
    <!-- Load CSS Bootstrap dari CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Load Font Awesome untuk ikon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <!-- Bagian BODY dengan class background light Bootstrap -->
    
    <!-- Container utama dengan padding -->
    <div class="container py-5">
        <!-- Judul halaman dengan nama user (dilindungi dari XSS) -->
        <h4>Profile <?= htmlspecialchars($user['nama']); ?></h4>
        
        <!-- Menampilkan pesan sukses/gagal dari session -->
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success">
                <!-- Alert success berwarna hijau -->
                <?= $this->session->flashdata('success'); ?>
            </div>
        <?php elseif ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger">
                <!-- Alert error berwarna merah -->
                <?= $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>
        
        <!-- Card utama untuk form profil -->
        <div class="card shadow">
            <div class="card-body">
                <!-- Form untuk update profil -->
                <form method="POST" action="<?= base_url('profile/update'); ?>">
                    <!-- Field untuk username -->
                    <div class="mb-3">
                        <label for="nama" class="form-label">Username</label>
                        <!-- Input text untuk username -->
                        <input type="text" class="form-control" id="username" name="username" 
                               value="<?= htmlspecialchars($user['nama']); ?>" required>
                        <!-- 
                            value: Menampilkan nilai username saat ini
                            required: Wajib diisi
                            htmlspecialchars: Proteksi XSS
                        -->
                    </div>
                    
                    <!-- Field untuk password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <!-- Input password -->
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="Leave blank if you don't want to change">
                        <!-- 
                            type="password": Input tersembunyi
                            placeholder: Petunjuk untuk user
                            Tidak required: Bisa dikosongkan jika tidak ingin diubah
                        -->
                    </div>
                    
                    <!-- Tombol submit -->
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                    <!-- 
                        type="submit": Untuk mengirim form
                        class="btn btn-primary": Tombol biru Bootstrap
                    -->
                </form>
            </div>
        </div>
        
        <!-- Tombol kembali ke dashboard -->
        <div class="mt-4">
            <a href="<?= base_url('dashboard'); ?>" class="btn btn-secondary">kembali</a>
            <!-- 
                href: Link ke halaman dashboard
                class="btn btn-secondary": Tombol abu-abu Bootstrap
            -->
        </div>
    </div>
    
    <!-- Load JavaScript Bootstrap dari CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>