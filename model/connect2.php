<?php
// Load config file
if (!defined('DB_HOST')) {
    require_once(dirname(__DIR__) . '/config.php');
}

class connect_db {
    function open_kn() {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        mysqli_set_charset($conn, "utf8");

        if (!$conn) {
            die("Lỗi kết nối: " . mysqli_connect_error());
        }

        return $conn;
    }

    function close_kn($conn) {
        mysqli_close($conn);
    }
}
?>