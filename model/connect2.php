<?php
class connect_db {
    function open_kn() {
        $conn = mysqli_connect("localhost", "root", "", "HPship");
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