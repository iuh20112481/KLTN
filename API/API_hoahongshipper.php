<?php
header('Content-Type: application/json; charset=utf-8');
include_once("API.php");

$p = new cmnoii();

// Lấy tham số từ request
$maNhanVien = isset($_REQUEST['maNhanVien']) ? $_REQUEST['maNhanVien'] : null;
$fromDate = isset($_REQUEST['fromDate']) ? $_REQUEST['fromDate'] : null;
$toDate = isset($_REQUEST['toDate']) ? $_REQUEST['toDate'] : null;
$trangThai = isset($_REQUEST['trangThai']) ? $_REQUEST['trangThai'] : null;

// Kiểm tra dữ liệu đầu vào
if ($maNhanVien === null) {
    echo json_encode(array('error' => 'Vui lòng cung cấp mã nhân viên'));
    exit;
}

if ($fromDate === null || $toDate === null) {
    echo json_encode(array('error' => 'Vui lòng cung cấp khoảng thời gian'));
    exit;
}

// Xây dựng câu truy vấn SQL
$query = "SELECT 
            donhang.Id_DonHang,
            donhang.maVanDon,
            donhang.trangThaiDonHang,
            donhang.ngayHTGiaoHang,
            donhang.ngayPhanHangGiao,
            taodonhang.tenDonHang,
            taodonhang.giaVanChuyen,
            taodonhang.tenNG,
            taodonhang.sdtNG,
            taodonhang.tenNN,
            taodonhang.sdtNN,
            taodonhang.diaChiNhanGop
        FROM 
            donhang 
        INNER JOIN 
            taodonhang ON donhang.Id_TaoDonHang = taodonhang.Id_TaoDonHang 
        WHERE 
            donhang.maNhanVien = ?";

// Thêm điều kiện lọc theo khoảng thời gian
$query .= " AND (
                STR_TO_DATE(donhang.ngayHTGiaoHang, '%d-%m-%Y') BETWEEN STR_TO_DATE(?, '%d-%m-%Y') AND STR_TO_DATE(?, '%d-%m-%Y')
                OR 
                (donhang.ngayHTGiaoHang IS NULL AND STR_TO_DATE(donhang.ngayPhanHangGiao, '%d-%m-%Y') BETWEEN STR_TO_DATE(?, '%d-%m-%Y') AND STR_TO_DATE(?, '%d-%m-%Y'))
            )";

// Thêm điều kiện lọc theo trạng thái nếu có
if ($trangThai !== null && $trangThai !== '') {
    $query .= " AND donhang.trangThaiDonHang = ?";
}

$query .= " ORDER BY donhang.ngayPhanHangGiao DESC, donhang.maVanDon ASC";

// Chuẩn bị tham số cho prepared statement
if ($trangThai !== null && $trangThai !== '') {
    $params = array(
        'ssssss',
        &$maNhanVien,
        &$fromDate,
        &$toDate,
        &$fromDate,
        &$toDate,
        &$trangThai
    );
} else {
    $params = array(
        'sssss',
        &$maNhanVien,
        &$fromDate,
        &$toDate,
        &$fromDate,
        &$toDate
    );
}

// Thực thi truy vấn
$p->xemDonHangThanhToan($query, $params);
?>