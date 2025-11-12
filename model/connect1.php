<?php
class connect_db {
    function open_kn() {
        $conn = mysqli_connect("localhost", "root", "", "HPship");
        mysqli_set_charset($conn, "utf8");
        
        if ($conn) {
            return $conn; // Trả về kết nối thay vì true
        } else {
            die("Lỗi kết nối: " . mysqli_connect_error()); 
        }
    }

    function close_kn($conn) { // Không cần thiết tham chiếu ở đây
        mysqli_close($conn);
    }

    public static function open_kn1() {
        $conn = mysqli_connect("localhost", "root", "", "HPship");
        mysqli_set_charset($conn, "utf8");
        
        if ($conn) {
            return $conn; // Trả về kết nối thay vì true
        } else {
            die("Lỗi kết nối: " . mysqli_connect_error()); // Thông báo lỗi kết nối cụ thể
        }
    }

    public static function close_kn1($conn) {
        mysqli_close($conn);
    }
}
?>
