<?php
class connect_db {
    public static function open_kn() {
        $conn = mysqli_connect("localhost", "root", "", "HPship");
        mysqli_set_charset($conn, "utf8");
        
        if ($conn) {
            return $conn; // Trả về kết nối thay vì true
        } else {
            die("Lỗi kết nối: " . mysqli_connect_error()); // Thông báo lỗi kết nối cụ thể
        }
    }

    public static function close_kn($conn) {
        mysqli_close($conn);
    }
}
?>
