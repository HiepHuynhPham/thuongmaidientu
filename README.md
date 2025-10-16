# Laravel Project - Chạy bằng Docker không cần cài đặt gì thêm

## 🔰 Giới thiệu

Dự án Laravel này được cấu hình sẵn bằng Docker. Bạn **KHÔNG CẦN CÀI** bất kỳ công cụ nào như:
- XAMPP
- MySQL
- PHP
- Laravel

Toàn bộ đã được đóng gói, chỉ cần cài **Docker Desktop**, giải nén mã nguồn và làm theo hướng dẫn bên dưới là có thể chạy được.

---

## ✅ Yêu cầu duy nhất

### 1. Cài đặt Docker Desktop
- Tải và cài đặt Docker tại:  
  👉 [https://docs.docker.com/desktop/setup/install/windows-install](https://docs.docker.com/desktop/setup/install/windows-install)
- Sau khi cài đặt xong, **khởi động lại máy tính** để đảm bảo Docker hoạt động tốt.

---

## 📦 Các bước chạy dự án

### 2. Giải nén mã nguồn

Giải nén file source code vào một thư mục bất kỳ.

---

### 3. Xóa file `storage` lỗi

- Mở thư mục `myproject/public`
- Xóa file `storage` (thường là một shortcut 0KB)
![hình ảnh file](https://github.com/dung11122005/IMG_TEST/blob/master/README%20PHP/forder.png)
---

### 4. Tạo symbolic link

Mở Terminal hoặc CMD ngay tại thư mục gốc chứa project (chứa file `docker-compose.yml`) và chạy:

```bash
docker exec -u root -it laravel-app php artisan storage:link
```

## 5. 🐳 Build và khởi động Docker

### ⏱ Nếu bạn **chưa từng build** lần nào, chạy lệnh:

```bash
docker compose up --build
```

### ⏱ Nếu bạn **đã build** thì chạy lệnh:

```bash
docker-compose down -v
docker-compose build --no-cache
docker-compose up -d
```

## 6. Mở Docker Desktop

1. Mở ứng dụng **Docker Desktop**
2. Vào tab **Containers**
3. Tìm container tên **`myproject`** (hoặc tên bạn đặt trong `docker-compose.yml`)
![khi build docker thành công](https://github.com/dung11122005/IMG_TEST/blob/master/README%20PHP/docker1.png)
4. Nhấn **Start** (nếu container chưa chạy)
5. Chờ vài giây, sau đó mở trình duyệt để truy cập:

| Đường dẫn                       | Mục đích              |
|--------------------------------|------------------------|
| [http://localhost:8000](http://localhost:8000)       | Giao diện người dùng     |
| [http://localhost:8000/admin](http://localhost:8000/admin) | Trang quản trị admin     |

---

## 👤 Tài khoản đăng nhập test

| Role  | Email            | Mật khẩu |
|-------|------------------|----------|
| Admin | admin@gmail.com  | 123456   |
| User  | user@gmail.com   | 123456   |
| User  | test@gmail.com   | 123456   |

## Đăng nhập bằng Google

Hệ thống hỗ trợ đăng nhập bằng Google.  
Chỉ cần bấm **"Đăng nhập bằng Google"** trên giao diện.

---

## 💰 Thanh toán bằng MoMo (Môi trường test - UAT)

### Bước 1: Tải App MoMo UAT

👉 Tải tại: [https://developers.momo.vn/v3/vi/download](https://developers.momo.vn/v3/vi/download)

> Nếu không quét được QR, mở link bằng điện thoại để tải trực tiếp app.

### Bước 2: Hướng dẫn sử dụng MoMo test

Chi tiết hướng dẫn sử dụng, nạp tiền, tạo tài khoản test tại:  
👉 [https://developers.momo.vn/v3/vi/docs/payment/onboarding/test-instructions](https://developers.momo.vn/v3/vi/docs/payment/onboarding/test-instructions)

---

### ✅ Lưu ý trong môi trường test:

- Mật khẩu, mã OTP, mã xác thực... đều là **toàn số 0**
- Bạn có thể nạp tiền ảo để thử thanh toán
