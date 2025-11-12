<?php
include_once("API.php");

$p = new cmnoii();

$maNhanVien = isset($_REQUEST['maNhanVien']) ? $_REQUEST['maNhanVien'] : null;

// Kiểm tra nếu mã nhân viên không được cung cấp
if ($maNhanVien === null) {
    echo json_encode(array('message' => 'Vui lòng cung cấp mã nhân viên'));
    exit;
}

// Sử dụng prepared statement để tránh tấn công SQL Injection
$query = "SELECT 
    donhang.Id_DonHang,
    donhang.maVanDon,
    taodonhang.tenDonHang,
    taodonhang.sdtNN,
    taodonhang.sdtNG,
    donhang.trangThaiDonHang,
    donhang.ngayPhanHangGiao,
    taodonhang.tenNG,
    taodonhang.tenNN,
    taodonhang.sdtNG,
    taodonhang.sdtNN,
    donhang.ngayHTGiaoHang,
    CONCAT(
        taodonhang.diaChiNhan, 
        ', phường ', taodonhang.phuongXaNhan, 
        ', ', taodonhang.quanHuyenNhan, 
        ', ', taodonhang.tinhNhan
    ) AS diaChiNhanGop
FROM 
    donhang 
INNER JOIN 
    taodonhang 
    ON donhang.Id_TaoDonHang = taodonhang.Id_TaoDonHang
WHERE 
    donhang.maNhanVien = ?";

// Danh sách các tham số cho prepared statement
$params = array('s', &$maNhanVien);

// Kiểm tra và thêm các điều kiện tìm kiếm (nếu có)
if (isset($_REQUEST['maVanDon']) && $_REQUEST['maVanDon'] !== '') {
    $query .= " AND donhang.maVanDon = ?";
    $params[0] .= 's'; // Loại dữ liệu của tham số thêm vào
    $params[] = &$_REQUEST['maVanDon']; // Thêm tham số vào danh sách
} else {
    if (isset($_REQUEST['trangThai']) && $_REQUEST['trangThai'] !== '') {
        $query .= " AND donhang.trangThaiDonHang = ?";
        $params[0] .= 's';
        $params[] = &$_REQUEST['trangThai'];
    }
    if (isset($_REQUEST['ngayPhanHangGiao']) && $_REQUEST['ngayPhanHangGiao'] !== '') {
        $query .= " AND donhang.ngayPhanHangGiao = ?";
        $params[0] .= 's';
        $params[] = &$_REQUEST['ngayPhanHangGiao'];
    }
}

$query .= " ORDER BY maVanDon ASC";

// Thực thi truy vấn với prepared statement
$p->selectDonHangforDateofNVGH($query, $params);
?>