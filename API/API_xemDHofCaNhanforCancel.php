<?php
include_once("API.php");

$p = new cmnoii();

if (isset($_REQUEST['Id_TaiKhoan'])) {
    // Xử lý yêu cầu xem đơn hàng
    $Id_TaiKhoan = $_REQUEST['Id_TaiKhoan'];

    // Kiểm tra nếu mã tài khoản không được cung cấp
    if (!isset($Id_TaiKhoan)) {
        http_response_code(400); // Yêu cầu không hợp lệ
        echo json_encode(array('error' => 'Vui lòng cung cấp mã tài khoản'));
        exit;
    }

    // Sử dụng prepared statement để tránh tấn công SQL Injection
    $query = "SELECT 		
                taodonhang.Id_TaoDonHang,
                taodonhang.Id_TaiKhoan,
                donhang.ngayHTGiaoHang,
                taodonhang.maDonHang,
                donhang.maVanDon,
                taodonhang.tenDonHang,
                taodonhang.giaVanChuyen,
                taodonhang.phiThuHo,
                taodonhang.ngayLapDon,
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
                JOIN 
                taodonhang 
                ON donhang.Id_TaoDonHang = taodonhang.Id_TaoDonHang
                WHERE 
                taodonhang.Id_TaiKhoan = ?
                AND donhang.trangThaiDonHang = 'Đã hủy';
                ";

    // Danh sách các tham số cho prepared statement
    $params = array('i', &$Id_TaiKhoan);

    // Thực thi truy vấn với prepared statement
    $p->xemDHofCaNhanforCancel($query, $params);
} elseif (isset($_REQUEST['Id_TaoDonHang'])) {
    // Xử lý yêu cầu hủy đơn hàng
    $Id_TaoDonHang = $_REQUEST['Id_TaoDonHang'];

    // Kiểm tra nếu mã tạo đơn hàng không được cung cấp
    if (!isset($Id_TaoDonHang)) {
        http_response_code(400); // Yêu cầu không hợp lệ
        echo json_encode(array('error' => 'Vui lòng cung cấp mã tạo đơn hàng'));
        exit;
    }

    // Xóa đơn hàng từ cơ sở dữ liệu
    $query = "DELETE FROM taodonhang WHERE Id_TaoDonHang = ?";
    $params = array('i', &$Id_TaoDonHang);
    $p->xemDHofCaNhanforCancel($query, $params);

    // Phản hồi JSON cho biết việc xóa đã thành công
    echo json_encode(array('success' => true));
} else {
    http_response_code(404); // Không tìm thấy
    echo json_encode(array('error' => 'Không có yêu cầu hợp lệ được cung cấp'));
}
?>
