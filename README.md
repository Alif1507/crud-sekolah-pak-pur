# CRUD Sekolah (PHP + MySQL) – Dockerized

Aplikasi web **CRUD Sekolah** (PHP plain + PDO + Session Login) dijalankan via **Docker Compose**: service `app` (Apache + PHP), `db` (MariaDB), dan opsional `phpmyadmin`.

---

## 📁 Struktur Proyek
```
crud-sekolah/
├─ public/                 # kode aplikasi (index.php, layout.php, auth/, murid/, nilai/)
├─ auth.php                # helper auth
├─ config.php              # koneksi PDO + session_start
├─ migrations.sql          # schema & seed (users, murid, nilai)
├─ Dockerfile              # image app (Apache + PHP extensions)
└─ docker-compose.yml
```

> Pastikan file `migrations.sql` berisi tabel: `users`, `murid`, `nilai`.

---

## 🔧 Prasyarat
- Docker Engine 24+
- Docker Compose v2

---

## 🚀 Quickstart
1. **Clone / salin** proyek ini dan masuk ke foldernya.
2. Buat file **`.env`** (opsional, untuk override):
   ```env
   APP_PORT=8080
   DB_PORT=3307
   DB_NAME=sekolah
   DB_USER=sekolah
   DB_PASS=mawkeren
   DB_ROOT_PASS=mawkeren
   ```
3. Jalankan:
   ```bash
   docker compose up -d --build
   ```
4. Akses aplikasi:
   - App: http://localhost:${APP_PORT:-8080}
   - phpMyAdmin (opsional): http://localhost:9090  (Server: `db`, User: `sekolah`, Pass: `mawkeren`)

Seed user login default: **admin / password**.

---

## 🐳 Dockerfile (contoh)
```Dockerfile
# Dockerfile
FROM php:8.2-apache

# enable apache mods
RUN a2enmod rewrite

# install PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# copy app (pakai bind mount di compose juga, ini untuk build awal)
WORKDIR /var/www/html
COPY . /var/www/html

# permissions sederhana (opsional)
RUN chown -R www-data:www-data /var/www/html
```

---

## 📦 docker-compose.yml (contoh)
```yaml
services:
  app:
    build: .
    container_name: crud-sekolah-app
    ports:
      - "${APP_PORT:-8080}:80"
    environment:
      DB_HOST: db
      DB_NAME: ${DB_NAME:-sekolah}
      DB_USER: ${DB_USER:-sekolah}
      DB_PASS: ${DB_PASS:-mawkeren}
    depends_on:
      - db
    volumes:
      - ./:/var/www/html:rw

  db:
    image: mariadb:11
    container_name: crud-sekolah-db
    environment:
      MYSQL_ROOT_PASSWORD: ${DB_ROOT_PASS:-mawkeren}
      MYSQL_DATABASE: ${DB_NAME:-sekolah}
      MYSQL_USER: ${DB_USER:-sekolah}
      MYSQL_PASSWORD: ${DB_PASS:-mawkeren}
    ports:
      - "${DB_PORT:-3307}:3306"
    volumes:
      - dbdata:/var/lib/mysql
      # auto-seed schema & data pada start pertama
      - ./migrations.sql:/docker-entrypoint-initdb.d/01_migrations.sql:ro

  phpmyadmin:
    image: phpmyadmin:5
    container_name: crud-sekolah-pma
    depends_on:
      - db
    environment:
      PMA_HOST: db
      UPLOAD_LIMIT: 128M
    ports:
      - "9090:80"

volumes:
  dbdata:
```

> **Catatan**: berkas `migrations.sql` hanya dieksekusi **saat volume `dbdata` kosong** (start pertama). Jika Anda mengubah schema, hapus volume dulu atau jalankan perubahan manual via phpMyAdmin/CLI.

---

## ⚙️ Konfigurasi Aplikasi
`config.php` akan membaca env dari Compose (lihat `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`). Contoh minimal:
```php
$DB_HOST = getenv('DB_HOST') ?: 'db';
$DB_NAME = getenv('DB_NAME') ?: 'sekolah';
$DB_USER = getenv('DB_USER') ?: 'sekolah';
$DB_PASS = getenv('DB_PASS') ?: 'mawkeren';
```

---

## 🧪 Perintah Umum
```bash
# start/stop
docker compose up -d --build
docker compose down

# lihat log
docker compose logs -f app
docker compose logs -f db

# masuk shell container app untuk debugging
docker compose exec app bash

# masuk mysql client di dalam container db
docker compose exec db mysql -u root -p${DB_ROOT_PASS:-mawkeren}

# reset database (hapus volume -> data hilang!)
docker compose down -v && docker compose up -d --build
```

---

## 🧰 Troubleshooting
**Port 8080/9090 sudah dipakai**  
Ganti `APP_PORT`/mapping port di `.env` atau `docker-compose.yml`.

**Aplikasi tidak bisa konek DB**  
- Pastikan `DB_HOST=db` dan service `db` healthy (cek `docker compose logs db`).
- Cek kredensial env (`DB_NAME`, `DB_USER`, `DB_PASS`).

**migrations.sql tidak jalan**  
- Hanya dieksekusi pada start pertama (volume kosong). Untuk re-seed:
  ```bash
  docker compose down -v
  docker compose up -d --build
  ```
  atau jalankan SQL manual via phpMyAdmin.

**“Headers already sent / session_start”**  
- Pastikan **tidak ada output sebelum `session_start()`**.
- Simpan file PHP sebagai **UTF-8 tanpa BOM**.
- Jangan pakai `?>` penutup.

---

## 🔐 Login Default
- **Username**: `admin`
- **Password**: `password`
> Ubah password via SQL atau buat halaman ubah password.

---

## 📜 Lisensi
Untuk keperluan pembelajaran/praktikum sekolah.

