<?php
class UserModel {
    protected $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function createUser($username, $pass, $email, $sdt, $Id_TenBC, $manhanvien, $ngaysinh, $gioitinh, $mabuucuc) {
        try {
            $this->db->beginTransaction(); // Bắt đầu giao dịch

            // Chèn vào bảng taikhoan
            $stmt = $this->db->prepare('INSERT INTO taikhoan (tenND, mkND, emailND, sdtND) VALUES (:username, :pass, :email, :sdt)');
            $stmt->execute([
                ':username' => $username,
                ':pass' => $pass,
                ':email' => $email,
                ':sdt' => $sdt
            ]);

            // Lấy ID cuối cùng
            $employeeId = $this->db->lastInsertId();

            // Chèn vào bảng phân loại người dùng
            $stmt = $this->db->prepare('INSERT INTO phanloainguoidung (Id_TaiKhoan, loaiNguoiDung, ngaySinh, gioiTinh) VALUES (:Id_TaiKhoan, :loaiNguoiDung, :ngaysinh, :gioitinh)');
            $stmt->execute([
                ':Id_TaiKhoan' => $employeeId,
                ':loaiNguoiDung' => 'Nhân viên giao hàng',
                ':ngaysinh' => $ngaysinh,
                ':gioitinh' => $gioitinh
            ]);

            $roleId = $this->db->lastInsertId(); 

            // Chèn vào bảng buucuc
            $stmt = $this->db->prepare('INSERT INTO buucuc (Id_TaiKhoan, Id_PhanLoaiNguoiDung, Id_TenBC, maNhanVien, maBuuCuc) VALUES (:Id_TaiKhoan, :Id_PhanLoaiNguoiDung, :Id_TenBC, :manhanvien, :mabuucuc)');
            $stmt->execute([
                ':Id_TaiKhoan' => $employeeId,
                ':Id_PhanLoaiNguoiDung' => $roleId,
                ':Id_TenBC' => $Id_TenBC,
                ':manhanvien' => $manhanvien,
                ':mabuucuc' => $mabuucuc
            ]);
            $this->db->commit(); 

            return $employeeId; 
        } catch (Exception $e) {
            $this->db->rollBack(); // Hủy bỏ giao dịch nếu có lỗi
            throw $e; // Ném lỗi cho controller xử lý
        }
    }

}
