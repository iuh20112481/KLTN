<?php
// Kết nối đến cơ sở dữ liệu
$db = new mysqli('localhost', 'root', '', 'HPship');

// Kiểm tra kết nối
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Truy vấn cơ sở dữ liệu để lấy các thông báo chưa đọc
$sql = "SELECT * FROM `notifications` WHERE `read` = '0';";
$result = $db->query($sql);

// Tạo một mảng để lưu các thông báo
$notifications = array();

// Lấy dữ liệu từ kết quả truy vấn
while($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

// Đóng kết nối đến cơ sở dữ liệu
$db->close();

// Trả về dữ liệu dưới dạng JSON
echo json_encode($notifications);