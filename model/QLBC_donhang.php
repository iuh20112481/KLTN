<?php
// Include helper function để tạo mã vận đơn
include_once __DIR__ . "/m_mavandon_helper.php";

class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "HPship";
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Kết nối đến cơ sở dữ liệu thất bại: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}

class controlxacnhan {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function addDonHang($Id_TaoDonHang, $Id_PhanLoaiNguoiDung, $tenBuuCuc) {
        $conn = $this->db->getConnection();

        // Tạo mã vận đơn tự động (sử dụng helper function)
        $maVanDon = generateMaVanDon($conn);

        $sql = "INSERT INTO donhang (Id_TaoDonHang, Id_PhanLoaiNguoiDung, maVanDon, tenBuuCuc) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiss", $Id_TaoDonHang, $Id_PhanLoaiNguoiDung, $maVanDon, $tenBuuCuc);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getDonHang($Id_PhanLoaiNguoiDung) {
        $conn = $this->db->getConnection();

        $sql = "SELECT * FROM taodonhang WHERE Id_TaiKhoan = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s",$Id_PhanLoaiNguoiDung );
        $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }
}

?>
