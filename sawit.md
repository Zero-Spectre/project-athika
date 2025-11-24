💻 SOFTWARE DEVELOPMENT LIFE CYCLE (SDLC)

🌴 Proyek

Rancang Bangun Platform Edukasi Sawit Apkasindo DPW Riau

I. Tahap Perencanaan (Planning)

A. Tujuan Proyek

Merancang dan membangun sebuah platform edukasi daring untuk Apkasindo DPW Riau sebagai media pembelajaran tentang kelapa sawit bagi masyarakat umum, petani, dan mahasiswa.

B. Deskripsi Singkat Sistem

Platform ini menyediakan kursus, materi pembelajaran (video, artikel), dan kuis interaktif. Sistem akan memiliki tiga jenis pengguna utama:

Admin

Instruktur (Pengajar)

Peserta (User)

C. Tujuan Pengembangan Sistem

Menyediakan sarana belajar online untuk topik kelapa sawit.

Memfasilitasi Apkasindo DPW Riau dalam menyebarkan edukasi digital.

Menyediakan dashboard terpisah untuk Admin, Pengajar, dan Peserta.

D. Stakeholder dan Peran

Stakeholder

Peran Utama

Admin (Apkasindo)

Mengelola materi & pengguna sistem.

Instruktur (Pengajar)

Menambahkan dan mengupdate materi kursus.

User (Peserta)

Belajar melalui modul dan kursus yang tersedia.

E. Lingkup & Batasan Sistem

Aspek

Detail

Lingkup Sistem

Registrasi dan login user, dashboard, manajemen kursus (CRUD), tampilan course & materi, fitur kuis, sistem komentar/diskusi, pencarian & kategori kursus.

Batasan Sistem

Tidak mencakup sertifikasi atau sistem pembayaran. Materi diunggah secara manual oleh admin/instruktur.

II. Tahap Analisis (Analysis)

Tujuan Analisis

Menganalisis kebutuhan fungsional dan non-fungsional yang diperlukan oleh sistem.

A. Kebutuhan Fungsional (Functional Requirements)

1. Dashboard Admin

Login dan logout.

Melihat statistik (jumlah pengguna, kursus, aktivitas).

Mengelola data pengguna (CRUD user).

Menyetujui atau menolak kursus yang diajukan instruktur.

Menghapus komentar/konten yang melanggar aturan.

Menambahkan kategori kursus baru.

2. Dashboard Instruktur (Pengajar)

Login dan logout.

Melihat daftar kursus milik sendiri.

Menambah, mengedit, dan menghapus kursus milik sendiri.

Upload materi (video, artikel).

Membuat dan mengelola kuis.

Melihat hasil kuis dan progres peserta di kursusnya.

Menanggapi komentar peserta.

Melihat statistik kursus.

3. Dashboard Peserta (User)

Registrasi dan login.

Melihat daftar kursus (kategori, pencarian).

Melanjutkan pembelajaran.

Mengikuti kuis dan melihat hasil skor.

Menyimpan progres belajar (progress tracking).

Memberi komentar atau pertanyaan pada materi kursus.

Melihat rekomendasi kursus lain.

4. Fitur Umum

Manajemen Kursus: Kursus memiliki judul, deskripsi, kategori, thumbnail, dan daftar modul. Kursus bisa di-publish setelah disetujui admin.

Kuis: Pilihan ganda; sistem otomatis menghitung skor.

Komentar & Diskusi: Komentar dua arah antara peserta dan instruktur.

Pencarian & Filter: Pencarian dinamis (live search) berdasarkan nama, kategori, atau instruktur.

B. Kebutuhan Non-Fungsional (Non-Functional Requirements)

Aspek

Deskripsi

Kinerja (Performance)

Sistem dapat diakses dengan cepat dan stabil (waktu muat yang rendah).

Keamanan (Security)

Data pengguna dan hasil belajar harus tersimpan aman.

Kemudahan Penggunaan (Usability)

Tampilan sistem harus sederhana, mudah dipahami, dan nyaman.

Reliabilitas (Reliability)

Sistem harus mampu berjalan tanpa error fatal dalam jangka waktu lama.

Portabilitas (Portability)

Sistem dapat dijalankan di berbagai perangkat dan browser umum.

Pemeliharaan (Maintainability)

Struktur sistem harus mudah diperbarui, diperbaiki, dan dikembangkan.

Skalabilitas (Scalability)

Sistem harus dapat menampung peningkatan jumlah pengguna dan data di kemudian hari.

C. Diagram Use Case (Deskripsi Singkat)

Aktor

Aktivitas Utama

Admin

Login, Kelola pengguna, Kelola kursus, Pantau aktivitas.

Instruktur

Login, Tambah/Edit kursus, Upload materi, Buat kuis, Lihat progres peserta.

Peserta

Registrasi, Login, Lihat kursus, Ikuti pembelajaran, Kerjakan kuis, Komentar.