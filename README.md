# Website SDN Cilopang

Dokumentasi resmi website profil SDN Cilopang. Isi README ini disusun berdasarkan audit terhadap kode yang tersedia di repository ini.

## 1. Tentang Project

Website profil sekolah SDN Cilopang yang dibangun di atas WordPress menggunakan custom theme `sdn-cilopang` dan custom plugin `sdn-cilopang`. Theme menangani tampilan, template halaman, dan interaksi frontend; plugin menangani Custom Post Type (CPT), shortcode, dashboard admin, dan Pengaturan Website.

Project ini tidak menggunakan build tool atau framework JavaScript tambahan. Frontend menggunakan CSS dan JavaScript vanilla, dengan Swiper 10 dari CDN untuk carousel Guru & Tendik.

## 2. Tech Stack

- CMS: WordPress **7.0.4**, berdasarkan `wp-includes/version.php` pada repository ini. Versi yang berjalan di server produksi tetap perlu diverifikasi.
- Minimum PHP yang dipersyaratkan oleh WordPress pada file versi: **7.4**. Versi PHP aktual pada server perlu diverifikasi.
- Bahasa pemrograman: PHP, JavaScript vanilla, CSS, dan HTML.
- Database: MySQL/MariaDB melalui WordPress. `wp-config.php` menunjuk ke database `SDN-Cilopang`, host `localhost`, user `root`, charset `utf8mb4`, dan prefix tabel `wp_`.
- CSS: satu stylesheet utama pada `wp-content/themes/sdn-cilopang/style.css`.
- JavaScript: vanilla JS pada folder `wp-content/themes/sdn-cilopang/js/`.
- Library frontend eksternal: Swiper 10 dari jsDelivr CDN. Google Fonts (Plus Jakarta Sans dan Sora) juga dimuat dari CDN.
- Tidak ditemukan `composer.json` atau `package.json` pada root project maupun theme/plugin custom. File dependency WordPress core dan `package.json` theme bawaan `twentytwentyfive` tidak digunakan oleh project SDN Cilopang.

## 3. Struktur Folder

### Theme: `wp-content/themes/sdn-cilopang/`

```text
sdn-cilopang/
├── style.css                 # Design system dan seluruh CSS frontend theme
├── functions.php             # Registrasi theme, enqueue CSS/JS, menu, dan Swiper
├── header.php                # Header, logo, navigasi, dan mobile drawer
├── footer.php                # Footer, kontak, dan tautan sosial
├── front-page.php            # Halaman beranda
├── page-profil-sekolah.php   # Halaman profil sekolah
├── page-kontak.php           # Halaman kontak dan Google Maps
├── archive-guru.php          # Arsip Guru & Tendik
├── single-guru.php           # Detail Guru & Tendik
├── archive-fasilitas.php     # Arsip fasilitas
├── single-fasilitas.php      # Detail fasilitas
├── archive-ekstrakurikuler.php # Arsip ekstrakurikuler
├── single-ekstrakurikuler.php  # Detail ekstrakurikuler
├── index.php                 # Fallback template WordPress
├── single.php                # Template native post
├── category.php              # Template arsip kategori native post
├── 404.php                   # Halaman tidak ditemukan
├── page-agenda.php           # Defense-in-depth: langsung menampilkan 404
├── archive-agenda.php        # Defense-in-depth: langsung menampilkan 404
├── single-agenda.php         # Defense-in-depth: langsung menampilkan 404
├── js/                       # Semua JavaScript frontend theme
├── assets/images/            # Aset gambar theme
└── _archived_templates/      # Salinan template Agenda lama yang diarsipkan
```

### Plugin: `wp-content/plugins/sdn-cilopang/`

```text
sdn-cilopang/
├── sdn-cilopang.php          # Bootstrap plugin, CPT Guru, dashboard, menu, dan pembatasan fitur
├── includes/
│   ├── class-fasilitas.php   # CPT, field tampilan, dan shortcode Fasilitas
│   ├── class-ekstrakurikuler.php # CPT, field, penyimpanan, dan shortcode Ekstrakurikuler
│   ├── class-agenda.php      # Definisi Agenda yang hanya aktif melalui filter
│   └── class-pengaturan.php  # Settings API dan halaman Pengaturan Website
├── admin/                    # Saat audit: kosong
├── templates/                # Saat audit: kosong
└── public/
	├── css/style.css         # File legacy; tidak di-enqueue oleh plugin
	└── js/script.js          # File kosong; tidak di-enqueue oleh plugin
```

## 4. Fitur & Modul

### CPT aktif

#### Guru & Tendik (`guru`)

- Judul: nama guru atau tenaga kependidikan.
- Gambar unggulan: foto guru.
- Field custom: **NIP**, **NUPTK**, **Jabatan**, **Mata Pelajaran**, dan **Status Kepegawaian**.
- Pilihan status: PNS, PPPK, Honorer, Guru Tetap, dan Lainnya.
- Arsip: `/guru/`; detail: `/guru/{slug}/`.
- Shortcode daftar: `[sdn_daftar_guru]`.

#### Fasilitas Sekolah (`fasilitas`)

