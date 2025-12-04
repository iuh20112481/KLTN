<?php
include_once(__DIR__ . "/../model/mhoahong.php");

class control_hoahong {

    // Lấy danh sách shipper của bưu cục
    function getAllShipperByBuuCuc($maBuuCuc) {
        $p = new model_hoahong();
        return $p->getAllShipperByBuuCuc($maBuuCuc);
    }

    // Lấy giá hoa hồng của shipper
    function getHoaHongByMaNhanVien($maNhanVien) {
        $p = new model_hoahong();
        return $p->getHoaHongByMaNhanVien($maNhanVien);
    }

    // Cập nhật giá hoa hồng
    function updateHoaHong($maNhanVien, $hoaHongMoiDon) {
        $p = new model_hoahong();
        return $p->updateHoaHong($maNhanVien, $hoaHongMoiDon);
    }

    // Tính tổng hoa hồng của shipper
    function getTongHoaHongByShipper($maNhanVien, $trangThai = 'Đã giao') {
        $p = new model_hoahong();
        return $p->getTongHoaHongByShipper($maNhanVien, $trangThai);
    }

    // Lấy chi tiết đơn hàng đã giao
    function getChiTietDonHangDaGiao($maNhanVien, $trangThai = 'Đã giao') {
        $p = new model_hoahong();
        return $p->getChiTietDonHangDaGiao($maNhanVien, $trangThai);
    }

    // Lấy thống kê hoa hồng theo thời gian
    function getThongKeHoaHong($maNhanVien, $startDate = null, $endDate = null) {
        $p = new model_hoahong();
        return $p->getThongKeHoaHong($maNhanVien, $startDate, $endDate);
    }
}

// Xử lý AJAX request từ NVBC để cập nhật hoa hồng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'updateHoaHong') {
    session_start();

    // Kiểm tra quyền NVBC
    if (!isset($_SESSION['nvbc'])) {
        echo json_encode(array('success' => false, 'message' => 'Không có quyền truy cập'));
        exit();
    }

    $maNhanVien = $_POST['maNhanVien'] ?? '';
    $hoaHongMoiDon = $_POST['hoaHongMoiDon'] ?? 0;

    if (empty($maNhanVien)) {
        echo json_encode(array('success' => false, 'message' => 'Thiếu mã nhân viên'));
        exit();
    }

    $controller = new control_hoahong();
    $result = $controller->updateHoaHong($maNhanVien, $hoaHongMoiDon);

    if ($result) {
        echo json_encode(array('success' => true, 'message' => 'Cập nhật hoa hồng thành công'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Cập nhật hoa hồng thất bại'));
    }
    exit();
}
?>
