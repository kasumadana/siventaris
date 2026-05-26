# PRODUCT REQUIREMENT DOCUMENT (PRD)

## 1. Identitas Dokumen & Proyek

* **Nama Proyek:** SIVENTARIS (Sistem Inventaris Sarana Prasarana Sekolah)
* **Target Institusi:** SMK Negeri 1 Denpasar
* **Pengembang:** Tim XI RPL 1 (I Gede Kasuma Dana, I Nyoman Anrasansya Dharma Putra, M Denis Aditya, Ni Made Pertiwi Utami Dewi)
* **Teknologi Inti (TALL Stack):** Laravel 11, Filament v3, Livewire 3, Tailwind CSS, MySQL

---

## 2. Pendahuluan & Latar Belakang

Pengelolaan alat praktik dan sarana prasarana lintas jurusan di sekolah kejuruan sering mengalami kendala karena sistem pencatatan manual. Masalah utama meliputi hilangnya rekaman data peminjaman, ketidakakuratan kalkulasi stok barang secara manual, serta lamanya waktu pelayanan administratif toolman/staf sarpras.

**SIVENTARIS** hadir untuk mendigitalisasi sirkulasi peminjaman aset (berbasis pelacakan unit spesifik) dan menyediakan layanan mandiri pencetakan dokumen (*e-print*) bagi siswa dalam satu platform terintegrasi.

---

## 3. Manajemen Hak Akses Pengguna (User Roles)

Sistem memisahkan ruang kerja aplikasi secara ketat ke dalam 3 level otorisasi:

1. **Siswa (Student):** Mengakses halaman publik (frontend Livewire) untuk melihat katalog barang berdasarkan jurusan, melakukan booking peminjaman, mengunggah dokumen cetak, dan melihat riwayat transaksi melalui dashboard pribadi.
2. **Toolman (Petugas Gudang Jurusan):** Mengakses Panel Admin (Filament) untuk memverifikasi fisik peminjaman menggunakan pencarian cepat/scan, memperbarui kondisi barang, serta memproses antrean cetak dokumen siswa.
3. **Admin Sarpras (Super Admin):** Memiliki kontrol penuh atas manajemen data pengguna, kategori barang, otorisasi akun, dan melakukan unggah data inventaris massal via CSV/Excel.

---

## 4. Spesifikasi Kebutuhan Fungsional (Functional Requirements)

### 4.1. Modul Autentikasi Portal Terpadu

* **FR-01:** Sistem menyediakan halaman login umum (Siswa) di tingkat root (`/login`) dengan desain interaktif berbasis Livewire.
* **FR-02:** Sistem menyediakan halaman login admin (`/admin/login`) memanfaatkan infrastruktur bawaan Filament v3 dengan penyesuaian branding logo sekolah guna menjamin kestabilan *style* layout.
* **FR-03:** Sistem melakukan pembatasan akses (*role-gating*). Jika pengguna dengan level akses `student` mencoba mengakses URL `/admin`, sistem wajib melakukan pemblokiran (Error 403 / Redirect kembali ke halaman utama siswa).

### 4.2. Modul Frontend Siswa (Livewire & Tailwind)

* **FR-04 (Katalog Responsif):** Menampilkan seluruh daftar aset sekolah dengan filter pencarian instan berdasarkan Kategori (Kabel, Elektronik, Multimedia, dll) serta klasifikasi kepemilikan Jurusan/Department (RPL, TKJ, DKV, dsb).
* **FR-05 (Proses Booking):** Siswa dapat melakukan reservasi alat secara mandiri dengan memilih jangka waktu tanggal pinjam-kembali. Secara sistemis, waktu pengambilan awal akan otomatis terisi dengan durasi +1 jam dari waktu saat siswa membuka form reservasi, dan disinkronisasikan menggunakan zona waktu lokal `Asia/Makassar` (WITA) untuk mencegah selisih waktu server. Tombol reservasi otomatis terkunci (*disabled*) apabila akumulasi stok barang bernilai 0.
* **FR-06 (Layanan E-Print):** Menyediakan formulir unggah berkas tugas (format wajib PDF, batasan ukuran tertentu) dilengkapi kalkulasi jumlah halaman otomatis untuk efisiensi antrean cetak di ruang toolman.
* **FR-07 (Dashboard Siswa):** Menampilkan status peminjaman terkini (*Pending, Active, Returned*) dan menampilkan kode identitas digital siswa untuk verifikasi fisik.

