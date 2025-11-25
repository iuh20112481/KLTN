<?php
require_once '../model/mthemNVGH.php'; 

// Kết nối cơ sở dữ liệu
$dsn = 'mysql:host=localhost;dbname=HPship;charset=utf8';
$db_username = 'root';
$db_password = '';
$dbConnection = new PDO($dsn, $db_username, $db_password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

// Tạo model để xử lý logic
$userModel = new UserModel($dbConnection);

// Kiểm tra nếu form được gửi bằng phương thức POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');

    $username = $_POST['tennv'];
    $pass = $_POST['pass'];
    $email = $_POST['email'];
    $sdt = $_POST['sdt'];
    $Id_TenBC = $_POST['Id_TenBC'];
    $manhanvien = $_POST['manhanvien'];
    $ngaysinh = $_POST['ngaysinh'];
    $gioitinh = $_POST['gioitinh'];
    $mabuucuc = $_POST['maBuuCuc'];

    try {
        // Tạo nhân viên mới
        $newEmployeeId = $userModel->createUser($username, $pass, $email, $sdt, $Id_TenBC, $manhanvien, $ngaysinh, $gioitinh, $mabuucuc);

        // Trả về JSON thành công
        echo json_encode([
            'success' => true,
            'message' => 'Thêm nhân viên giao hàng thành công! Mã nhân viên: ' . $manhanvien
        ]);
        exit;
    } catch (Exception $e) {
        // Trả về JSON lỗi
        echo json_encode([
            'success' => false,
            'message' => 'Lỗi: ' . $e->getMessage()
        ]);
        exit;
    }
}
