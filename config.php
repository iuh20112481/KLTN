<?php
/**
 * Configuration File - Auto-detect environment
 * Tự động phát hiện môi trường (localhost hoặc host)
 */

// Phát hiện môi trường
$isLocalhost = in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1', 'localhost:8080']);

// Lấy protocol (http hoặc https)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

// Lấy host hiện tại
$host = $_SERVER['HTTP_HOST'];

// Xác định base path
if ($isLocalhost) {
    // Localhost: giữ nguyên /WEBSITE_EXHIBITION/
    $basePath = '/WEBSITE_EXHIBITION/';
} else {
    // Host: kiểm tra xem có thư mục WEBSITE_EXHIBITION không
    $requestUri = $_SERVER['REQUEST_URI'];
    if (strpos($requestUri, '/WEBSITE_EXHIBITION/') !== false) {
        $basePath = '/WEBSITE_EXHIBITION/';
    } else {
        // Nếu deploy ở root thì để trống
        $basePath = '/';
    }
}

// Define các constant
define('BASE_URL', $protocol . $host . $basePath);
define('API_BASE_URL', BASE_URL . 'API/');
define('VIEW_PATH', BASE_URL . 'view/');
define('CSS_PATH', BASE_URL . 'css/');
define('JS_PATH', BASE_URL . 'js/');
define('IMG_PATH', BASE_URL . 'img/');

// Constant cho server paths (dùng cho include)
define('BASE_PATH', dirname(__FILE__) . '/');
define('VIEW_DIR', BASE_PATH . 'view/');
define('CONTROL_DIR', BASE_PATH . 'control/');
define('MODEL_DIR', BASE_PATH . 'model/');

// Database Configuration - Auto-detect environment
if ($isLocalhost) {
    // Localhost configuration
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'HPship');
} else {
    // InfinityFree hosting configuration
    define('DB_HOST', 'sql209.infinityfree.com');
    define('DB_USER', 'if0_40664313');
    define('DB_PASS', '0903366032Aa');
    define('DB_NAME', 'if0_40664313_hpship');
}
define('DB_PORT', '3306');

/**
 * Helper function to create PDO connection
 * @return PDO
 */
function getPDOConnection() {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
            DB_USER,
            DB_PASS
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Lỗi kết nối PDO: " . $e->getMessage());
    }
}
