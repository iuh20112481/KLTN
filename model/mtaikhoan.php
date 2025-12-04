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

    // Lấy tất cả bưu cục (kể cả chưa có nhân viên)
    function getAllBuuCuc() {
        if (!$this->conn) {
            return [];
        }
        $query = "SELECT
                    Id_TenBC,
                    maBuuCuc,
                    tenBuuCuc,
                    diaChiBC
                  FROM tenbc
                  WHERE maBuuCuc IS NOT NULL
                  ORDER BY maBuuCuc";

        $result = mysqli_query($this->conn, $query);
        $data = [];
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }

    function getDSNVBC() {
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
                    bc.maBuuCuc,
                    tbc.tenBuuCuc,
                    tbc.diaChiBC,
                    tbc.maBuuCuc as maBuuCucCode
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
                  JOIN
                    tenbc tbc
                  ON
                    bc.Id_TenBC = tbc.Id_TenBC
                  WHERE
                    plnd.loaiNguoiDung = 'Nhân viên bưu cục'
                  ORDER BY
                    tbc.maBuuCuc, tk.tenND";

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

    function deleteNVBC($Id_TaiKhoan) {
        if (!$this->conn) {
            return false;
        }

        // Escape the Id_TaiKhoan to prevent SQL Injection
        $Id_TaiKhoan = mysqli_real_escape_string($this->conn, $Id_TaiKhoan);

        $query = "DELETE FROM taikhoan WHERE Id_TaiKhoan = '$Id_TaiKhoan'";
        $result = mysqli_query($this->conn, $query);

        return $result ? true : false;
    }

    function addNVBC($data) {
        if (!$this->conn) {
            return ['success' => false, 'message' => 'Không thể kết nối database'];
        }

        // Escape data
        $tenND = mysqli_real_escape_string($this->conn, $data['tenND']);
        $sdtND = mysqli_real_escape_string($this->conn, $data['sdtND']);
        $emailND = mysqli_real_escape_string($this->conn, $data['emailND']);
        $mkND = mysqli_real_escape_string($this->conn, $data['mkND']);
        $gioiTinh = mysqli_real_escape_string($this->conn, $data['gioiTinh']);
        $ngaySinh = mysqli_real_escape_string($this->conn, $data['ngaySinh']);
        $maNhanVien = mysqli_real_escape_string($this->conn, $data['maNhanVien']);
        $maBuuCuc = mysqli_real_escape_string($this->conn, $data['maBuuCuc']);

        // Start transaction
        mysqli_begin_transaction($this->conn);

        try {
            // 1. Insert into taikhoan
            $query1 = "INSERT INTO taikhoan (tenND, sdtND, emailND, mkND)
                      VALUES ('$tenND', '$sdtND', '$emailND', '$mkND')";

            if (!mysqli_query($this->conn, $query1)) {
                throw new Exception('Lỗi thêm tài khoản: ' . mysqli_error($this->conn));
            }

            $idTaiKhoan = mysqli_insert_id($this->conn);

            // 2. Insert into phanloainguoidung
            $query2 = "INSERT INTO phanloainguoidung (Id_TaiKhoan, loaiNguoiDung, gioiTinh, ngaySinh)
                      VALUES ($idTaiKhoan, 'Nhân viên bưu cục', '$gioiTinh', '$ngaySinh')";

            if (!mysqli_query($this->conn, $query2)) {
                throw new Exception('Lỗi phân loại người dùng: ' . mysqli_error($this->conn));
            }

            $idPhanLoai = mysqli_insert_id($this->conn);

            // 3. Get Id_TenBC from maBuuCuc
            $query3 = "SELECT Id_TenBC FROM tenbc WHERE maBuuCuc = '$maBuuCuc' LIMIT 1";
            $result3 = mysqli_query($this->conn, $query3);

            if (!$result3 || mysqli_num_rows($result3) == 0) {
                throw new Exception('Không tìm thấy thông tin bưu cục với mã: ' . $maBuuCuc);
            }

            $row = mysqli_fetch_assoc($result3);
            $idTenBC = $row['Id_TenBC'];

            // 4. Insert into buucuc
            $query4 = "INSERT INTO buucuc (Id_TaiKhoan, Id_PhanLoaiNguoiDung, Id_TenBC, maNhanVien, maBuuCuc)
                      VALUES ($idTaiKhoan, $idPhanLoai, $idTenBC, '$maNhanVien', '$maBuuCuc')";

            if (!mysqli_query($this->conn, $query4)) {
                throw new Exception('Lỗi thêm vào bưu cục: ' . mysqli_error($this->conn));
            }

            // Commit transaction
            mysqli_commit($this->conn);

            return ['success' => true, 'message' => 'Thêm nhân viên thành công!'];

        } catch (Exception $e) {
            // Rollback on error
            mysqli_rollback($this->conn);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
    function __destruct() {
        if ($this->conn) {
            mysqli_close($this->conn);
        }
    }
}
?>
