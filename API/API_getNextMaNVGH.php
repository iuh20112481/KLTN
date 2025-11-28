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

// Lấy mã NVGH cuối cùng của bưu cục này
$sql = "SELECT maNhanVien FROM buucuc
        WHERE maBuuCuc = ? AND maNhanVien LIKE 'NVGH-%'
        ORDER BY maNhanVien DESC LIMIT 1";

$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "s", $maBuuCuc);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$nextNumber = 1;
if ($row = mysqli_fetch_assoc($result)) {
    $lastMa = $row['maNhanVien'];
    // Lấy số cuối cùng từ mã (format: NVGH-<maBuuCuc>-xxx)
    preg_match('/-(\d+)$/', $lastMa, $matches);
    if (isset($matches[1])) {
        $nextNumber = intval($matches[1]) + 1;
    }
}

// Tạo mã NVGH mới
$newMaNVGH = sprintf('NVGH-%s-%03d', $maBuuCuc, $nextNumber);

// Trả về dữ liệu
header('Content-Type: application/json; charset=utf-8');
echo json_encode(array(
    'success' => true,
    'maNVGH' => $newMaNVGH
));

// Đóng kết nối CSDL
mysqli_stmt_close($stmt);
mysqli_close($link);
?>
