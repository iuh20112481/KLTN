<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once 'API.php'; // Include the class file

$api = new cmnoii();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['Id_TaiKhoan'])) {
        $Id_TaiKhoan = $_GET['Id_TaiKhoan'];
        $maVanDon = isset($_GET['maVanDon']) ? $_GET['maVanDon'] : '';
        $sdtNN = isset($_GET['sdtNN']) ? $_GET['sdtNN'] : '';
        $trangThaiDonHang = isset($_GET['trangThaiDonHang']) ? $_GET['trangThaiDonHang'] : '';

        $sql = "SELECT 
                    tdh.maDonHang, 
                    tk.Id_TaiKhoan, 
                    dh.maVanDon, 
                    tdh.tenDonHang, 
                    tdh.tenNN, 
                    tdh.sdtNN, 
                    CONCAT(
                            tdh.diaChiNhan, 
                    ', ', tdh.phuongXaNhan, 
                    ', ', tdh.quanHuyenNhan, 
                    ', ', tdh.tinhNhan
                    ) AS diaChiNhanGop, 
                    dh.trangThaiDonHang
                FROM 
                    taodonhang tdh
                LEFT JOIN taikhoan tk
                ON tdh.Id_TaiKhoan = tk.Id_TaiKhoan
                LEFT JOIN donhang dh
                ON tdh.Id_TaoDonHang = dh.Id_TaoDonHang
                WHERE
                    tk.Id_TaiKhoan = ?";

        $params = array('i', $Id_TaiKhoan);

        if (!empty($maVanDon)) {
            $sql .= " AND dh.maVanDon LIKE ?";
            $params[0] .= 's';
            $params[] = '%' . $maVanDon . '%';
        }

        if (!empty($sdtNN)) {
            $sql .= " AND tdh.sdtNN LIKE ?";
            $params[0] .= 's';
            $params[] = '%' . $sdtNN . '%';
        }

        if (!empty($trangThaiDonHang)) {
            $sql .= " AND dh.trangThaiDonHang = ?";
            $params[0] .= 's';
            $params[] = $trangThaiDonHang;
        }

        // Call the xemDHforCaNhan method
        $api->xemDHforCaNhan($sql, $params);
    } else {
        echo json_encode(array('message' => 'Thiếu tham số Id_TaiKhoan'));
    }
} else {
    echo json_encode(array('message' => 'Phương thức không được hỗ trợ'));
}
?>
