<?php
include_once "connect1.php";

class model_donhangND {
    function selectAllDonHangND() {
        $p = new connect_db();
        $conn = $p->open_kn(); 
        
        if ($conn) {

            $mand = $_SESSION["nguoidung"]['id_user'];
            $query = "SELECT 
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
            tk.Id_TaiKhoan = $mand
            AND
           ( dh.maVanDon IS NULL OR dh.maVanDon IS NOT NULL)
           AND 
           (dh.trangThaiDonHang IS NULL OR dh.trangThaiDonHang IS NOT NULL)
           AND
           (dh.maVanDon IS NULL OR dh.maVanDon IS NOT NULL)
            "; 
            
            $tbl = mysqli_query($conn, $query);
            $p->close_kn($conn);
            return $tbl; 
            
        } else {
            return false; 
        }
    }
}
?>
