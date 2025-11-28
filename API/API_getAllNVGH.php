<?php
// Thông tin kết nối CSDL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "HPship";

// Kết nối CSDL
$link = mysqli_connect($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if (!$link) {
    die("Kết nối CSDL thất bại: " . mysqli_connect_error());
}

// Set charset UTF-8
mysqli_set_charset($link, "utf8");

// Truy vấn lấy tất cả nhân viên giao hàng
$sql = "SELECT tk.Id_TaiKhoan, tk.tenND, tk.sdtND, plnd.loaiNguoiDung, tk.emailND, bc.maNhanVien, bc.maBuuCuc
        FROM taikhoan tk
        JOIN phanloainguoidung plnd ON tk.Id_TaiKhoan = plnd.Id_TaiKhoan
        JOIN buucuc bc ON tk.Id_TaiKhoan = bc.Id_TaiKhoan
        WHERE plnd.loaiNguoiDung = 'Nhân viên giao hàng'
        ORDER BY bc.maBuuCuc, bc.maNhanVien";

$result = mysqli_query($link, $sql);

if (!$result) {
    echo json_encode(array('success' => false, 'message' => 'Query error: ' . mysqli_error($link)));
    exit();
}

$nvghList = array();

while ($row = mysqli_fetch_assoc($result)) {
    $nvghList[] = $row;
}

// Trả về dữ liệu dưới dạng JSON
header('Content-Type: application/json; charset=utf-8');
echo json_encode($nvghList);

// Đóng kết nối CSDL
mysqli_close($link);
?>
