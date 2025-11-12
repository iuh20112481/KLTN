<?php
include_once "connect1.php";

class model_tk {

    private $conn;

    function __construct() {
        $db = new connect_db();
        $this->conn = $db->open_kn();
    }

    function checkUserType($userId) {
        if ($this->conn) {
            $query = "SELECT mucDichSuDung FROM taikhoan WHERE Id_TaiKhoan = $userId";
            $result = mysqli_query($this->conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                return $row['mucDichSuDung'];
            }
        }
        return false;
    }

    function getNewUserIds() {
        $newUserIds = array();
        if ($this->conn) {
            $query = "SELECT Id_TaiKhoan 
                      FROM taikhoan 
                      WHERE Id_TaiKhoan NOT IN (SELECT Id_TaiKhoan FROM phanloainguoidung)";
            $result = mysqli_query($this->conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $newUserIds[] = $row['Id_TaiKhoan'];
                }
            }
        }
        return $newUserIds;
    }

    function insertUserType($userId, $userType) {
        if ($this->conn) {
            $query = "INSERT INTO phanloainguoidung (Id_TaiKhoan, loaiNguoiDung) 
                      VALUES ($userId, '$userType')";
            $result = mysqli_query($this->conn, $query);
            return $result ? true : false;
        }
        return false;
    }

    function getDSNVGH($maBuuCuc = null) {
        if (!$this->conn) {
            return [];
        }
        $query = "SELECT 
                    tk.Id_TaiKhoan,
                    tk.tenND,
                    tk.sdtND,
                    plnd.loaiNguoiDung,
                    tk.emailND,
                    bc.maNhanVien,
                    bc.maBuuCuc
                  FROM 
                    taikhoan tk
                  JOIN 
                    phanloainguoidung plnd 
                  ON 
                    tk.Id_TaiKhoan = plnd.Id_TaiKhoan 
                  JOIN 
                    buucuc bc 
                  ON 
                    tk.Id_TaiKhoan = bc.Id_TaiKhoan 
                  WHERE 
                    plnd.loaiNguoiDung = 'Nhân viên giao hàng'"; 
    
        if ($maBuuCuc) {
            $query .= " AND bc.maBuuCuc = '$maBuuCuc'"; 
        }
    
        $result = mysqli_query($this->conn, $query); 
        $data = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
    
    function countDonHangofNVGH($maNhanVien) {
        if (!$this->conn) {
            return [
                'tongdonhang' => 0,
                'tongdondagiao' => 0
            ]; // Return default values
        }
    
        // Escape the maNhanVien to prevent SQL Injection
        $maNhanVien = mysqli_real_escape_string($this->conn, $maNhanVien);
    
        $query = "SELECT 
                        COUNT(*) AS tongdonhang,
                        SUM(CASE WHEN trangThaiDonHang = 'Đã giao' THEN 1 ELSE 0 END) AS tongdondagiao 
                    FROM 
                        donhang
                    WHERE 
                        maNhanVien = '$maNhanVien'"; 
    
        $result = mysqli_query($this->conn, $query); 
    
        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result); 
            return [
                'tongdonhang' => $row['tongdonhang'],
                'tongdondagiao' => $row['tongdondagiao']
            ]; // Return both values in an associative array
        }
    
        return [
            'tongdonhang' => 0,
            'tongdondagiao' => 0
        ]; // Default return if no data found
    }
    
    function deleteNVGH($Id_TaiKhoan) {
        if (!$this->conn) {
            return false;
        }
    
        // Escape the Id_TaiKhoan to prevent SQL Injection
        $Id_TaiKhoan = mysqli_real_escape_string($this->conn, $Id_TaiKhoan);
    
        $query = "DELETE FROM taikhoan WHERE Id_TaiKhoan = '$Id_TaiKhoan'";
        $result = mysqli_query($this->conn, $query);
    
        return $result ? true : false;
    }
    
    function __destruct() {
        if ($this->conn) {
            mysqli_close($this->conn);
        }
    }
}
?>
