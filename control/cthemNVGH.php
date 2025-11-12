<?php
require_once '../model/mthemNVGH.php'; 

// Kết nối cơ sở dữ liệu
$dsn = 'mysql:host=localhost;dbname=HPship;charset=utf8';
$username = 'root';
$password = '';
$dbConnection = new PDO($dsn, $username, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

// Tạo model để xử lý logic
$userModel = new UserModel($dbConnection);

// Kiểm tra nếu form được gửi bằng phương thức POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

        // Điều hướng đến trang thành công
        header("Location: success.php?employeeId=" . $newEmployeeId);
        exit;
    } catch (Exception $e) {
        // Nếu có lỗi, điều hướng đến trang lỗi
        header("Location: error.php?error=" . urlencode($e->getMessage()));
        exit;
    }
}
