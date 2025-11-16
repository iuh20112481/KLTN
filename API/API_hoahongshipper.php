<?php
/**
 * API Hoa Hồng Shipper - VERSION FIX TÊN CỘT
 * File: API_hoahongshipper_FIX_COLUMN.php
 * 
 * ✅ Fix: Tên cột địa chỉ ĐÚNG (diaChiGiao, diaChiNhan)
 * ✅ Fix: Error handling đầy đủ
 * ✅ Fix: Logging chi tiết
 */

header('Content-Type: application/json; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 0);

include_once("API.php");

try {
    $p = new cmnoii();

    // Lấy tham số
    $maNhanVien = isset($_REQUEST['maNhanVien']) ? trim($_REQUEST['maNhanVien']) : null;
    $fromDate = isset($_REQUEST['fromDate']) ? trim($_REQUEST['fromDate']) : null;
    $toDate = isset($_REQUEST['toDate']) ? trim($_REQUEST['toDate']) : null;
    $trangThai = isset($_REQUEST['trangThai']) ? trim($_REQUEST['trangThai']) : null;

    // Log request
    error_log("=== API HOA HỒNG REQUEST ===");
    error_log("maNhanVien: " . ($maNhanVien ?? 'NULL'));
    error_log("fromDate: " . ($fromDate ?? 'NULL'));
    error_log("toDate: " . ($toDate ?? 'NULL'));
    error_log("trangThai: " . ($trangThai ?? 'NULL'));

    // Validate
    if ($maNhanVien === null || $maNhanVien === '') {
        echo json_encode(array(
            'error' => true,
            'message' => 'Vui lòng cung cấp mã nhân viên',
            'data' => array()
        ), JSON_UNESCAPED_UNICODE);
        exit;
    }

    if ($fromDate === null || $toDate === null || $fromDate === '' || $toDate === '') {
        echo json_encode(array(
            'error' => true,
            'message' => 'Vui lòng cung cấp khoảng thời gian',
            'data' => array()
        ), JSON_UNESCAPED_UNICODE);
        exit;
    }

    // ✅ Query với tên cột ĐÚNG
    $query = "SELECT 
                dh.Id_DonHang,
                dh.maVanDon,
                dh.trangThaiDonHang,
                dh.ngayHTGiaoHang,
                dh.ngayPhanHangGiao,
                dh.maNhanVien,
                tdh.tenDonHang,
                tdh.giaVanChuyen,
                tdh.tenNG,
                tdh.sdtNG,
                tdh.tenNN,
                tdh.sdtNN,
                tdh.diaChiGiao,
                tdh.diaChiNhan
            FROM 
                donhang dh
            INNER JOIN 
                taodonhang tdh ON dh.Id_TaoDonHang = tdh.Id_TaoDonHang
            WHERE 
                dh.maNhanVien = ?";

    // Điều kiện thời gian
    $query .= " AND STR_TO_DATE(COALESCE(dh.ngayHTGiaoHang, dh.ngayPhanHangGiao), '%d-%m-%Y') 
                    BETWEEN STR_TO_DATE(?, '%d-%m-%Y') AND STR_TO_DATE(?, '%d-%m-%Y')";

    // Thêm điều kiện trạng thái
    if ($trangThai !== null && $trangThai !== '' && $trangThai !== 'Tất cả') {
        $query .= " AND dh.trangThaiDonHang = ?";
    }

    $query .= " ORDER BY dh.ngayPhanHangGiao DESC, dh.maVanDon ASC";

    error_log("Query: " . $query);

    // Prepare statement
    $stmt = $p->conn->prepare($query);

    if (!$stmt) {
        throw new Exception("Lỗi prepare: " . $p->conn->error);
    }

    // Bind parameters
    if ($trangThai !== null && $trangThai !== '' && $trangThai !== 'Tất cả') {
        $stmt->bind_param("ssss", $maNhanVien, $fromDate, $toDate, $trangThai);
        error_log("Params: maNhanVien=$maNhanVien, fromDate=$fromDate, toDate=$toDate, trangThai=$trangThai");
    } else {
        $stmt->bind_param("sss", $maNhanVien, $fromDate, $toDate);
        error_log("Params: maNhanVien=$maNhanVien, fromDate=$fromDate, toDate=$toDate");
    }

    // Execute
    if (!$stmt->execute()) {
        throw new Exception("Lỗi execute: " . $stmt->error);
    }

    // Get result
    $result = $stmt->get_result();

    if (!$result) {
        throw new Exception("Lỗi get_result: " . $stmt->error);
    }

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    error_log("Số đơn hàng tìm thấy: " . count($data));

    $stmt->close();

    // Trả về kết quả
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    error_log("API SUCCESS: Trả về " . count($data) . " đơn hàng");

} catch (Exception $e) {
    error_log("ERROR API: " . $e->getMessage());
    echo json_encode(array(
        'error' => true,
        'message' => 'Lỗi hệ thống: ' . $e->getMessage(),
        'data' => array()
    ), JSON_UNESCAPED_UNICODE);
}
?>