### 4.3. Modul Backend Admin & Toolman (Filament v3)

* **FR-08 (Manajemen Inventaris Multi-Level):** Pemisahan entitas data antara `Item` (Informasi umum/merek alat) dan `ItemUnit` (Fisik barang nyata dengan kondisi spesifik seperti *Good, Damaged, Lost*).
* **FR-09 (Otomatisasi Stok):** Penerapan *Database Observer* pada model `ItemUnit` untuk melakukan pembaruan otomatis (*auto-increment/decrement*) pada nilai `total_stock` di tabel induk `items` ketika unit fisik baru ditambah atau dihapus.
* **FR-10 (Optimasi Sirkulasi Peminjaman - Satset Flow):** Proses verifikasi penyerahan barang (*handover*) dari status *Pending* menjadi *Active* dan pengembalian (*Return*) dilakukan langsung dari baris tabel menggunakan *Instant Table Actions* tanpa berpindah halaman:
    - **Aksi Serah Barang:** Membuka pop-up modal instan yang otomatis menampilkan identitas siswa, lalu menyediakan dropdown cepat untuk memilih kode fisik `item_unit_id` (aset nyata).
    - **Aksi Kembali Barang:** Mengubah status peminjaman secara instan menjadi *Returned* dan mengembalikan status unit barang menjadi *Available* dalam satu kali klik.
* **FR-12 (Widget Interaktif Dashboard):** Halaman utama panel admin wajib menyediakan widget statistik informatif yang memantau jumlah antrean data secara *real-time*, meliputi: jumlah Peminjaman Pending, Peminjaman Aktif, dan Antrean Berkas E-Print.
* **FR-13 (Otomatisasi & Shortcut E-Print):** Tabel pengelolaan cetak dokumen wajib menyediakan tombol pintas (*Shortcut Download*) untuk mengunduh berkas PDF siswa dalam sekali klik langsung dari tabel melalui tab baru. Sistem juga wajib melakukan pembacaan metadata file secara otomatis (*Auto-Page Detect*) untuk mengisi jumlah halaman dokumen dan mengalkulasi total biaya cetak secara instan.

---

## 5. Spesifikasi Kebutuhan Non-Fungsional (Non-Functional Requirements)

* **NFR-01 (UI/UX - Mobile First):** Seluruh form input di panel admin wajib menerapkan struktur *responsive stack* (menumpuk secara vertikal) otomatis ketika diakses menggunakan gawai/HP toolman untuk kemudahan mobilitas di area gudang.
* **NFR-02 (Desktop Layout Hierarchy):** Formulir administrasi pada resolusi desktop wajib diatur dalam layout hierarki profesional (2 kolom konten utama di sisi kiri untuk input tekstual, dan 1 kolom di sisi kanan sebagai sidebar penunjang unggahan gambar/status berkas).
* **NFR-03 (Performance):** Transisi pembaruan status data transaksi (*real-time components*) wajib ditangani tanpa memicu pemuatan ulang halaman secara penuh (*partial page refresh* memanfaatkan siklus hidup Livewire).
* **NFR-04 (Sistem Sinkronisasi Waktu):** Seluruh pencatatan stempel waktu transaksi (*timestamps*), log sirkulasi barang, dan penjadwalan pengambilan dokumen wajib merujuk secara konsisten pada zona waktu lokal WITA (GMT+8 / Asia/Makassar) dengan tingkat presisi tinggi demi menghindari redudansi data durasi peminjaman.