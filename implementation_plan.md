# Rencana Pembuatan Antarmuka UI (Fase 5)

Dokumen ini merangkum rencana pembuatan *views* (tampilan antarmuka) untuk fitur-fitur Mini ERP yang *backend*-nya telah kita bangun sebelumnya. Hal ini akan memungkinkan staf Admin, Produksi, dan Gudang untuk mengelola tugas mereka melalui sistem.

## User Review Required

> [!IMPORTANT]
> Karena kita tidak menggunakan *Livewire PowerGrid* untuk halaman-halaman baru ini (berbeda dengan halaman lama), saya akan menggunakan tabel HTML standar dengan Tailwind CSS yang responsif. Apakah Anda setuju dengan pendekatan antarmuka standar yang lebih cepat dan fleksibel ini?

## Proposed Changes

### 1. Modul Master Data (Admin & Manager)
Kita akan membangun halaman manajemen data pokok ERP.

#### [NEW] `resources/views/pages/bahan-baku/index.blade.php`
- Tabel daftar Bahan Baku beserta sisa stok, kategori, dan batas minimum stok.
#### [NEW] `resources/views/pages/bahan-baku/create.blade.php`
- Form pembuatan Bahan Baku baru (Nama, Kategori, Unit, Harga Beli, Min Stock).
#### [NEW] `resources/views/pages/bahan-baku/edit.blade.php`
- Form pembaruan Bahan Baku.

---

### 2. Modul BOM / Bill of Materials (Admin & Manager)
Halaman untuk mengatur resep produk.

#### [NEW] `resources/views/pages/bom/index.blade.php`
- Daftar BOM yang aktif per produk.
#### [NEW] `resources/views/pages/bom/create.blade.php`
- Form dinamis untuk membuat BOM (pemilihan 1 produk akhir, dan multiple input untuk Bahan Baku & Kuantitas).
#### [NEW] `resources/views/pages/bom/show.blade.php`
- Halaman detail yang menampilkan komposisi sebuah BOM.

---

### 3. Modul Produksi (Staf Produksi)
Halaman eksekusi proses produksi di lapangan.

#### [NEW] `resources/views/pages/produksi/index.blade.php`
- Tabel riwayat dan daftar produksi yang sedang berjalan beserta statusnya (`pending`, `in_progress`, `completed`, `failed`).
#### [NEW] `resources/views/pages/produksi/create.blade.php`
- Form request produksi baru (Pilih Produk, Target Kuantitas, dan Tanggal Mulai).
#### [NEW] `resources/views/pages/produksi/show.blade.php`
- Halaman detail untuk memantau status material dari gudang dan *action button* untuk merubah status produksi (Mulai, Selesai, Gagal).

---

### 4. Modul Gudang Masuk (Staf Gudang)
Halaman penerimaan stok fisik ke dalam fasilitas gudang.

#### [NEW] `resources/views/pages/gudang/masuk/purchase_index.blade.php`
- Tabel daftar *Purchase Order* (PO) dari *Supplier* yang menunggu kedatangan. Terdapat tombol "Approve" (Terima Barang).
#### [NEW] `resources/views/pages/gudang/masuk/hasil_produksi_index.blade.php`
- Tabel penerimaan barang jadi (*Good Products*) dari tim Produksi yang telah selesai.

---

### 5. Modul Gudang Keluar (Staf Gudang)
Halaman pendistribusian stok keluar dari gudang.

#### [NEW] `resources/views/pages/gudang/keluar/detail_produksi_index.blade.php`
- Tabel daftar permintaan Bahan Baku dari tim Produksi. Staf gudang menekan tombol "Approve" untuk merilis stok.
#### [NEW] `resources/views/pages/gudang/keluar/sale_index.blade.php`
- Tabel pengiriman Barang Jadi (*Products*) kepada *Customer* berdasarkan daftar *Sales* (POS) yang sudah diotorisasi.

---

### 6. Modul Stock Adjustment (Staf Gudang)
Halaman penyesuaian stok opname manual.

#### [NEW] `resources/views/pages/gudang/adjustment/create.blade.php`
- Form penyesuaian stok (Pilih Item, Jenis Penyesuaian: *Correction, Loss, Damage*, dan Catatan).

## Verification Plan

### Manual Verification
1. Anda dapat *login* sebagai **Admin** untuk membuat Bahan Baku dan BOM.
2. Anda dapat *login* sebagai **Produksi** untuk merequest Produksi baru dan memantau statusnya.
3. Anda dapat *login* sebagai **Gudang** untuk menerima barang dari *Supplier*, menyalurkan bahan baku ke *Produksi*, dan menyalurkan barang jadi untuk *Sales*. Semua tombol "Approve" dan navigasi *sidebar* akan diuji fungsinya secara menyeluruh.
