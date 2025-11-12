<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "HPship"; 

// Tạo kết nối đến cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra xem yêu cầu POST đã được gửi chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ yêu cầu POST
    $Id_TaoDonHang = $_POST['Id_TaoDonHang'];
    $idNguoiDung = $_POST['idNguoiDung'];

    // Tiến hành thêm dữ liệu vào cơ sở dữ liệu
    $sql = "INSERT INTO donhang (Id_TaoDonHang, Id_PhanLoaiNguoiDung) VALUES ('$Id_TaoDonHang', '$idNguoiDung')";

    if ($conn->query($sql) === TRUE) {
        echo "Thông tin đơn hàng đã được lưu thành công.";
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

// Đóng kết nối
$conn->close();
?>