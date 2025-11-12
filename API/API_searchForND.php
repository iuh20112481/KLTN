<?php
include_once("API.php");

$p = new cmnoii();

$Id_TaiKhoan = isset($_REQUEST['Id_TaiKhoan']) ? $_REQUEST['Id_TaiKhoan'] : null;

// Kiểm tra nếu mã nhân viên không được cung cấp
if ($Id_TaiKhoan === null) {
    echo json_encode(array('message' => 'Vui lòng cung cấp ID ND'));
    exit;
}

// Sử dụng prepared statement để tránh tấn công SQL Injection
$query = "SELECT 
                taodonhang.maDonHang,
                donhang.maVanDon,
                taodonhang.tenDonHang,
                taodonhang.tenNN,
                taodonhang.sdtNN,
                donhang.trangThaiDonHang,
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
                taodonhang.Id_TaiKhoan = ?";

// Danh sách các tham số cho prepared statement
$params = array('s', &$Id_TaiKhoan);

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