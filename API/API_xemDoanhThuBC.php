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

// Hàm lấy thông tin doanh thu theo trạng thái đơn hàng
function getDoanhThuByStatus($maBuuCuc, $status, $link) {
    // Truy vấn SQL
    $sql = "SELECT 
                COUNT(taodonhang.giaVanChuyen) AS soLuong,
                SUM(taodonhang.giaVanChuyen) AS tongGiaVanChuyen,
                GROUP_CONCAT(CONCAT_WS('|', taodonhang.Id_TaoDonHang, 
                                            taodonhang.maDonHang, 
                                            taodonhang.tenDonHang,
                                            taodonhang.tenNG,
                                            taodonhang.tenNN,
                                            taodonhang.ngayLapDon,
                                            taodonhang.giaVanChuyen
                                ) SEPARATOR ';') AS chiTietDonHang
            FROM 
                taodonhang 
            JOIN 
                donhang ON taodonhang.Id_TaoDonHang = donhang.Id_TaoDonHang 
            WHERE 
                donhang.maBuuCuc = '$maBuuCuc' 
                AND donhang.trangThaiDonHang = '$status'";
    
    // Thực hiện truy vấn
    $result = mysqli_query($link, $sql);
    
    if (!$result) {
        echo json_encode(array('message' => 'Query error: ' . mysqli_error($link)));
        exit(); 
    }
    
    // Lấy kết quả
    $row = mysqli_fetch_assoc($result);
    
    $mauTheoTrangThai = array(
        'Đã giao' => 'success',
        'Đang giao' => 'primary',
        'Đã hủy' => 'danger',
        'Đang chờ phân đơn' => 'warning',
        'Đã phân đơn' => 'info'
    );

    $doanhThu = array(
        'status' => $status,
        'soLuong' => $row['soLuong'] ? $row['soLuong'] : 0, // Đảm bảo không null
        'tongGiaVanChuyen' => $row['tongGiaVanChuyen'] ? $row['tongGiaVanChuyen'] : 0, // Đảm bảo không null
        'mau' => $mauTheoTrangThai[$status],
        'chiTietDonHang' => $row['chiTietDonHang'] // Thêm chi tiết đơn hàng vào mảng kết quả
    );

    // Trả về dữ liệu
    return $doanhThu;
}

// Lấy giá trị của biến maBuuCuc từ yêu cầu
$maBuuCuc = $_GET['maBuuCuc'] ?? null;

// Kiểm tra xem maBuuCuc có tồn tại không
if (!$maBuuCuc) {
    echo json_encode(array('message' => 'Không có mã bưu cục được cung cấp'));
    exit();
}

// Lấy thông tin doanh thu theo các trạng thái
$doanhThuDaGiao = getDoanhThuByStatus($maBuuCuc, 'Đã giao', $link);
$doanhThuDangGiao = getDoanhThuByStatus($maBuuCuc, 'Đang giao', $link);
$doanhThuHuy = getDoanhThuByStatus($maBuuCuc, 'Đã hủy', $link);
$dangChoPhanDon = getDoanhThuByStatus($maBuuCuc, 'Đang chờ phân đơn', $link);
$dangchuyendongiao = getDoanhThuByStatus($maBuuCuc, 'Đã phân đơn', $link);

// Kết hợp thông tin từ các trạng thái thành một mảng
$allDoanhThu = array(
    $doanhThuDaGiao,
    $doanhThuDangGiao,
    $doanhThuHuy,
    $dangChoPhanDon,
    $dangchuyendongiao
);


// Trả về dữ liệu dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($allDoanhThu);

// Đóng kết nối CSDL
mysqli_close($link);
?>