- Judul: nama fasilitas.
- Editor: deskripsi fasilitas.
- Gambar unggulan: foto fasilitas.
- Tidak ada field custom tambahan yang disimpan; informasi berasal dari judul, isi editor, dan gambar unggulan.
- Arsip: `/fasilitas/`; detail: `/fasilitas/{slug}/`.
- Shortcode daftar: `[sdn_daftar_fasilitas]`.

#### Ekstrakurikuler (`ekstrakurikuler`)

- Judul: nama kegiatan.
- Editor: deskripsi kegiatan.
- Gambar unggulan: foto kegiatan.
- Field custom: **Pembina**, **Jadwal**, dan **Tempat**.
- Arsip: `/ekstrakurikuler/`; detail: `/ekstrakurikuler/{slug}/`.
- Shortcode daftar: `[sdn_daftar_ekstrakurikuler]`.

### Modul yang dinonaktifkan

- **Agenda** (`agenda`): `class-agenda.php` hanya mendaftarkan CPT jika filter `sdn_cilopang_enable_agenda_cpt` bernilai benar; nilai default-nya `false`. Menu Agenda dihapus untuk semua user, akses langsung ke layar admin diblokir, dan template Agenda frontend menampilkan 404. Komentar kode menyebutkan penonaktifan ini sebagai bagian dari Fase 16B/cleanup.
- **Berita / native Posts publik**: native post tetap diberi label admin “Berita”, tetapi single post publik dan kategori bernama atau berslug `berita`/`pengumuman` dipaksa 404. Akses layar Posts juga diblokir untuk user yang bukan Administrator. Berita tidak ditampilkan pada dashboard shortcut untuk user non-Administrator.

## 5. Halaman & Routing

| URL | Template | Keterangan |
|---|---|---|
| `/` | `front-page.php` | Beranda, hero, statistik, profil ringkas, Guru, Fasilitas, dan Ekstrakurikuler |
| `/profil-sekolah/` | `page-profil-sekolah.php` | Profil, sejarah, identitas, visi, dan misi |
| `/kontak/` | `page-kontak.php` | Kontak sekolah, alamat, telepon, email, dan embed Google Maps |
| `/guru/` | `archive-guru.php` | Daftar Guru & Tendik |
| `/guru/{slug}/` | `single-guru.php` | Detail Guru & Tendik |
| `/fasilitas/` | `archive-fasilitas.php` | Daftar fasilitas |
| `/fasilitas/{slug}/` | `single-fasilitas.php` | Detail fasilitas |
| `/ekstrakurikuler/` | `archive-ekstrakurikuler.php` | Daftar ekstrakurikuler |
| `/ekstrakurikuler/{slug}/` | `single-ekstrakurikuler.php` | Detail ekstrakurikuler |
| URL native post | `single.php` / `category.php` | Tersedia sebagai template, tetapi single post dan kategori `berita`/`pengumuman` diblokir plugin |
| URL tidak ditemukan | `404.php` | Halaman 404 umum |
| `/agenda/` dan detail Agenda | `archive-agenda.php`, `single-agenda.php`, `page-agenda.php` | Sengaja 404; template lama dipindahkan ke `_archived_templates/` |

## 6. Fitur UI/UX Khusus

- **Mobile drawer navigation**: `js/navigation.js` membuka dan menutup drawer menu, overlay, submenu, serta mendukung tombol Escape dan atribut ARIA.
- **Scroll reveal animations**: `js/scroll-reveal.js` memakai `IntersectionObserver` untuk memberi kelas `fade-in-up` dan `is-visible` pada section serta elemen slide.
- **Image reveal**: `js/image-reveal.js` memberi kelas `sdn-reveal` dan `is-loaded` pada gambar setelah berhasil atau gagal dimuat.
- **Cursor spotlight**: `js/card-spotlight.js` menambahkan efek posisi spotlight pada foto Guru, Fasilitas, dan Ekstrakurikuler di layar desktop; dinonaktifkan pada lebar maksimal 800px.
- **Animated statistics counter**: `js/stat-counter.js` menganimasikan angka statistik ketika masuk viewport, dengan dukungan `prefers-reduced-motion`.
- **Guru carousel**: `js/guru-carousel.js` menginisialisasi Swiper responsif dengan pagination, tombol navigasi, dan breakpoint mobile sampai desktop. Dependensinya adalah Swiper 10 dari CDN.
- **Glassmorphism header**: `style.css` menerapkan header transparan dengan `backdrop-filter` dan fallback prefiks WebKit.
- **View Transitions progressive enhancement**: `style.css` mendefinisikan `@view-transition`, pseudo-element transition, dan dukungan `view-transition-name` pada detail foto Guru. Namun audit tidak menemukan pemanggilan JavaScript `document.startViewTransition`; transisi bergantung pada dukungan browser dan mekanisme CSS yang tersedia, sehingga perlu diuji pada browser target.
- Semua file di folder `js/` theme yang terdeteksi (`navigation.js`, `scroll-reveal.js`, `image-reveal.js`, `card-spotlight.js`, `stat-counter.js`, dan `guru-carousel.js`) memiliki pasangan enqueue di `functions.php`. Tidak ditemukan file JS theme yang yatim atau dipanggil tetapi tidak ada.

