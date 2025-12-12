# HƯỚNG DẪN DEPLOY DỰ ÁN HPSHIP LÊN HOST

## 1. CÁC THAY ĐỔI ĐÃ THỰC HIỆN

### File `config.php`
- Tự động phát hiện môi trường (localhost hoặc host)
- Tự động xác định BASE_URL dựa trên domain hiện tại
- Định nghĩa các constant để sử dụng xuyên suốt ứng dụng:
  - `BASE_URL`: URL gốc của website
  - `API_BASE_URL`: URL của thư mục API
  - `VIEW_PATH`: URL của thư mục view
  - `CSS_PATH`, `JS_PATH`, `IMG_PATH`: URL các thư mục tài nguyên

### File `index.php`
- Include `config.php` ở đầu file
- Thay thế tất cả đường dẫn tĩnh bằng các constant động
- Các link đăng nhập, đăng ký, logo đều sử dụng BASE_URL

### File `.htaccess`
- Thêm `RewriteBase` để xử lý đường dẫn đúng
- Thêm bảo mật (Options -Indexes)
- Set charset mặc định UTF-8

## 2. HƯỚNG DẪN DEPLOY

### Trường hợp 1: Deploy vào thư mục WEBSITE_EXHIBITION trên host

**Bước 1:** Upload toàn bộ files lên host vào thư mục `WEBSITE_EXHIBITION`

**Bước 2:** Kiểm tra file `.htaccess` đảm bảo:
```apache
RewriteBase /WEBSITE_EXHIBITION/
```

**Bước 3:** Không cần thay đổi gì thêm - `config.php` sẽ tự động nhận diện!

**URL truy cập:** `http://yourdomain.com/WEBSITE_EXHIBITION/`

### Trường hợp 2: Deploy vào thư mục ROOT (public_html hoặc htdocs)

**Bước 1:** Upload toàn bộ files lên thư mục ROOT của host

**Bước 2:** Sửa file `.htaccess`:
```apache
RewriteBase /
```

**Bước 3:** File `config.php` sẽ tự động phát hiện và dùng `/` làm base path

**URL truy cập:** `http://yourdomain.com/`

## 3. KIỂM TRA SAU KHI DEPLOY

### Kiểm tra cơ bản:
1. Truy cập trang chủ - kiểm tra logo có hiển thị không
2. Click vào "Đăng nhập" - phải mở được trang đăng nhập
3. Click vào "Đăng ký" - phải mở được trang đăng ký
4. Kiểm tra các link menu (TRANG CHỦ, TÌM KIẾM BƯU CỤC, v.v.)

### Nếu gặp lỗi 404:

**Lỗi:** Link đăng nhập bị 404
**Nguyên nhân:** Đường dẫn chưa đúng với cấu trúc thư mục trên host
**Giải pháp:**
1. Kiểm tra bạn đã upload files vào đâu (root hay subfolder)
2. Sửa `RewriteBase` trong `.htaccess` cho phù hợp
3. Nếu vẫn lỗi, kiểm tra tên file có đúng không (chú ý chữ hoa/thường)

**Lỗi:** Hình ảnh không hiển thị
**Nguyên nhân:** Đường dẫn đến thư mục `img/` chưa đúng
**Giải pháp:** File `config.php` đã tự động xử lý, kiểm tra lại thư mục `img/` có tồn tại không

**Lỗi:** AJAX search không hoạt động
**Nguyên nhân:** Đường dẫn API chưa đúng
**Giải pháp:** `API_BASE_URL` đã được config tự động, kiểm tra thư mục `API/` có tồn tại không

## 4. CẤU HÌNH DATABASE TRÊN HOST

**Bước 1:** Tạo database MySQL trên host với tên `HPship`

**Bước 2:** Import file SQL vào database

**Bước 3:** Cập nhật thông tin kết nối database trong các file `model/connect*.php`:

```php
// Thay đổi từ:
$conn = new mysqli("localhost", "root", "", "HPship");

// Thành (ví dụ):
$conn = new mysqli("localhost", "your_db_user", "your_db_password", "HPship");
```

**Lưu ý quan trọng:**
- Trên host thường không dùng user `root`
- Password thường không để trống
- Host database có thể khác `localhost` (vd: `localhost:3306` hoặc IP riêng)

## 5. CẤU HÌNH BẢO MẬT

### File permissions (chmod):
- Thư mục: 755
- File PHP: 644
- File `.htaccess`: 644

### Bảo mật database:
- Tạo user database riêng, không dùng root
- Đặt password mạnh cho database
- Không public thông tin database credential

## 6. KIỂM TRA TƯƠNG THÍCH MÔI TRƯỜNG

### Yêu cầu server:
- PHP >= 7.0
- MySQL >= 5.6
- Apache với mod_rewrite enabled
- PHP Extensions: mysqli, PDO, mbstring

### Test trên host:
1. Tạo file `test.php` trong thư mục root:
```php
<?php
phpinfo();
?>
```

2. Truy cập `yourdomain.com/test.php` để kiểm tra:
   - Phiên bản PHP
   - Các extension đã cài
   - mod_rewrite có enabled không

3. Sau khi kiểm tra xong, XÓA file `test.php` để bảo mật

## 7. GỠ LỖI (DEBUGGING)

### Bật hiển thị lỗi PHP (chỉ dùng khi debug):

Thêm vào đầu file `config.php`:
```php
// CHỈ DÙNG KHI DEBUG - XÓA KHI DEPLOY PRODUCTION
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

**LƯU Ý:** Nhớ TẮT hoặc XÓA sau khi debug xong!

### Kiểm tra log:
- Apache error log: Thường ở `error_log` hoặc `logs/error_log`
- PHP error log: Kiểm tra trong cPanel hoặc file manager

## 8. LƯU Ý KHI SỬ DỤNG LOCALHOST VÀ HOST SONG SONG

Với cấu hình mới, bạn có thể:
- ✅ Phát triển trên localhost bình thường
- ✅ Deploy lên host mà KHÔNG CẦN sửa code
- ✅ File `config.php` tự động phát hiện và chọn đường dẫn phù hợp

**Không cần:**
- ❌ Sửa đường dẫn mỗi lần deploy
- ❌ Maintain 2 phiên bản code khác nhau
- ❌ Thay đổi hardcoded URLs

## 9. CHECKLIST DEPLOY

- [ ] Upload toàn bộ files lên host
- [ ] Kiểm tra `.htaccess` có `RewriteBase` đúng
- [ ] Tạo database và import SQL
- [ ] Cập nhật thông tin database trong `connect*.php`
- [ ] Test trang chủ
- [ ] Test link đăng nhập/đăng ký
- [ ] Test tìm kiếm vận đơn
- [ ] Test các chức năng chính
- [ ] Tắt display_errors
- [ ] Xóa các file test

## HỖ TRỢ

Nếu gặp vấn đề, kiểm tra:
1. File `.htaccess` có được server hỗ trợ không?
2. Mod_rewrite có được bật không?
3. Thư mục và file permissions đã đúng chưa?
4. Database connection có thành công không?
5. Có file nào bị thiếu sau khi upload không?
