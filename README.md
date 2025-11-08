# Fruit Shop Laravel – Hướng dẫn chạy và thanh toán

## 🔰 Giới thiệu

Dự án thương mại điện tử (Laravel) với các tính năng chính:
- Quản lý sản phẩm, giỏ hàng, đặt hàng, lịch sử đơn hàng.
- Xác thực: đăng nhập thường và Google.
- Thanh toán: VNPay (sandbox/UAT) và PayPal (sandbox). 
- Hỗ trợ chạy bằng Docker hoặc cục bộ.

Repo GitHub: `https://github.com/HiepHuynhPham/thuongmaidientu`

---

## ✅ Yêu cầu hệ thống
- Docker Desktop (khuyến nghị), hoặc
- Chạy cục bộ: `PHP 8.x`, `Composer`, `Node.js` (với `npm`), MySQL.

---

## 🐳 Chạy bằng Docker

1) Cài Docker Desktop:  
   👉 https://docs.docker.com/desktop/setup/install/windows-install

2) Build và chạy:
```bash
docker compose up --build
# hoặc nếu đã build trước đó
docker-compose down -v && docker-compose build --no-cache && docker-compose up -d
```

3) Truy cập ứng dụng:
- `http://localhost:8000` – giao diện người dùng
- `http://localhost:8000/admin` – trang quản trị
- Mailpit UI (nếu dùng gửi mail dev): `http://localhost:8025`

4) Storage symlink (nếu thiếu link `public/storage`):
```bash
docker exec -u root -it laravel-app php artisan storage:link
```

5) Cấu hình DB trong `.env` (với Docker):
- `DB_CONNECTION=mysql`
- `DB_HOST=mysql-db`
- `DB_PORT=3306`
- `DB_DATABASE=fruitshop`
- `DB_USERNAME=root`
- `DB_PASSWORD=` (để trống – theo `docker-compose.yml`)

Init dữ liệu: container MySQL sẽ tự import các file trong `initdb/`. Nếu cần, có thể chạy lại migrations/seeds từ ứng dụng.

---

## 💻 Chạy cục bộ (không dùng Docker)
```bash
composer install
cp .env.example .env
php artisan key:generate
# Cập nhật biến DB_* theo MySQL cục bộ của bạn
php artisan migrate --seed
npm install
npm run dev
php artisan serve --port 8000
```

---

## 🔧 Biến môi trường quan trọng (.env)

### 1) Ứng dụng
- `APP_URL` (ví dụ: `http://localhost:8000`)
- `APP_KEY` (tạo bằng `php artisan key:generate`)

### 2) VNPay (Sandbox/UAT)
- `VNPAY_ENDPOINT` (mặc định: `https://sandbox.vnpayment.vn/paymentv2/vpcpay.html`)
- `VNPAY_TMN_CODE`
- `VNPAY_HASH_SECRET`
- `VNPAY_RETURN_URL` (ví dụ khi test qua Cloudflare Tunnel: `https://<random>.trycloudflare.com/thank`)
- `VNPAY_VERSION` (mặc định: `2.1.0`), `VNPAY_LOCALE` (`vn` hoặc `en`), `VNPAY_CURRENCY` (`VND`)
- `VNPAY_DEBUG` (true/false – ghi log params gửi đi)

### 3) PayPal (Sandbox)
- `PAYPAL_MODE=sandbox`
- `PAYPAL_SANDBOX_CLIENT_ID` hoặc `PAYPAL_CLIENT_ID`
- `PAYPAL_SANDBOX_CLIENT_SECRET` hoặc `PAYPAL_SECRET`
- Tuỳ chọn: `PAYPAL_PAYMENT_ACTION` (mặc định `Sale`), `PAYPAL_CURRENCY` (mặc định `USD`), `PAYPAL_NOTIFY_URL`, `PAYPAL_LOCALE`, `PAYPAL_VALIDATE_SSL`

Xem thêm trong `config/paypal.php` để biết biến nào được dùng khi `sandbox`/`live`.

---

## 🧭 Luồng checkout và các route chính
- `GET /checkout` – trang xác nhận giỏ hàng.
- `POST /confirm-checkout` – xác nhận và chuẩn bị đặt hàng.
- `POST /place-order` – tạo đơn hàng.
- `GET /thank` – trang trả về sau VNPay (return URL).

### VNPay
- Ứng dụng tạo URL thanh toán từ `App\Services\VnPayService` (dùng các biến `VNPAY_*`).
- Khi người dùng thanh toán xong, VNPay gọi về `VNPAY_RETURN_URL` (mặc định trỏ tới route `thank`).

### PayPal
- Trang tích hợp JS SDK: `GET /paypal/checkout`.
- Endpoints SDK: `POST /paypal/orders/create`, `POST /paypal/orders/capture`.
- Luồng redirect server-side: `POST /payment/redirect-paypal` → `GET /payment/paypal-return` / `GET /payment/paypal-cancel`.

---

## 🌐 Test VNPay qua Cloudflare Tunnel (sửa lỗi 72 – Không tìm thấy website)
1) Cài `cloudflared`:  
   👉 https://developers.cloudflare.com/cloudflare-one/connections/connect-networks/downloads/
2) Chạy tunnel trỏ về ứng dụng local:
```bash
cloudflared tunnel --url http://localhost:8000
```
3) Sao chép URL ngẫu nhiên (ví dụ: `https://procurement-ratings-trackbacks-tradition.trycloudflare.com`).
4) Cập nhật `.env`:
```env
VNPAY_RETURN_URL=https://<random>.trycloudflare.com/thank
```
5) Xoá cache cấu hình:
```bash
php artisan config:clear
```
6) Kiểm thử lại thanh toán VNPay từ `https://<random>.trycloudflare.com/checkout` (lưu ý dùng HTTPS).

### Khắc phục 419 Page Expired
- Dùng đúng giao thức HTTPS khi truy cập qua Cloudflare Tunnel.
- Đã thêm ngoại lệ CSRF cho `POST /confirm-checkout` để tránh lỗi khi proxy qua domain khác.
- Nếu cần, kiểm tra cookies/session khi chạy sau reverse proxy.

---

## 👤 Tài khoản đăng nhập test

| Role  | Email           | Mật khẩu |
|-------|-----------------|----------|
| Admin | admin@gmail.com | 123456   |
| User  | user@gmail.com  | 123456   |
| User  | test@gmail.com  | 123456   |

Đăng nhập bằng Google: bấm **"Đăng nhập bằng Google"** trên giao diện.

---

## 🆘 Hỗ trợ
- Nếu gặp lỗi thanh toán VNPay, kiểm tra `storage/logs/laravel.log` với `VNPAY_DEBUG=true`.
- Cần hướng dẫn cấu hình chi tiết, liên hệ qua issues của repo.
