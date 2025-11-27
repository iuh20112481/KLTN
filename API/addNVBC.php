<?php
header('Content-Type: application/json; charset=utf-8');

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is admin
if (!isset($_SESSION['admin'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Bạn không có quyền thực hiện chức năng này'
    ]);
    exit();
}

// Include model
include_once("../model/mtaikhoan.php");

// Check if POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
    exit();
}

// Get POST data
$data = [
    'tenND' => $_POST['tenND'] ?? '',
    'sdtND' => $_POST['sdtND'] ?? '',
    'emailND' => $_POST['emailND'] ?? '',
    'mkND' => $_POST['mkND'] ?? '',
    'gioiTinh' => $_POST['gioiTinh'] ?? 'Nam',
    'ngaySinh' => $_POST['ngaySinh'] ?? '',
    'maNhanVien' => $_POST['maNhanVien'] ?? '',
    'maBuuCuc' => $_POST['maBuuCuc'] ?? ''
];

// Validate required fields
if (empty($data['tenND']) || empty($data['sdtND']) || empty($data['emailND']) ||
    empty($data['mkND']) || empty($data['maNhanVien']) || empty($data['maBuuCuc'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Vui lòng điền đầy đủ thông tin bắt buộc'
    ]);
    exit();
}

// Create model instance and add NVBC
$model = new model_tk();
$result = $model->addNVBC($data);

// Return result
echo json_encode($result);
?>
