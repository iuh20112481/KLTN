# HƯỚNG DẪN CẤU HÌNH DATABASE KHI DEPLOY LÊN HOST

## ⚠️ VẤN ĐỀ THƯỜNG GẶP

Khi deploy từ localhost lên host, **thông tin kết nối database KHÁC HOÀN TOÀN**:

| Thông tin | Localhost | Host (Production) |
|-----------|-----------|-------------------|
| Host | `localhost` | Tùy hosting provider (localhost, 127.0.0.1, hoặc IP riêng) |
| Username | `root` | Username được cấp bởi hosting |
| Password | (trống) | Password được cấp bởi hosting |
| Database | `HPship` | Tên database bạn tạo (có thể có prefix) |

## 🔧 CÁC BƯỚC CẤU HÌNH

### Bước 1: Lấy thông tin database từ hosting provider

Đăng nhập vào **cPanel** hoặc **hosting control panel**, tìm phần **MySQL Databases** hoặc **Database**.

Bạn sẽ thấy:
- **MySQL Host**: Thường là `localhost` hoặc IP cụ thể
- **MySQL User**: Username để kết nối database
- **MySQL Password**: Password (đã tạo khi setup database)
- **Database Name**: Tên database (có thể có prefix như `username_HPship`)

### Bước 2: Tạo database trên host

1. Vào **cPanel** → **MySQL Databases**
2. Tạo database mới với tên `HPship` (hoặc tên khác tùy ý)
3. Tạo user database mới
4. Gán user vào database với **ALL PRIVILEGES**
5. Ghi lại thông tin: database name, username, password

### Bước 3: Import database

1. Vào **phpMyAdmin** từ cPanel
2. Chọn database vừa tạo
3. Click tab **Import**
4. Chọn file SQL từ localhost (thường là `HPship.sql`)
5. Click **Go** để import

### Bước 4: Cập nhật file kết nối database

Bạn cần cập nhật **3 files** sau:

#### File 1: `model/connect1.php` (MySQLi)

Tìm đoạn code:
```php
$conn = new mysqli("localhost", "root", "", "HPship");
```

Thay đổi thành:
```php
// Thông tin từ hosting provider
$db_host = "localhost"; // Hoặc IP từ hosting
$db_user = "your_username"; // Username từ hosting
$db_pass = "your_password"; // Password từ hosting
$db_name = "your_database_name"; // Tên database (có thể có prefix)

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
```

#### File 2: `model/connect2.php` (MySQLi)

Tương tự như connect1.php, tìm và thay đổi thông tin kết nối.

#### File 3: `model/connect3.php` (PDO)

Tìm đoạn code:
```php
$pdo = new PDO("mysql:host=localhost;dbname=HPship", "root", "");
```

Thay đổi thành:
```php
$db_host = "localhost"; // Hoặc IP từ hosting
$db_user = "your_username"; // Username từ hosting
$db_pass = "your_password"; // Password từ hosting
$db_name = "your_database_name"; // Tên database

$pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
```

## 🔍 KIỂM TRA KẾT NỐI

Sau khi cập nhật, truy cập:
```
http://yourdomain.com/WEBSITE_EXHIBITION/test_environment.php
```

File này sẽ kiểm tra kết nối database và hiển thị lỗi cụ thể (nếu có).

### Các lỗi thường gặp:

#### Lỗi 2002: "No such file or directory"

**Nguyên nhân:** MySQL socket không tìm thấy

**Giải pháp:**
- Thử đổi host từ `localhost` sang `127.0.0.1`
- Hoặc thêm port: `localhost:3306` hoặc `127.0.0.1:3306`
- Liên hệ hosting provider để hỏi thông tin kết nối chính xác

**Ví dụ:**
```php
// Thay vì
$conn = new mysqli("localhost", $user, $pass, $dbname);

// Thử
$conn = new mysqli("127.0.0.1", $user, $pass, $dbname);

// Hoặc
$conn = new mysqli("localhost:3306", $user, $pass, $dbname);
```

#### Lỗi 1045: "Access denied for user"

**Nguyên nhân:** Sai username hoặc password

