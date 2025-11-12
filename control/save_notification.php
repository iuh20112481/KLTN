<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION["nvbc"]['id_user'])) {
    header('Location: ../view/dangNhap.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $user_id = $_POST['user_id'];

    // Kết nối đến cơ sở dữ liệu
    $conn = new mysqli('localhost', 'root', '', 'HPship');

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Truy vấn SQL để lấy madonhang từ bảng taodonhang
    $sql_select = "SELECT madonhang FROM taodonhang WHERE Id_TaoDonHang = $id";
    $result = $conn->query($sql_select);

    if ($result->num_rows > 0) {
        // Lấy kết quả truy vấn
        $row = $result->fetch_assoc();
        $madonhang = $row['madonhang'];

        // Truy vấn SQL để lưu thông báo
        $sql_insert = "INSERT INTO `notifications` (`id`, `user_id`, `message`, `read`) 
                       VALUES ($id, $user_id, 'Đơn hàng số " . $madonhang . " được chấp nhận', 0);";

        // Thực thi truy vấn
        if ($conn->query($sql_insert) === TRUE) {
            echo "Notification saved successfully";
        } else {
            echo "Error: " . $sql_insert . "<br>" . $conn->error;
        }
    } else {
        echo "No order found with id: " . $id;
    }

    // Đóng kết nối
    $conn->close();
}
?>
