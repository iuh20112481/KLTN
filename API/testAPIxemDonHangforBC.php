<?php
include_once("API.php");

$p = new cmnoii();

$maBuuCuc = isset($_REQUEST['maBuuCuc']) ? $_REQUEST['maBuuCuc'] : null;
$trangThai = isset($_REQUEST['trangThai']) ? $_REQUEST['trangThai'] : null;
$ngayLapDon = isset($_REQUEST['ngayLapDon']) ? $_REQUEST['ngayLapDon'] : null;
$maVanDon = isset($_REQUEST['maVanDon']) ? $_REQUEST['maVanDon'] : null;

if ($maBuuCuc !== null) {
    $query = "SELECT 
        donhang.maBuuCuc,
        taodonhang.Id_TaoDonHang,
        taodonhang.Id_TaiKhoan,
        taodonhang.maDonHang, 
        taodonhang.tenDonHang, 
        taodonhang.tenNG, 
        taodonhang.tenNN, 
        CONCAT(taodonhang.diaChiNhan, ', phường ', taodonhang.phuongXaNhan, ', ', taodonhang.quanHuyenNhan, ', ', taodonhang.tinhNhan) AS diaChiNhanGop, 
        taodonhang.ngayLapDon,
        donhang.trangThaiDonHang,
        donhang.maVanDon,
        phanloainguoidung.loaiNguoiDung,
        phanloainguoidung.Id_PhanLoaiNguoiDung
    FROM 
        taodonhang
    LEFT JOIN 
        donhang ON taodonhang.Id_TaoDonHang = donhang.Id_TaoDonHang
    LEFT JOIN 
        taikhoan ON taodonhang.Id_TaiKhoan = taikhoan.Id_TaiKhoan
    LEFT JOIN 
        phanloainguoidung ON taikhoan.Id_TaiKhoan = phanloainguoidung.Id_TaiKhoan
    WHERE 
        donhang.maBuuCuc = '$maBuuCuc'";

    if ($maVanDon !== null && $maVanDon !== "") {
        // If a tracking number is provided, search only by tracking number
        $query .= " AND donhang.maVanDon = '$maVanDon'";
    } else {
        // Otherwise, apply the other filters
        if ($trangThai !== null && $trangThai !== "0") {
            $query .= " AND donhang.trangThaiDonHang = '$trangThai'";
        }
        if ($ngayLapDon !== null && $ngayLapDon !== "") {
            $query .= " AND taodonhang.ngayLapDon = '$ngayLapDon'";
        }
    }

    $query .= " ORDER BY maVanDon ASC";

    $p->xemALLDonHangforBC($query);
} else {
    echo json_encode(array('message' => 'Vui lòng cung cấp mã Bưu Cục'));
}
?>