## 7. Panel Admin (Pengaturan Website)

Halaman **SDN Cilopang > Pengaturan Website** menyimpan data pada option `sdn_cilopang_settings`.

### Identitas

- Nama Sekolah
- Tagline
- Logo Sekolah

### Hero

- Judul Hero
- Deskripsi Hero
- Gambar Hero

### Profil Sekolah

- Judul Profil
- Deskripsi Profil
- Sejarah
- Visi
- Misi
- NPSN
- Jumlah Siswa
- Tahun Berdiri
- Akreditasi
- Foto Sekolah

### Kontak

- Alamat
- Telepon
- Email

### Sosial Media

- Facebook
- Instagram
- YouTube
- TikTok
- WhatsApp

### Statistik

Tidak ada section admin terpisah bernama “Statistik”. Data yang dipakai untuk tampilan statistik beranda adalah field **Jumlah Siswa**, **Tahun Berdiri**, dan **Akreditasi** pada section Profil Sekolah; jumlah Guru & Tendik dihitung otomatis dari jumlah post `guru` yang berstatus publish.

## 8. Cara Menjalankan Secara Lokal

1. Letakkan folder project di web root, misalnya `C:\laragon\www\SDN-Cilopang`.
2. Pastikan database dengan nama `SDN-Cilopang` tersedia dan kredensialnya sesuai `wp-config.php`: host `localhost`, user `root`, password kosong, prefix `wp_`.
3. Jalankan Apache dan MySQL melalui Laragon atau stack server lokal yang digunakan.
4. Buka alamat project melalui browser. `WP_SITEURL` dan `WP_HOME` dibentuk dari `REQUEST_SCHEME` dan `HTTP_HOST` saat WordPress dijalankan, kecuali ketika dipanggil melalui WP-CLI.
5. Pastikan theme `sdn-cilopang` dan plugin `SDN Cilopang` aktif dari dashboard WordPress.

Tidak ada build step, `npm install`, atau proses Composer yang diperlukan untuk menjalankan theme/plugin custom ini.

## 9. Role & Akses Admin

Kode plugin tidak mendaftarkan role custom baru. Alur pengelolaan penuh ditujukan untuk user dengan capability Administrator (`manage_options`), yang dapat mengelola CPT, menu, plugin, dan Pengaturan Website. Plugin juga memiliki pembatasan menu dan akses untuk user non-Administrator, termasuk pemblokiran Posts/Berita dan Agenda.

Tidak ada implementasi role Editor/operator khusus yang dibuat oleh project ini. Daftar role aktual dan user yang aktif tersimpan di database WordPress, sehingga klaim bahwa hanya role Administrator yang aktif perlu diverifikasi pada server produksi.

## 10. Catatan untuk Pengembang Selanjutnya

- CSS utama berada di `wp-content/themes/sdn-cilopang/style.css`. Ini adalah satu stylesheet besar yang di-enqueue theme.
- Tidak ada CSS terpisah yang di-enqueue dari plugin. File `wp-content/plugins/sdn-cilopang/public/css/style.css` masih ada sebagai file legacy, tetapi tidak dipanggil oleh kode plugin; jangan mencari stylesheet plugin aktif untuk mengubah tampilan frontend.
- `wp-content/plugins/sdn-cilopang/public/js/script.js` juga ada tetapi kosong dan tidak di-enqueue.
- Gunakan prefix class dan fungsi `sdn-` atau `sdn_` agar konsisten dan menghindari benturan dengan WordPress atau theme/plugin lain.
- Agenda sengaja diblokir di beberapa lapisan: CPT default tidak diregistrasikan, menu admin dihapus, akses admin langsung dialihkan, dan template Agenda menampilkan 404. Untuk mengaktifkan kembali, ubah atau tambahkan filter `sdn_cilopang_enable_agenda_cpt` agar menghasilkan `true`, pulihkan hook penyimpanan/shortcode yang dibutuhkan, hapus pembatasan Agenda di `sdn-cilopang.php`, pulihkan template frontend dari `_archived_templates/`, lalu flush permalink/rewrite rules.
- Berita publik juga sengaja diblokir untuk single post dan kategori `berita`/`pengumuman`. Untuk mengaktifkannya, tinjau fungsi `sdn_cilopang_block_berita_public`, pembatasan layar admin Posts, dan pemanggilan konten Berita pada template theme.
- Enqueue frontend memakai `filemtime()` sebagai versi cache-busting. Jika file JS dipindahkan atau diganti nama, pasangan path pada `functions.php` harus diperbarui bersamaan.
- Swiper 10 dan Google Fonts dimuat dari CDN, sehingga tampilan carousel dan tipografi bergantung pada ketersediaan koneksi jaringan ketika halaman dibuka.
- `WP_DEBUG` pada `wp-config.php` bernilai `false`. Untuk pengembangan lokal, status ini dapat dipertimbangkan kembali sesuai kebutuhan, tetapi jangan menyalakan tampilan error di server produksi tanpa prosedur keamanan.

