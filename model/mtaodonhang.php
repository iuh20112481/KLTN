<?php 
include_once "connect1.php";

class model_taodonhang {

    /**
     * Thêm đơn hàng mới vào database
     * Sử dụng Prepared Statements để bảo mật
     */
    function addTaoDonHang(
        $tenng, $tennn, $dcng, $dcnn, $telng, $telnn, 
        $lvl1, $lvl2, $lvl3, $lvl1_1, $lvl2_1, $lvl3_1, 
        $tensp, $madh, $soluong, $khoiluong,
        $chieudai, $chieurong, $chieucao, 
        $giaohang, $ghichu, $mand, $ngay, 
        $classification, $phithuho, $giavanchuyen
    ) {
        $p = new connect_db();
        $conn = $p->open_kn();
        
        if (!$conn) {
            error_log("Lỗi kết nối database trong addTaoDonHang");
            return false;
        }

        // ===== SỬ DỤNG PREPARED STATEMENTS ĐỂ TRÁNH SQL INJECTION =====
        $sql = "INSERT INTO `taodonhang` (
            `tenDonHang`, `loaiDonHang`, `soLuong`, `khoiLuong`, 
            `phiThuHo`, `hinhThucVanChuyen`, `moTa`, 
            `tenNG`, `tenNN`, `sdtNG`, `sdtNN`, 
            `diaChiGiao`, `diaChiNhan`, 
            `quanHuyenGiao`, `quanHuyenNhan`, 
            `phuongXaGiao`, `phuongXaNhan`, 
            `maDonHang`, `Id_TaiKhoan`, `ngayLapDon`, 
            `tinhGiao`, `tinhNhan`, 
            `chieuDai`, `chieuCao`, `chieuRong`, 
            `giaVanChuyen`
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);
        
        if (!$stmt) {
            error_log("Lỗi prepare statement: " . mysqli_error($conn));
            $p->close_kn($conn);
            return false;
        }

        // Bind parameters (26 tham số)
        // s = string, i = integer, d = double/decimal
        mysqli_stmt_bind_param(
            $stmt, 
            "sssddsssssssssssssissssdds", // 26 type definitions
            $tensp,          // s - string
            $classification, // s
            $soluong,        // s (có thể đổi thành i nếu muốn)
            $khoiluong,      // d - decimal
            $phithuho,       // d
            $giaohang,       // s
            $ghichu,         // s
            $tenng,          // s
            $tennn,          // s
            $telng,          // s
            $telnn,          // s
            $dcng,           // s
            $dcnn,           // s
            $lvl2,           // s
            $lvl2_1,         // s
            $lvl3,           // s
            $lvl3_1,         // s
            $madh,           // s
            $mand,           // i - integer (có thể NULL)
            $ngay,           // s
            $lvl1,           // s
            $lvl1_1,         // s
            $chieudai,       // s (nên đổi thành d)
            $chieucao,       // d
            $chieurong,      // d
            $giavanchuyen    // s (nên đổi thành d)
        );

        // Thực thi câu lệnh
        $result = mysqli_stmt_execute($stmt);
        
        if ($result) {
            $affected_rows = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            $p->close_kn($conn);
            
            return $affected_rows > 0;
        } else {
            $error = mysqli_stmt_error($stmt);
            error_log("Lỗi execute statement: " . $error);
            mysqli_stmt_close($stmt);
            $p->close_kn($conn);
            
            return false;
        }
    }
    /**
 * Lấy danh sách đơn hàng vãng lai (Id_TaiKhoan IS NULL)
 */
    function getDonHangVangLai() {
        $p = new connect_db();
        $conn = $p->open_kn();
        
        if (!$conn) {
            return [];  
        }

        $sql = "SELECT * FROM `taodonhang` WHERE `Id_TaiKhoan` IS NULL ORDER BY `ngayLapDon` DESC";
        $result = mysqli_query($conn, $sql);

        $orders = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $orders[] = $row;
            }
    }

    $p->close_kn($conn);
    return $orders;
}
    /**
     * Lấy danh sách đơn hàng của một tài khoản
     * @param int|null $id_taikhoan - NULL để lấy đơn hàng vãng lai
     */
    function getDonHangByTaiKhoan($id_taikhoan = null) {
        $p = new connect_db();
        $conn = $p->open_kn();
        
        if (!$conn) {
            return [];
        }

        if ($id_taikhoan === null) {
            // Lấy đơn hàng vãng lai (Id_TaiKhoan IS NULL)
            $sql = "SELECT * FROM `taodonhang` WHERE `Id_TaiKhoan` IS NULL ORDER BY `ngayLapDon` DESC";
            $result = mysqli_query($conn, $sql);
        } else {
            // Lấy đơn hàng của tài khoản cụ thể
            $sql = "SELECT * FROM `taodonhang` WHERE `Id_TaiKhoan` = ? ORDER BY `ngayLapDon` DESC";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $id_taikhoan);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        }

        $orders = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $orders[] = $row;
            }
        }

        $p->close_kn($conn);
        return $orders;
    }
}
?>