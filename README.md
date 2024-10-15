<p align="center">
  <h2 align="center">
    MONITORING DATA SDG (Sustainable Development Goals)
  </h2>
</p>

<!-- Daftar Isi -->
<details open="open">
  <summary><h2 style="display: inline-block">Daftar Isi</h2></summary>
  <ol>
    <li><a href="#anggota-tim">Anggota Tim</a></li>
    <li><a href="#latar-belakang">Latar Belakang</a></li>
    <li><a href="#tujuan-dan-manfaat">Tujuan dan Manfaat</a></li>
    <li><a href="#penjelasan-aplikasi">Penjelasan Aplikasi</a></li>
    <li><a href="#petunjuk-instalasi-project-ci-monitoring-sdg">Petunjuk Instalasi</a></li> 
  </ol>
</details>

## Anggota Tim
| NIM           | Name                     |
| ------------- |--------------------------|
| 2210512043    | Ahmad Maulana Yassin     |
| 2210512083    | Zaki Mahmuda             |

<!-- Latar Belakang -->
## Latar Belakang
Project Monitoring SDG (Sustainable Development Goals) adalah aplikasi berbasis web yang bertujuan untuk memantau dan menganalisis indikator-indikator SDG di suatu wilayah. Aplikasi ini dibangun menggunakan framework CodeIgniter 4 dan menyediakan antarmuka untuk menampilkan data, melakukan pengelolaan, serta menampilkan visualisasi indikator SDG.

<!-- Tujuan dan Manfaat -->
## Tujuan dan Manfaat


<!-- Penjelasan Aplikasi -->
## Penjelasan Aplikasi

Aplikasi **Monitoring SDG** memiliki beberapa fitur utama, antara lain:
1. **Dashboard Data SDG**: Menampilkan visualisasi indikator SDG dalam bentuk grafik dan tabel.
2. **Manajemen Indikator SDG**: Memungkinkan penambahan, pengeditan, dan penghapusan indikator SDG.
3. **Manajemen Pengguna**: Admin dapat mengelola pengguna yang memiliki akses ke sistem.
4. **Filter Berdasarkan Wilayah**: Pengguna dapat memfilter data berdasarkan wilayah atau provinsi.

<!-- Petunjuk Instalasi Project CI Monitoring SDG -->
## Petunjuk Instalasi Project CI Monitoring SDG
### Prasyarat
Sebelum memulai instalasi, pastikan Anda sudah menginstal:
- **PHP** versi 7.3 atau lebih baru.
- **Composer** (untuk mengelola dependensi PHP).
- **MySQL/MariaDB** untuk database.
- **Git** untuk meng-clone project dari GitHub.
- **Server lokal** seperti **XAMPP** atau **Laragon** jika bekerja di lingkungan lokal.

### Langkah-Langkah Instalasi

#### 1. Clone Repository dari GitHub
Buka terminal atau command prompt dan jalankan perintah berikut untuk clone repository ke folder lokal Anda:

```bash
git clone https://github.com/maulanayassin/PTSI-project.git
cd PTSI-project
```

#### 2. Install Dependensi Menggunakan Composer
Setelah masuk ke dalam folder project, jalankan perintah berikut untuk menginstal semua dependensi yang diperlukan:
```bash
composer install
```
3. Konfigurasi Database
Buat database baru di MySQL/MariaDB dengan nama yang sesuai, misalnya sdg_ptsi.
Salin file .env.example yang ada di folder project dan ubah namanya menjadi .env.
Buka file .env dan sesuaikan pengaturan database dengan informasi database yang telah Anda buat. Contoh konfigurasi yang dapat digunakan:
plaintext
Copy code
database.default.hostname = localhost
database.default.database = sdg_ptsi
database.default.username = your_username
database.default.password = your_password
database.default.DBDriver = MySQLi
4. Migrasi Database
Jalankan perintah berikut untuk melakukan migrasi dan membuat tabel-tabel yang diperlukan di dalam database:

```bash
php spark migrate
```
Jika Anda ingin mengisi database dengan data awal, Anda dapat menggunakan seeder:

```bash
php spark db:seed SeederName
```
Gantilah SeederName dengan nama seeder yang sesuai jika Anda memiliki seeder.

5. Menjalankan Server
Setelah semua langkah di atas selesai, Anda bisa menjalankan aplikasi dengan perintah berikut:

```bash
php spark serve
```
Aplikasi akan berjalan di alamat http://localhost:8080. Anda dapat membuka URL ini di browser untuk mengakses aplikasi Monitoring SDG.

6. Login ke Aplikasi
Gunakan kredensial yang sudah Anda buat atau gunakan akun admin default jika tersedia untuk masuk ke dalam aplikasi. Setelah login, Anda akan diarahkan ke dashboard aplikasi di mana Anda dapat mulai menggunakan fitur-fitur yang ada.

7. Memastikan Fitur Berjalan
Setelah aplikasi berjalan, pastikan semua fitur, seperti dashboard, manajemen indikator, dan filter berdasarkan wilayah berfungsi dengan baik. Jika ada masalah, periksa kembali langkah-langkah instalasi dan konfigurasi yang telah dilakukan.