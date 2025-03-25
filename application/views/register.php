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
  <title>Register</title>
  <!-- Judul halaman yang muncul di tab browser -->
  
  <!-- Load CSS Bootstrap dari CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <!-- Bagian BODY dengan class background light Bootstrap -->
  
  <!-- Container utama dengan flexbox untuk posisi tengah vertikal dan horizontal -->
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <!-- Card untuk form registrasi -->
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
      <!-- Judul form -->
      <h3 class="text-center mb-4">Register</h3>

      <!-- Menampilkan pesan sukses/gagal dari session -->
      <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success">
          <!-- Alert success berwarna hijau -->
          <?= $this->session->flashdata('success') ?>
        </div>
      <?php endif; ?>
      <?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
          <!-- Alert error berwarna merah -->
          <?= $this->session->flashdata('error') ?>
        </div>
      <?php endif; ?>

      <!-- Form registrasi dengan method POST -->
      <form action="<?= site_url('register/process') ?>" method="POST">
        <!-- Field untuk nama lengkap -->
        <div class="mb-3">
          <label for="nama" class="form-label">Nama Lengkap</label>
          <input type="text" class="form-control" id="nama" name="nama" required>
          <!-- 
            type="text" - Input teks biasa
            class="form-control" - Styling Bootstrap
            id="nama" - Identifier untuk label
            name="nama" - Nama variabel saat dikirim ke server
            required - Wajib diisi
          -->
        </div>
        
        <!-- Field untuk username -->
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username" required>
          <!-- 
            type="text" - Input teks biasa
            atribut lainnya sama dengan field nama
          -->
        </div>
        
        <!-- Dropdown untuk memilih role -->
        <div class="mb-3">
          <label for="role" class="form-label">Role</label>
          <select class="form-control" id="role" name="role" required>
            <option value="">Pilih Role</option>
            <option value="Magang">Magang</option>
            <option value="Pegawai">Pegawai</option>
          </select>
          <!-- 
            class="form-control" - Styling Bootstrap
            id="role" - Identifier untuk label
            name="role" - Nama variabel saat dikirim ke server
            required - Wajib dipilih
          -->
        </div>
        
        <!-- Field untuk password -->
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" required>
          <!-- 
            type="password" - Input tersembunyi
            atribut lainnya sama dengan field sebelumnya
          -->
        </div>
        
        <!-- Tombol submit -->
        <button type="submit" class="btn btn-success w-100">Register</button>
        <!-- 
          type="submit" - Untuk mengirim form
          class="btn btn-success" - Tombol hijau Bootstrap
          w-100 - Lebar 100%
        -->
        
        <!-- Link ke halaman login -->
        <div class="mt-3 text-center">
          <p>Sudah punya akun? <a href="<?= site_url('login') ?>">Login</a></p>
          <!-- Link ke halaman login -->
        </div>
      </form>
    </div>
  </div>
</body>

</html>