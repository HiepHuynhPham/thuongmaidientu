# Fruit Shop Laravel 10

Hướng dẫn chạy dự án trên máy mới (Windows/macOS/Linux) và deploy lên Render.

## Yêu cầu hệ thống
- `PHP >= 8.0.2` (có `pdo_pgsql` nếu dùng PostgreSQL)
- `Composer`
- `Node.js >= 16` và `npm`
- `PostgreSQL` (local) hoặc tài khoản Render PostgreSQL (cloud)

## Cài đặt nhanh (Local)
1. Clone mã nguồn:
   - `git clone https://github.com/HiepHuynhPham/thuongmaidientu.git`
   - `cd thuongmaidientu`
2. Cài dependency PHP:
   - `composer install`
3. Sao chép cấu hình môi trường:
   - `copy .env.example .env` (Windows) hoặc `cp .env.example .env`
4. Sinh khóa ứng dụng:
   - `php artisan key:generate`
5. Cấu hình database trong `.env` (xem mục cấu hình bên dưới)
6. Chạy migrate (tạo bảng):
   - `php artisan migrate`
7. Tạo liên kết storage (hiển thị ảnh):
   - `php artisan storage:link`
8. Cài và build frontend assets:
   - `npm ci`
   - `npm run build`
9. Chạy ứng dụng:
   - `php artisan serve` (ví dụ mở `http://127.0.0.1:8000`)

## Cấu hình `.env`
### Local PostgreSQL
- `DB_CONNECTION=pgsql`
- `DB_HOST=127.0.0.1`
- `DB_PORT=5432`
- `DB_DATABASE=your_db`
- `DB_USERNAME=your_user`
- `DB_PASSWORD=your_password`

### Render PostgreSQL (SSL bắt buộc)
- `DB_CONNECTION=pgsql`
- `DB_HOST=<host Render>`
- `DB_PORT=5432`
- `DB_DATABASE=<db Render>`
- `DB_USERNAME=<user Render>`
- `DB_PASSWORD=<password Render>`
- `DB_SSLMODE=require`
- `DATABASE_URL=postgres://<user>:<pass>@<host>:5432/<db>?sslmode=require&connect_timeout=15`

Gợi ý: khi dùng `DATABASE_URL`, để trống `DB_HOST/DB_PORT/DB_DATABASE/DB_USERNAME/DB_PASSWORD` hoặc đặt mặc định `null` trong `config/database.php` để Laravel ưu tiên URL.

## Deploy lên Render (Free, env php)
1. Push code lên GitHub
   - `git add . && git commit -m "Update code" && git push origin main`
2. Render tự build và deploy khi có push lên nhánh dùng bởi service
3. Cấu hình `render.yaml` (đã có trong repo):
   - `env: php`
   - `buildCommand` chạy `composer install`, `php artisan config:clear`, `php artisan cache:clear`
   - `startCommand: php artisan serve --host 0.0.0.0 --port 10000`
4. Sau deploy, chạy migrate:
   - Nếu có Shell: `php artisan migrate --force`
   - Nếu không có Shell: truy cập `https://<domain>/run-migrate`
5. Dọn cache sau deploy:
   - Truy cập `https://<domain>/clear-cache`

## Seed/Import dữ liệu
- Seeder mặc định: `php artisan db:seed`
- Import dữ liệu mẫu từ thư mục `initdb`:
  - `psql "<DATABASE_URL>" -f initdb/fruitshop.sql`
  - `psql "<DATABASE_URL>" -f initdb/products_seed.sql`

## Kiểm tra ảnh (storage)
- Đảm bảo đã chạy `php artisan storage:link`
- Ảnh được tham chiếu qua `asset('storage/...')`

## Các URL tiện ích
- Dọn cache cấu hình/ứng dụng: `GET /clear-cache`
- Chạy migrate (không Shell): `GET /run-migrate`

## Khắc phục lỗi thường gặp
- SSL PostgreSQL bị đóng đột ngột:
  - Dùng `DATABASE_URL` có `sslmode=require` và `connect_timeout=15` (có thể tăng 20)
  - Bật “Require SSL” trong Render Postgres
  - Clear/cache lại cấu hình sau deploy
- Khóa `APP_KEY` không hợp lệ:
  - `php artisan key:generate`, sau đó `php artisan config:clear && php artisan config:cache`
- Lỗi ghi session: `file_put_contents(.../storage/framework/sessions)`
  - Đảm bảo thư mục `storage/framework/{sessions,cache,views,testing}` tồn tại và có quyền ghi
- Layout hiển thị sai:
  - Dùng `@include('client.layout.header')` và `@include('client.layout.footer')` thay vì `@extends`
- Ảnh không hiển thị:
  - Kiểm tra lại `storage:link` và đường dẫn `asset('storage/...')`

## Ghi chú bảo mật
- Không commit file `.env` và dữ liệu nhạy cảm; repo đã có `.gitignore` cho `.env`

## Lệnh nhanh
- Cài đặt: `composer install && npm ci && npm run build`
- Sinh key: `php artisan key:generate`
- Migrate: `php artisan migrate --force`
- Storage link: `php artisan storage:link`
- Dọn cache: `php artisan config:clear && php artisan cache:clear && php artisan config:cache`
- Chạy dev: `php artisan serve`
