<?php
// Kết nối với cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "HPship";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu từ form
$ho_ten = $_POST['ho_ten'];
$dia_chi = $_POST['dia_chi'];
$so_dien_thoai = $_POST['so_dien_thoai'];
$so_tai_khoan = $_POST['so_tai_khoan'];
$ngan_hang = $_POST['ngan_hang'];
$ten_don_hang = $_POST['ten_don_hang'];
$ma_van_don = $_POST['ma_van_don'];
$ma_don_hang = $_POST['ma_don_hang'];
$ngay_giao_dich = $_POST['ngay_giao_dich'];
$thoi_gian_giao_dich = $_POST['thoi_gian_giao_dich'];
$noi_dung_ghi_chu = $_POST['noi_dung_ghi_chu'];
$so_tien = $_POST['so_tien'];
$Id_TaiKhoan = $_POST['Id_TaiKhoan'];

// Câu lệnh insert
$sql = "INSERT INTO giaodich (ho_ten, dia_chi, so_dien_thoai, so_tai_khoan, ngan_hang, ten_don_hang, ma_van_don, ma_don_hang, ngay_giao_dich, thoi_gian_giao_dich, noi_dung_ghi_chu, so_tien, Id_TaiKhoan) VALUES ('$ho_ten', '$dia_chi', '$so_dien_thoai', '$so_tai_khoan', '$ngan_hang', '$ten_don_hang', '$ma_van_don', '$ma_don_hang', '$ngay_giao_dich', '$thoi_gian_giao_dich', '$noi_dung_ghi_chu', '$so_tien', '$Id_TaiKhoan')";

// Thực thi câu lệnh
if ($conn->query($sql) === TRUE) {
    echo "Giao dịch đã được lưu thành công.";
} else {
    echo "Lỗi: " . $conn->error;
}

// Đóng kết nối
$conn->close();
?>