**Giải pháp:**
- Kiểm tra lại username/password từ cPanel
- Đảm bảo user đã được gán vào database
- Reset password nếu cần

#### Lỗi 1049: "Unknown database"

**Nguyên nhân:** Database chưa được tạo hoặc sai tên

**Giải pháp:**
- Kiểm tra tên database trong cPanel
- Lưu ý: Một số hosting thêm prefix vào tên database
  - VD: Bạn tạo `HPship` nhưng tên thực tế là `username_HPship`
- Dùng đúng tên database có prefix (nếu có)

#### Lỗi 2003: "Can't connect to MySQL server"

**Nguyên nhân:** Không thể kết nối đến MySQL server

**Giải pháp:**
- Kiểm tra MySQL service có đang chạy không
- Kiểm tra firewall
- Liên hệ hosting provider

## 💡 MẸO HAY

### Mẹo 1: Tạo file config riêng cho database

Tạo file `model/db_config.php`:

```php
<?php
// Database configuration
if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {
    // Localhost
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'HPship');
} else {
    // Production Host
    define('DB_HOST', 'localhost'); // Từ hosting provider
    define('DB_USER', 'your_username'); // Từ hosting provider
    define('DB_PASS', 'your_password'); // Từ hosting provider
    define('DB_NAME', 'your_database'); // Từ hosting provider
}
?>
```

Sau đó trong `connect1.php`, `connect2.php`, `connect3.php`:

```php
<?php
require_once('db_config.php');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
?>
```

**Lợi ích:** Chỉ cần cập nhật một file duy nhất khi thay đổi thông tin database!

### Mẹo 2: Test kết nối trước khi deploy

Trước khi upload, test kết nối database với thông tin từ hosting:

```php
<?php
// test_db_connection.php
$host = "your_host"; // Từ hosting
$user = "your_user"; // Từ hosting
$pass = "your_pass"; // Từ hosting
$db = "your_dbname"; // Từ hosting

$conn = @new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo "❌ Lỗi: " . $conn->connect_error;
} else {
    echo "✓ Kết nối thành công!";
    $conn->close();
}
?>
```

Upload file này lên host và test trước khi cập nhật các file chính.

**QUAN TRỌNG:** Xóa file test sau khi xong!

## 📋 CHECKLIST

- [ ] Đã tạo database trên host
- [ ] Đã tạo user và gán quyền ALL PRIVILEGES
- [ ] Đã import file SQL
- [ ] Đã lấy thông tin: host, username, password, database name
- [ ] Đã cập nhật `model/connect1.php`
- [ ] Đã cập nhật `model/connect2.php`
- [ ] Đã cập nhật `model/connect3.php`
- [ ] Đã test bằng `test_environment.php`
- [ ] Database connection hiển thị "✓ Kết nối thành công"
- [ ] Đã xóa file test (nếu có)

## 🆘 NẾU VẪN GẶP VẤN ĐỀ

1. **Kiểm tra lại thông tin từ hosting provider**
   - Đăng nhập cPanel → MySQL Databases
   - Verify username, password, database name

2. **Kiểm tra user có quyền truy cập database không**
   - Trong cPanel → MySQL Databases → Current Databases
   - Đảm bảo user đã được gán vào database

3. **Thử các host khác nhau**
   ```php
   // Thử lần lượt:
   "localhost"
   "127.0.0.1"
   "localhost:3306"
   "127.0.0.1:3306"
   // Hoặc IP cụ thể từ hosting
   ```

4. **Liên hệ hosting support**
   - Hỏi về thông tin kết nối MySQL chính xác
   - Hỏi về remote MySQL access (nếu cần)

5. **Kiểm tra error log**
   - Trong cPanel → Error Log
   - Xem log chi tiết về lỗi database

## 📞 HỖ TRỢ

Nếu sau khi làm theo hướng dẫn mà vẫn gặp lỗi:

1. Chụp màn hình lỗi từ `test_environment.php`
2. Kiểm tra error code cụ thể
3. Tham khảo phần "Các lỗi thường gặp" ở trên
4. Liên hệ hosting provider để được hỗ trợ

---

**Lưu ý cuối:** KHÔNG bao giờ commit file chứa thông tin database (username, password) lên Git public repository!
