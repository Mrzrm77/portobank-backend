# Penjelasan Singkat Study Case TokoHebat

Kode yang dibuat Yoga berbahaya karena beberapa fitur keamanan dasar pada backend Laravel tidak diterapkan dengan benar. Meskipun aplikasi dapat berjalan, sistem masih sangat rentan terhadap penyalahgunaan dan kebocoran data.

## 1. Login Tanpa Verifikasi Password

Pada versi buggy, proses login hanya memeriksa apakah email pengguna ada di database tanpa melakukan pengecekan password.

### Dampak
- Siapa pun dapat login ke akun orang lain hanya dengan mengetahui email korban.
- Akun pelanggan dapat diambil alih dengan mudah.
- Data pribadi pengguna berisiko bocor atau disalahgunakan.

### Perbaikan
Menggunakan `Hash::check()` untuk memverifikasi password dan Laravel Sanctum untuk authentication token.

---

## 2. User Biasa Bisa Mengakses Endpoint Admin

Endpoint admin hanya dilindungi dengan authentication, tetapi tidak memiliki authorization atau pengecekan role user.

### Dampak
- User biasa dapat mengakses data admin atau data pengguna lain.
- Terjadi privilege escalation, yaitu user mendapatkan akses yang seharusnya tidak dimiliki.
- Sistem menjadi rentan terhadap manipulasi data sensitif.

### Perbaikan
Menggunakan middleware admin untuk memastikan hanya user dengan role `admin` yang dapat mengakses endpoint tertentu.

---

## 3. Password Disimpan Dalam Bentuk Plain Text

Password disimpan langsung ke database tanpa proses hashing.

### Dampak
- Jika database bocor, seluruh password pengguna dapat langsung dibaca.
- Pengguna yang memakai password yang sama di platform lain juga ikut terancam.
- Risiko pencurian akun dan kebocoran data menjadi sangat tinggi.

### Perbaikan
Menggunakan `Hash::make()` agar password tersimpan dalam bentuk hash terenkripsi.

---

# Kesimpulan

Project ini menunjukkan bahwa backend tidak cukup hanya berjalan dengan baik, tetapi juga harus aman. Laravel sebenarnya sudah menyediakan banyak fitur keamanan bawaan seperti hashing, middleware, authentication, dan validation. Jika fitur-fitur tersebut tidak digunakan dengan benar, aplikasi dapat mengalami masalah serius seperti account takeover, broken access control, dan data breach.