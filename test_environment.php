<?php
/**
 * File kiểm tra môi trường - TEST ENVIRONMENT
 *
 * HƯỚNG DẪN SỬ DỤNG:
 * 1. Truy cập file này qua trình duyệt: http://yourdomain.com/WEBSITE_EXHIBITION/test_environment.php
 * 2. Kiểm tra các thông tin hiển thị
 * 3. SAU KHI KIỂM TRA XONG, XÓA FILE NÀY ĐỂ BẢO MẬT!
 */

// Include config
require_once('config.php');

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HPship - Kiểm tra môi trường</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 3px solid #007bff;
            padding-bottom: 10px;
        }
        h2 {
            color: #555;
            margin-top: 30px;
            border-left: 4px solid #007bff;
            padding-left: 10px;
        }
        .success {
            color: #28a745;
            font-weight: bold;
        }
        .error {
            color: #dc3545;
            font-weight: bold;
        }
        .warning {
            color: #ffc107;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .info-box {
            background: #e7f3ff;
            padding: 15px;
            border-left: 4px solid #007bff;
            margin: 20px 0;
        }
        .warning-box {
            background: #fff3cd;
            padding: 15px;
            border-left: 4px solid #ffc107;
            margin: 20px 0;
        }
        .test-link {
            display: inline-block;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 5px;
        }
        .test-link:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 HPship - Kiểm tra môi trường</h1>

        <div class="warning-box">
            <strong>⚠️ CẢNH BÁO BẢO MẬT:</strong> Sau khi kiểm tra xong, hãy XÓA file này để bảo mật!
        </div>

        <h2>1. Thông tin môi trường</h2>
        <table>
            <tr>
                <th>Thông số</th>
                <th>Giá trị</th>
                <th>Trạng thái</th>
            </tr>
            <tr>
                <td>Domain hiện tại</td>
                <td><?php echo $_SERVER['HTTP_HOST']; ?></td>
                <td><span class="success">✓</span></td>
            </tr>
            <tr>
                <td>Protocol</td>
                <td><?php echo (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'HTTPS' : 'HTTP'; ?></td>
                <td>
                    <?php
                    if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
                        echo '<span class="success">✓ Bảo mật</span>';
                    } else {
                        echo '<span class="warning">⚠ Không bảo mật (HTTP)</span>';
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>Môi trường</td>
                <td><?php echo in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1', 'localhost:8080']) ? 'Localhost' : 'Production Host'; ?></td>
                <td><span class="success">✓</span></td>
            </tr>
            <tr>
                <td>Request URI</td>
                <td><?php echo $_SERVER['REQUEST_URI']; ?></td>
                <td><span class="success">✓</span></td>
            </tr>
        </table>

        <h2>2. Cấu hình đường dẫn (config.php)</h2>
        <table>
            <tr>
                <th>Constant</th>
                <th>Giá trị</th>
            </tr>
            <tr>
                <td>BASE_URL</td>
                <td><code><?php echo BASE_URL; ?></code></td>
            </tr>
            <tr>
                <td>API_BASE_URL</td>
                <td><code><?php echo API_BASE_URL; ?></code></td>
            </tr>
            <tr>
                <td>VIEW_PATH</td>
                <td><code><?php echo VIEW_PATH; ?></code></td>
            </tr>
            <tr>
                <td>CSS_PATH</td>
                <td><code><?php echo CSS_PATH; ?></code></td>
            </tr>
            <tr>
                <td>JS_PATH</td>
                <td><code><?php echo JS_PATH; ?></code></td>
            </tr>
            <tr>
                <td>IMG_PATH</td>
                <td><code><?php echo IMG_PATH; ?></code></td>
            </tr>
        </table>

        <h2>3. Kiểm tra PHP</h2>
        <table>
            <tr>
                <th>Thông số</th>
                <th>Giá trị</th>
                <th>Trạng thái</th>
            </tr>
            <tr>
                <td>Phiên bản PHP</td>
                <td><?php echo phpversion(); ?></td>
                <td>
                    <?php
                    if (version_compare(phpversion(), '7.0', '>=')) {
                        echo '<span class="success">✓ Đạt yêu cầu</span>';
                    } else {
                        echo '<span class="error">✗ Cần PHP >= 7.0</span>';
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>MySQLi Extension</td>
                <td><?php echo extension_loaded('mysqli') ? 'Đã cài' : 'Chưa cài'; ?></td>
                <td>
                    <?php
                    if (extension_loaded('mysqli')) {
                        echo '<span class="success">✓</span>';
                    } else {
                        echo '<span class="error">✗ Cần cài MySQLi</span>';
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>PDO Extension</td>
                <td><?php echo extension_loaded('pdo') ? 'Đã cài' : 'Chưa cài'; ?></td>
                <td>
                    <?php
                    if (extension_loaded('pdo')) {
                        echo '<span class="success">✓</span>';
                    } else {
                        echo '<span class="error">✗ Cần cài PDO</span>';
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td>mbstring Extension</td>
                <td><?php echo extension_loaded('mbstring') ? 'Đã cài' : 'Chưa cài'; ?></td>
                <td>
                    <?php
                    if (extension_loaded('mbstring')) {
                        echo '<span class="success">✓</span>';
                    } else {
                        echo '<span class="warning">⚠ Nên cài mbstring</span>';
                    }
                    ?>
                </td>
            </tr>
        </table>

        <h2>4. Kiểm tra thư mục</h2>
        <table>
            <tr>
                <th>Thư mục</th>
                <th>Trạng thái</th>
            </tr>
            <?php
            $directories = ['view', 'control', 'model', 'API', 'css', 'js', 'img'];
            foreach ($directories as $dir) {
                $exists = is_dir($dir);
                echo '<tr>';
                echo '<td>' . $dir . '/</td>';
                echo '<td>';
                if ($exists) {
                    echo '<span class="success">✓ Tồn tại</span>';
                } else {
                    echo '<span class="error">✗ Không tìm thấy</span>';
                }
                echo '</td>';
                echo '</tr>';
            }
            ?>
        </table>

        <h2>5. Kiểm tra file quan trọng</h2>
        <table>
            <tr>
                <th>File</th>
                <th>Trạng thái</th>
            </tr>
            <?php
            $files = [
                'index.php',
                'config.php',
                '.htaccess',
                'view/dangNhap.php',
                'view/dangKy.php',
                'model/connect1.php'
            ];
            foreach ($files as $file) {
                $exists = file_exists($file);
                echo '<tr>';
                echo '<td>' . $file . '</td>';
                echo '<td>';
                if ($exists) {
                    echo '<span class="success">✓ Tồn tại</span>';
                } else {
                    echo '<span class="error">✗ Không tìm thấy</span>';
                }
                echo '</td>';
                echo '</tr>';
            }
            ?>
        </table>

        <h2>6. Test các đường dẫn</h2>
        <div class="info-box">
            <p>Click vào các link dưới đây để kiểm tra xem đường dẫn có hoạt động đúng không:</p>
        </div>

        <p>
            <a href="<?php echo BASE_URL; ?>" class="test-link" target="_blank">Trang chủ</a>
            <a href="<?php echo VIEW_PATH; ?>dangNhap.php" class="test-link" target="_blank">Đăng nhập</a>
            <a href="<?php echo VIEW_PATH; ?>dangKy.php" class="test-link" target="_blank">Đăng ký</a>
            <a href="<?php echo BASE_URL; ?>?page=atkbc" class="test-link" target="_blank">Tìm kiếm bưu cục</a>
        </p>

        <h2>7. Kiểm tra kết nối Database</h2>
        <?php
        // Test database connection
        $db_host = 'localhost';
        $db_user = 'root';
        $db_pass = '';
        $db_name = 'HPship';

        echo '<table>';
        echo '<tr><th>Thông số</th><th>Giá trị</th></tr>';
        echo '<tr><td>Host</td><td>' . $db_host . '</td></tr>';
        echo '<tr><td>Database</td><td>' . $db_name . '</td></tr>';
        echo '<tr><td>User</td><td>' . $db_user . '</td></tr>';
        echo '</table>';

        try {
            $conn = @new mysqli($db_host, $db_user, $db_pass, $db_name);
            if ($conn->connect_error) {
                echo '<div class="warning-box">';
                echo '<strong>⚠️ Lỗi kết nối Database:</strong><br>';
                echo 'Error Code: ' . $conn->connect_errno . '<br>';
                echo 'Error: ' . $conn->connect_error;
                echo '<br><br><strong>Giải pháp:</strong>';
                echo '<ul>';

                if ($conn->connect_errno == 2002) {
                    echo '<li><strong>Lỗi "No such file or directory"</strong> - Đây là lỗi socket MySQL</li>';
                    echo '<li>Trên host, cần kiểm tra với hosting provider về thông tin kết nối database</li>';
                    echo '<li>Host có thể là: localhost, 127.0.0.1, hoặc IP cụ thể của database server</li>';
                    echo '<li>Có thể cần thêm port: localhost:3306</li>';
                } else if ($conn->connect_errno == 1045) {
                    echo '<li><strong>Access denied</strong> - Sai username hoặc password</li>';
                    echo '<li>Kiểm tra lại thông tin database từ hosting provider</li>';
                } else if ($conn->connect_errno == 1049) {
                    echo '<li><strong>Unknown database</strong> - Database chưa được tạo</li>';
                    echo '<li>Tạo database "HPship" trong cPanel hoặc phpMyAdmin</li>';
                    echo '<li>Import file SQL vào database</li>';
                }

                echo '<li>Cập nhật thông tin trong các file: model/connect1.php, model/connect2.php, model/connect3.php</li>';
                echo '<li><strong>QUAN TRỌNG:</strong> Thông tin database trên host KHÁC với localhost!</li>';
                echo '</ul>';
                echo '<div style="background: #fff; padding: 10px; border-left: 3px solid #dc3545; margin-top: 10px;">';
                echo '<strong>Ví dụ cập nhật file connect*.php trên host:</strong><br>';
                echo '<code style="display: block; background: #f4f4f4; padding: 10px; margin-top: 5px;">';
                echo '// Thay đổi từ:<br>';
                echo '$conn = new mysqli("localhost", "root", "", "HPship");<br><br>';
                echo '// Thành (lấy thông tin từ hosting provider):<br>';
                echo '$conn = new mysqli("localhost", "your_db_user", "your_db_pass", "your_db_name");<br>';
                echo '// Hoặc có thể là:<br>';
                echo '$conn = new mysqli("127.0.0.1", "your_db_user", "your_db_pass", "your_db_name");<br>';
                echo '</code>';
                echo '</div>';
                echo '</div>';
            } else {
                echo '<div class="info-box">';
                echo '<strong>✓ Kết nối Database thành công!</strong><br>';
                echo 'Charset: ' . $conn->character_set_name();
                echo '</div>';
                $conn->close();
            }
        } catch (Exception $e) {
            echo '<div class="warning-box">';
            echo '<strong>⚠️ Không thể kết nối Database:</strong><br>';
            echo $e->getMessage();
            echo '<br><br><strong>Giải pháp:</strong> Kiểm tra thông tin database từ hosting provider và cập nhật trong file model/connect*.php';
            echo '</div>';
        }
        ?>

        <h2>8. Thông tin Apache/Server</h2>
        <table>
            <tr>
                <th>Thông số</th>
                <th>Giá trị</th>
            </tr>
            <tr>
                <td>Server Software</td>
                <td><?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'N/A'; ?></td>
            </tr>
            <tr>
                <td>Document Root</td>
                <td><?php echo $_SERVER['DOCUMENT_ROOT'] ?? 'N/A'; ?></td>
            </tr>
            <tr>
                <td>Script Filename</td>
                <td><?php echo $_SERVER['SCRIPT_FILENAME'] ?? 'N/A'; ?></td>
            </tr>
        </table>

        <div class="warning-box">
            <h3>⚠️ LƯU Ý QUAN TRỌNG</h3>
            <ul>
                <li><strong>XÓA FILE NÀY SAU KHI KIỂM TRA XONG!</strong></li>
                <li>File này chứa thông tin nhạy cảm về hệ thống</li>
                <li>Không để file này trên server production</li>
                <li>Để xóa: Vào file manager hoặc FTP và xóa file <code>test_environment.php</code></li>
            </ul>
        </div>

        <div style="text-align: center; margin-top: 30px; padding: 20px; background: #f8f9fa; border-radius: 5px;">
            <p style="margin: 0; color: #666;">
                <strong>HPship Deployment Test</strong><br>
                Tạo bởi Claude Code - <?php echo date('Y-m-d H:i:s'); ?>
            </p>
        </div>
    </div>
</body>
</html>
