<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['nguoidung']['id_user'])) {
    header('Location: ../view/dangNhap.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Kết nối đến cơ sở dữ liệu
    $conn = new mysqli('localhost', 'root', '', 'HPship');

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Truy vấn SQL để xóa thông báo
    $sql = "DELETE FROM `notifications` WHERE `id` = $id";

    // Thực thi truy vấn
    if ($conn->query($sql) === TRUE) {
        echo 'success';
    } else {
        echo 'error';
    }

    // Đóng kết nối
    $conn->close();
} else {
    echo 'invalid';
}
?>
