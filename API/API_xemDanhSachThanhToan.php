<?php
include_once("API.php");

$p = new cmnoii();

$Id_TaiKhoan = isset($_REQUEST['Id_TaiKhoan']) ? $_REQUEST['Id_TaiKhoan'] : null;

// Kiểm tra nếu mã tài khoản không được cung cấp
if ($Id_TaiKhoan === null) {
    echo json_encode(array('message' => 'Vui lòng cung cấp mã tài khoản'));
    exit;
}

// Sử dụng prepared statement để tránh tấn công SQL Injection
$query = "SELECT 
                taodonhang.tenDonHang,
                taodonhang.maDonHang,
                taodonhang.soLuong,
                taodonhang.khoiLuong,
                taodonhang.moTa,
                taodonhang.ngayLapDon,
                taodonhang.hinhThucVanChuyen,
                taodonhang.tenNG,
                taodonhang.sdtNG,
                taodonhang.giaVanChuyen,
                taodonhang.phiThuHo,
                donhang.trangThaiDonHang,
                donhang.maVanDon,
                taikhoan.tenND,
                taikhoan.sdtND,
                taikhoan.diaChi,
                taikhoan.emailND,
                taikhoan.soTK,
                taikhoan.maNH
                FROM 
                taodonhang 
                LEFT JOIN 
                donhang ON donhang.Id_TaoDonHang = taodonhang.Id_TaoDonHang 
                JOIN 
                taikhoan ON taikhoan.Id_TaiKhoan = taodonhang.Id_TaiKhoan 
                WHERE 
                taodonhang.Id_TaiKhoan = ?
                AND taodonhang.phiThuHo = ''
                AND NOT EXISTS (
                    SELECT 1
                    FROM giaodich
                    WHERE giaodich.Id_TaiKhoan = taodonhang.Id_TaiKhoan
                    AND giaodich.ma_don_hang = taodonhang.maDonHang
                )
                ORDER BY 
                donhang.maVanDon ASC;
            ";

// Danh sách các tham số cho prepared statement
$params = array('i', &$Id_TaiKhoan);

// Thực thi truy vấn với prepared statement
$p->xemDonHangThanhToan($query, $params);
?>
