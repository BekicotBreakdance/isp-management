Folder layouts berisi template/layout untuk website.

Catatan: saat ini proyek diminta versi HTML (tanpa engine template). Jadi base.html menggunakan placeholder:
- {{TITLE}} untuk judul halaman
- {{CONTENT}} untuk isi halaman

Untuk integrasi tanpa engine, bisa dilakukan dengan:
- duplikasi base.html ke tiap halaman (paling sederhana), atau
- replace placeholder secara manual di backend (PHP) sebelum output.

