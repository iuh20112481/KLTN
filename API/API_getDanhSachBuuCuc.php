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

// Truy vấn lấy danh sách bưu cục
$sql = "SELECT DISTINCT tenbc.maBuuCuc, tenbc.tenBuuCuc, tenbc.diaChiBC
        FROM tenbc
        ORDER BY tenbc.tenBuuCuc ASC";

$result = mysqli_query($link, $sql);

if (!$result) {
    echo json_encode(array('success' => false, 'message' => 'Query error: ' . mysqli_error($link)));
    exit();
}

$buuCucList = array();

while ($row = mysqli_fetch_assoc($result)) {
    $buuCucList[] = array(
        'maBuuCuc' => $row['maBuuCuc'],
        'tenBuuCuc' => $row['tenBuuCuc'],
        'diaChiBC' => $row['diaChiBC']
    );
}

// Trả về dữ liệu dưới dạng JSON
header('Content-Type: application/json; charset=utf-8');
echo json_encode(array('success' => true, 'data' => $buuCucList));

// Đóng kết nối CSDL
mysqli_close($link);
?>
