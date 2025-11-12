<?php
include_once "connect1.php";

class model_dn {
    function selectNd($sdt, $mk){
        $p = new connect_db();
        $conn = $p->open_kn(); 

        if ($conn) {
            $query = "SELECT *
                FROM `taikhoan`
                WHERE `sdtND` = '$sdt'
                AND `mkND` = '$mk'
                LIMIT 1";

            $result = mysqli_query($conn, $query); 
            $p->close_kn($conn); 
            
            return $result; 
        } else {
            return false;
        }
    }

    function selectUserRoles($sdt, $mk) {
        $p = new connect_db();
        $conn = $p->open_kn();
        
        if (!$conn) {
            // Trường hợp không kết nối được cơ sở dữ liệu
            return null;
        }
    
        $query = "SELECT tlnd.loaiNguoiDung
                  FROM `taikhoan` tk
                  JOIN `phanloainguoidung` tlnd ON tk.Id_TaiKhoan = tlnd.Id_TaiKhoan
                  WHERE tk.`sdtND` = ? AND tk.`mkND` = ? 
                  LIMIT 1";
    
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $sdt, $mk);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $loaiNguoiDung);
        $result = mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);
        $p->close_kn($conn);
    
        if ($result) {
            return $loaiNguoiDung;  
        } else {
            return null; 
        }
    }
    
    function getBuuCucInfo($idTaiKhoan){
        $p = new connect_db();
        $conn = $p->open_kn();

        if ($conn) {
            $query = "SELECT 
                            buucuc.Id_TenBC, 
                            buucuc.maBuuCuc, 
                            buucuc.Id_PhanLoaiNguoiDung,
                            tenbc.tenBuuCuc,
                            tenbc.diaChiBC
                        FROM 
                            buucuc
                        JOIN tenbc ON buucuc.Id_TenBC = tenbc.Id_TenBC
                        WHERE 
                            buucuc.Id_TaiKhoan = ?
                        LIMIT 
                            1;
                    ";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $idTaiKhoan);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $Id_TenBC, $maBuuCuc, $Id_PhanLoaiNguoiDung, $tenBuuCuc, $diaChiBC);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);
            $p->close_kn($conn);

            if(isset($Id_TenBC)) {
                return array("Id_TenBC" => $Id_TenBC, "maBuuCuc" => $maBuuCuc, "Id_PhanLoaiNguoiDung" => $Id_PhanLoaiNguoiDung, "tenBuuCuc" => $tenBuuCuc, "diaChiBC" => $diaChiBC);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    
    
}
?>
