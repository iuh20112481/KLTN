<?php
header('Content-Type: application/json; charset=utf-8');

// Kết nối database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "HPship";

$conn = mysqli_connect($servername, $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");

if (!$conn) {
    echo json_encode(array('success' => false, 'message' => 'Kết nối database thất bại'));
    exit();
}

// Lấy mã nhân viên từ request
$maNhanVien = $_GET['maNhanVien'] ?? '';

if (empty($maNhanVien)) {
    echo json_encode(array('success' => false, 'message' => 'Thiếu mã nhân viên'));
    exit();
}

// Query lấy thông tin hoa hồng (theo phần trăm)
$query = "SELECT
            COUNT(donhang.Id_DonHang) as soDonDaGiao,
            SUM(donhang.hoaHongShipper) as tongHoaHong,
            buucuc.hoaHongMoiDon as tyLeHoaHongHienTai
        FROM donhang
        INNER JOIN buucuc ON donhang.maNhanVien = buucuc.maNhanVien
        WHERE donhang.maNhanVien = ?
        AND donhang.trangThaiDonHang = 'Đã giao'
        GROUP BY buucuc.hoaHongMoiDon";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $maNhanVien);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$data = array(
    'soDonDaGiao' => 0,
    'tongHoaHong' => 0,
    'tyLeHoaHongHienTai' => 0
);

if ($row = mysqli_fetch_assoc($result)) {
    $data = array(
        'soDonDaGiao' => (int)$row['soDonDaGiao'],
        'tongHoaHong' => (float)$row['tongHoaHong'],
        'tyLeHoaHongHienTai' => (float)$row['tyLeHoaHongHienTai']
    );
}

mysqli_stmt_close($stmt);

// Lấy chi tiết các đơn đã giao (bao gồm tỷ lệ % và hoa hồng thực tế)
$queryChiTiet = "SELECT
                    donhang.Id_DonHang,
                    donhang.maVanDon,
                    taodonhang.tenDonHang,
                    taodonhang.giaVanChuyen,
                    donhang.ngayHTGiaoHang,
                    donhang.tyLeHoaHong,
                    donhang.hoaHongShipper
                FROM donhang
                INNER JOIN taodonhang ON donhang.Id_TaoDonHang = taodonhang.Id_TaoDonHang
                INNER JOIN buucuc ON donhang.maNhanVien = buucuc.maNhanVien
                WHERE donhang.maNhanVien = ?
                AND donhang.trangThaiDonHang = 'Đã giao'
                ORDER BY donhang.ngayHTGiaoHang DESC
                LIMIT 100";

$stmtChiTiet = mysqli_prepare($conn, $queryChiTiet);
mysqli_stmt_bind_param($stmtChiTiet, "s", $maNhanVien);
mysqli_stmt_execute($stmtChiTiet);
$resultChiTiet = mysqli_stmt_get_result($stmtChiTiet);

$chiTietDonHang = array();
while ($row = mysqli_fetch_assoc($resultChiTiet)) {
    $chiTietDonHang[] = $row;
}

mysqli_stmt_close($stmtChiTiet);

// Lấy thống kê theo tháng hiện tại
$thangHienTai = date('m');
$namHienTai = date('Y');

$queryThang = "SELECT
                COUNT(donhang.Id_DonHang) as soDonThang,
                SUM(donhang.hoaHongShipper) as tongHoaHongThang
            FROM donhang
            INNER JOIN buucuc ON donhang.maNhanVien = buucuc.maNhanVien
            WHERE donhang.maNhanVien = ?
            AND donhang.trangThaiDonHang = 'Đã giao'
            AND MONTH(STR_TO_DATE(donhang.ngayHTGiaoHang, '%d-%m-%Y')) = ?
            AND YEAR(STR_TO_DATE(donhang.ngayHTGiaoHang, '%d-%m-%Y')) = ?";

$stmtThang = mysqli_prepare($conn, $queryThang);
mysqli_stmt_bind_param($stmtThang, "sii", $maNhanVien, $thangHienTai, $namHienTai);
mysqli_stmt_execute($stmtThang);
$resultThang = mysqli_stmt_get_result($stmtThang);

$dataThang = array(
    'soDonThang' => 0,
    'tongHoaHongThang' => 0
);

if ($rowThang = mysqli_fetch_assoc($resultThang)) {
    $dataThang = array(
        'soDonThang' => (int)$rowThang['soDonThang'],
        'tongHoaHongThang' => (float)$rowThang['tongHoaHongThang']
    );
}

mysqli_stmt_close($stmtThang);
mysqli_close($conn);

// Trả về dữ liệu
$response = array(
    'success' => true,
    'tongQuat' => $data,
    'thangNay' => $dataThang,
    'chiTietDonHang' => $chiTietDonHang
);

echo json_encode($response, JSON_UNESCAPED_UNICODE);
?>
