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

// Lấy mã bưu cục từ request
$maBuuCuc = $_GET['maBuuCuc'] ?? null;

if (!$maBuuCuc) {
    echo json_encode(array('success' => false, 'message' => 'Thiếu mã bưu cục'));
    exit();
}

// Truy vấn lấy nhân viên giao hàng theo bưu cục
$sql = "SELECT tk.Id_TaiKhoan, tk.tenND, tk.sdtND, plnd.loaiNguoiDung, tk.emailND, bc.maNhanVien, bc.maBuuCuc
        FROM taikhoan tk
        JOIN phanloainguoidung plnd ON tk.Id_TaiKhoan = plnd.Id_TaiKhoan
        JOIN buucuc bc ON tk.Id_TaiKhoan = bc.Id_TaiKhoan
        WHERE plnd.loaiNguoiDung = 'Nhân viên giao hàng' AND bc.maBuuCuc = ?
        ORDER BY bc.maNhanVien";

$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "s", $maBuuCuc);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$nvghList = array();

while ($row = mysqli_fetch_assoc($result)) {
    $nvghList[] = $row;
}

// Trả về dữ liệu dưới dạng JSON
header('Content-Type: application/json; charset=utf-8');
echo json_encode($nvghList);

// Đóng kết nối CSDL
mysqli_stmt_close($stmt);
mysqli_close($link);
?>
