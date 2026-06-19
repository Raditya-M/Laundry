# 🧺 Fold & Wash

Fold & Wash adalah aplikasi manajemen laundry berbasis Web dan Mobile yang dirancang untuk membantu proses operasional laundry menjadi lebih cepat, terorganisir, dan efisien.

## ✨ Fitur Utama

### Admin Dashboard
- Manajemen pelanggan
- Manajemen layanan laundry
- Manajemen transaksi
- Update status laundry
- Membership pelanggan
- Laporan pemasukan
- Statistik bisnis

### Mobile App
- Login & Registrasi
- Melihat status laundry
- Riwayat transaksi
- Informasi membership
- Upload bukti pembayaran

---

## 🛠️ Teknologi yang Digunakan

### Backend
- Laravel 12
- Laravel REST API
- MySQL
- Sanctum / Bearer Token Authentication

### Frontend Web
- Blade Template Engine
- Tailwind CSS
- JavaScript
- SweetAlert2
- Font Awesome

### Mobile App
- React Native
- Expo
- Fetch API

---

## 📱 Cara Kerja Sistem

1. Admin membuat data pelanggan.
2. Admin membuat transaksi laundry.
3. Sistem menghitung total harga otomatis berdasarkan layanan dan berat/jumlah cucian.
4. Status laundry diperbarui secara bertahap:
   - Antrian
   - Dicuci
   - Disetrika
   - Siap Diambil
   - Diambil
5. Pelanggan dapat melihat perkembangan laundry melalui aplikasi mobile.
6. Semua data tersimpan dan dapat digunakan untuk laporan bisnis.

---

## 📊 Status Laundry

| Status | Keterangan |
|----------|------------|
| Antrian | Menunggu diproses |
| Dicuci | Sedang dicuci |
| Disetrika | Sedang disetrika |
| Siap Diambil | Laundry selesai |
| Diambil | Laundry telah diambil pelanggan |

---

## 🔒 Authentication

Menggunakan Bearer Token Authentication.

Endpoint:

```http
POST /api/login
POST /api/register
```

---

## 📡 API Endpoint

### Authentication

```http
POST /login
POST /register
```

### Transaction

```http
GET /transactions
POST /transactions
PUT /transactions/{id}/status
GET /history
GET /status-laundry
```

### Report

```http
GET /statistics
GET /report-income
```

---

## 📸 Preview

### Dashboard Admin
- Kelola pelanggan
- Kelola layanan
- Kelola transaksi
- Kelola membership
- Laporan bisnis

### Mobile Application
- Status laundry realtime
- Riwayat transaksi
- Membership pelanggan

---

## 👨‍💻 Developer

Developed by **Adit**  
Full Stack Developer

---

## 📄 License

This project is created for educational and portfolio purposes.
