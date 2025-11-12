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
function getDoanhThuByStatus($Id_TaiKhoan, $status, $link) {
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
            LEFT JOIN 
                donhang ON taodonhang.Id_TaoDonHang = donhang.Id_TaoDonHang 
            WHERE 
                taodonhang.Id_TaiKhoan = '$Id_TaiKhoan'  
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

// Hàm lấy thông tin doanh thu cho trạng thái "Chưa duyệt đơn"
function getDoanhThuChuaDuyet($Id_TaiKhoan, $link) {
    // Truy vấn SQL
    $sql = "SELECT 
                SUM(soLuong) AS soLuong,
                SUM(tongGiaVanChuyen) AS tongGiaVanChuyen,
                GROUP_CONCAT(chiTietDonHang SEPARATOR ';') AS chiTietDonHang
            FROM (
                SELECT 
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
                LEFT JOIN 
                    donhang ON taodonhang.Id_TaoDonHang = donhang.Id_TaoDonHang 
                WHERE 
                    taodonhang.Id_TaiKhoan = '$Id_TaiKhoan'  
                    AND donhang.trangThaiDonHang IS NULL            
                    AND donhang.maVanDon IS NULL
            ) AS combined_results";

    // Thực hiện truy vấn
    $result = mysqli_query($link, $sql);
    
    if (!$result) {
        echo json_encode(array('message' => 'Query error: ' . mysqli_error($link)));
        exit(); 
    }
    
    // Lấy kết quả
    $row = mysqli_fetch_assoc($result);

    // Trả về dữ liệu
    return $row;
}

// Lấy giá trị của biến Id_TaiKhoan từ yêu cầu
$Id_TaiKhoan = $_GET['Id_TaiKhoan'] ?? null;

// Kiểm tra xem Id_TaiKhoan có tồn tại không
if (!$Id_TaiKhoan) {
    echo json_encode(array('message' => 'Không có ID ND được cung cấp'));
    exit();
}

// Lấy thông tin doanh thu theo các trạng thái
$doanhThuDaGiao = getDoanhThuByStatus($Id_TaiKhoan, 'Đã giao', $link);
$doanhThuDangGiao = getDoanhThuByStatus($Id_TaiKhoan, 'Đang giao', $link);
$doanhThuHuy = getDoanhThuByStatus($Id_TaiKhoan, 'Đã hủy', $link);
$dangChoPhanDon = getDoanhThuByStatus($Id_TaiKhoan, 'Đang chờ phân đơn', $link);
$dangchuyendongiao = getDoanhThuByStatus($Id_TaiKhoan, 'Đã phân đơn', $link);

// Kết hợp thông tin từ các trạng thái thành một mảng
$allDoanhThu = array(
    $doanhThuDaGiao,
    $doanhThuDangGiao,
    $doanhThuHuy,
    $dangChoPhanDon,
    $dangchuyendongiao, 
);

// Trả về dữ liệu dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($allDoanhThu);

// Đóng kết nối CSDL
mysqli_close($link);
?>
