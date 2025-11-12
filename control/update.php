// update_donhang.php
<?php
include_once "../model/connect1.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Id_TaoDonHang"])) {
    $Id_TaoDonHang = $_POST["Id_TaoDonHang"];
    
    // Kết nối đến cơ sở dữ liệu
    $connect_db = new connect_db();
    $conn = $connect_db->open_kn();

    if ($conn) {
        $sql = "INSERT INTO donhang (Id_TaoDonHang, Id_TaiKhoan, maBuuCuc) 
                VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        // Giả sử bạn có thể lấy Id_TaiKhoan và maBuuCuc từ người dùng hoặc một nguồn dữ liệu khác
        $Id_TaiKhoan = 1; // Thay bằng giá trị thích hợp
        $maBuuCuc = 'ABC'; // Thay bằng giá trị thích hợp

        mysqli_stmt_bind_param($stmt, "iis", $Id_TaoDonHang, $Id_TaiKhoan, $maBuuCuc);
        $success = mysqli_stmt_execute($stmt);

        if ($success) {
            echo "Cập nhật đơn hàng thành công.";
        } else {
            echo "Lỗi: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
        $connect_db->close_kn($conn);
    } else {
        echo "Kết nối đến cơ sở dữ liệu thất bại.";
    }
}
?>
