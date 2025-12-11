<?php
include_once "connect1.php";

class model_hoahong {

    // Lấy danh sách tất cả shipper của một bưu cục
    function getAllShipperByBuuCuc($maBuuCuc) {
        $p = new connect_db();
        $conn = $p->open_kn();

        if ($conn) {
            $query = "SELECT
                        buucuc.maNhanVien,
                        buucuc.hoaHongMoiDon,
                        taikhoan.tenND as hoTen,
                        taikhoan.sdtND as soDienThoai
                    FROM buucuc
                    LEFT JOIN taikhoan ON buucuc.Id_TaiKhoan = taikhoan.Id_TaiKhoan
                    WHERE buucuc.maBuuCuc = ?
                    AND buucuc.maNhanVien LIKE '%NVGH%'
                    ORDER BY buucuc.maNhanVien";

            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "s", $maBuuCuc);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            $p->close_kn($conn);
            return $result;
        } else {
            return false;
        }
    }

    // Lấy giá hoa hồng của một shipper
    function getHoaHongByMaNhanVien($maNhanVien) {
        $p = new connect_db();
        $conn = $p->open_kn();

        if ($conn) {
            $query = "SELECT hoaHongMoiDon FROM buucuc WHERE maNhanVien = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "s", $maNhanVien);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $hoaHong = 0;

            if ($row = mysqli_fetch_assoc($result)) {
                $hoaHong = $row['hoaHongMoiDon'];
            }

            mysqli_stmt_close($stmt);
            $p->close_kn($conn);
            return $hoaHong;
        } else {
            return 0;
        }
    }

    // Cập nhật giá hoa hồng cho shipper
    function updateHoaHong($maNhanVien, $hoaHongMoiDon) {
        $p = new connect_db();
        $conn = $p->open_kn();

        if ($conn) {
            $query = "UPDATE buucuc SET hoaHongMoiDon = ? WHERE maNhanVien = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ds", $hoaHongMoiDon, $maNhanVien);
            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $p->close_kn($conn);
            return $result;
        } else {
            return false;
        }
    }

    // Tính tổng hoa hồng của shipper theo trạng thái
    function getTongHoaHongByShipper($maNhanVien, $trangThai = 'Đã giao') {
        $p = new connect_db();
        $conn = $p->open_kn();

        if ($conn) {
            // Lấy số đơn đã giao và giá hoa hồng
            $query = "SELECT
                        COUNT(donhang.Id_DonHang) as soDonDaGiao,
                        buucuc.hoaHongMoiDon,
                        (COUNT(donhang.Id_DonHang) * buucuc.hoaHongMoiDon) as tongHoaHong
                    FROM donhang
                    INNER JOIN buucuc ON donhang.maNhanVien = buucuc.maNhanVien
                    WHERE donhang.maNhanVien = ?
                    AND donhang.trangThaiDonHang = ?
                    GROUP BY buucuc.hoaHongMoiDon";

            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ss", $maNhanVien, $trangThai);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            $data = array(
                'soDonDaGiao' => 0,
                'hoaHongMoiDon' => 0,
                'tongHoaHong' => 0
            );

            if ($row = mysqli_fetch_assoc($result)) {
                $data = $row;
            }

            mysqli_stmt_close($stmt);
            $p->close_kn($conn);
            return $data;
        } else {
            return false;
        }
    }

    // Lấy chi tiết các đơn hàng đã giao của shipper (để hiển thị bảng)
    function getChiTietDonHangDaGiao($maNhanVien, $trangThai = 'Đã giao') {
        $p = new connect_db();
        $conn = $p->open_kn();

        if ($conn) {
            $query = "SELECT
                        donhang.Id_DonHang,
                        donhang.maVanDon,
                        taodonhang.tenDonHang,
                        taodonhang.giaVanChuyen,
                        donhang.ngayHTGiaoHang,
                        donhang.trangThaiDonHang,
                        buucuc.hoaHongMoiDon as hoaHong
                    FROM donhang
                    INNER JOIN taodonhang ON donhang.Id_TaoDonHang = taodonhang.Id_TaoDonHang
                    INNER JOIN buucuc ON donhang.maNhanVien = buucuc.maNhanVien
                    WHERE donhang.maNhanVien = ?
                    AND donhang.trangThaiDonHang = ?
                    ORDER BY donhang.ngayHTGiaoHang DESC";

            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "ss", $maNhanVien, $trangThai);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            $p->close_kn($conn);
            return $result;
        } else {
            return false;
        }
    }

    // Lấy thống kê hoa hồng theo thời gian (ngày, tuần, tháng)
    function getThongKeHoaHong($maNhanVien, $startDate = null, $endDate = null) {
        $p = new connect_db();
        $conn = $p->open_kn();

        if ($conn) {
            $dateCondition = "";
            if ($startDate && $endDate) {
                $dateCondition = "AND donhang.ngayHTGiaoHang BETWEEN '$startDate' AND '$endDate'";
            }

            $query = "SELECT
                        DATE(STR_TO_DATE(donhang.ngayHTGiaoHang, '%d-%m-%Y')) as ngayGiao,
                        COUNT(donhang.Id_DonHang) as soDon,
                        (COUNT(donhang.Id_DonHang) * buucuc.hoaHongMoiDon) as tongHoaHong
                    FROM donhang
                    INNER JOIN buucuc ON donhang.maNhanVien = buucuc.maNhanVien
                    WHERE donhang.maNhanVien = ?
                    AND donhang.trangThaiDonHang = 'Đã giao'
                    $dateCondition
                    GROUP BY ngayGiao
                    ORDER BY ngayGiao DESC";

            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "s", $maNhanVien);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            $p->close_kn($conn);
            return $result;
        } else {
            return false;
        }
    }

    // Lấy số đơn cần giao của bưu cục (theo maNhanVien hoặc maBuuCuc)
    function getSoDonCanGiao($maNhanVien) {
        $p = new connect_db();
        $conn = $p->open_kn();

        if ($conn) {
            $query = "SELECT soDonCanGiao FROM buucuc WHERE maNhanVien = ? LIMIT 1";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "s", $maNhanVien);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $soDonCanGiao = 100; // Giá trị mặc định

            if ($row = mysqli_fetch_assoc($result)) {
                $soDonCanGiao = (int)$row['soDonCanGiao'];
            }

            mysqli_stmt_close($stmt);
            $p->close_kn($conn);
            return $soDonCanGiao;
        } else {
            return 100; // Giá trị mặc định
        }
    }

    // Lấy số đơn cần giao theo mã bưu cục
    function getSoDonCanGiaoByBuuCuc($maBuuCuc) {
        $p = new connect_db();
        $conn = $p->open_kn();

        if ($conn) {
            $query = "SELECT soDonCanGiao FROM buucuc WHERE maBuuCuc = ? LIMIT 1";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "s", $maBuuCuc);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $soDonCanGiao = 100; // Giá trị mặc định

            if ($row = mysqli_fetch_assoc($result)) {
                $soDonCanGiao = (int)$row['soDonCanGiao'];
            }

            mysqli_stmt_close($stmt);
            $p->close_kn($conn);
            return $soDonCanGiao;
        } else {
            return 100; // Giá trị mặc định
        }
    }

    // Cập nhật số đơn cần giao cho toàn bộ nhân viên của bưu cục
    function updateSoDonCanGiao($maBuuCuc, $soDonCanGiao) {
        $p = new connect_db();
        $conn = $p->open_kn();

        if ($conn) {
            // Cập nhật cho tất cả NVGH của bưu cục này
            $query = "UPDATE buucuc SET soDonCanGiao = ? WHERE maBuuCuc = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "is", $soDonCanGiao, $maBuuCuc);
            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            $p->close_kn($conn);
            return $result;
        } else {
            return false;
        }
    }
}
?>
