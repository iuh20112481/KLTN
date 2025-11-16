<?php 
/**
 * API.php - CLASS ĐÃ FIX
 * 
 * ✅ Fix: Thêm property $conn
 * ✅ Fix: Constructor tự động kết nối
 */

class cmnoii {
    public $conn; // ← PROPERTY MỚI - QUAN TRỌNG!
    
    /**
     * Constructor - Tự động kết nối database khi tạo object
     */
    public function __construct() {
        $this->conn = $this->connect();
    }
    
    /**
     * Kết nối database
     */
    public function connect(){
        $con = mysqli_connect("localhost", "root", "", "HPship");
        if (!$con) {
            echo 'Không kết nối được CSDL';
            exit();
        } else {
            mysqli_set_charset($con, "UTF8");
            return $con;
        }
    }

    // ============================================
    // CÁC METHOD CŨ - GIỮ NGUYÊN
    // ============================================

    public function xemdsdonhang($sql){
        $link = $this->connect();
        $ketqua = mysqli_query($link, $sql);
        if (!$ketqua) {
            echo json_encode(array('message' => 'Query error: ' . mysqli_error($link)));
            exit(); 
        }
        $i = mysqli_num_rows($ketqua);
        if ($i > 0) {
            $dulieu = array();
            while ($row = mysqli_fetch_assoc($ketqua)) {
                $Id_TaoDonHang= $row['Id_TaoDonHang'];
                $tenDonHang = $row['tenDonHang'];
                $Id_TaiKhoan = $row['Id_TaiKhoan'];
                $Id_PhanLoaiNguoiDung= $row['Id_PhanLoaiNguoiDung'];
                $tenDonHang = $row['tenDonHang'];
                $tenNG = $row['tenNG'];
                $tenNN = $row['tenNN'];
                $diaChiNhanGop = $row['diaChiNhanGop'];
                $ngayLapDon = $row['ngayLapDon'];
                $trangThaiDonHang = $row['trangThaiDonHang'];
                $maVanDon = $row['maVanDon'];
                $dulieu[] = array('Id_TaoDonHang' => $Id_TaoDonHang, 'Id_PhanLoaiNguoiDung'=>$Id_PhanLoaiNguoiDung ,'Id_TaiKhoan'=>$Id_TaiKhoan ,'tenDonHang' => $tenDonHang, 'tenNG' => $tenNG, 'tenNN' => $tenNN, 'diaChiNhanGop' => $diaChiNhanGop, 'ngayLapDon' => $ngayLapDon, 'trangThaiDonHang' => $trangThaiDonHang, 'maVanDon' => $maVanDon);
            }
            header("Content-Type: application/json; charset=UTF-8");
            echo json_encode($dulieu);
        } else {
            echo json_encode(array('message' => 'Không có dữ liệu'));
        }
    }

    public function updatedonhang($sql){
        $link = $this->connect();
        $ketqua = mysqli_query($link, $sql);
    
        if (!$ketqua) {
            $error = mysqli_error($link);
            echo json_encode(array('message' => 'Query error: ' . $error));
            exit(); 
        }
    
        echo json_encode(array('message' => 'Cập nhật thành công'));
    }

    public function xemDoanhThuBc($sql){
        $link = $this->connect();
        $ketqua = mysqli_query($link, $sql); 
        $i = mysqli_num_rows($ketqua); 
        if($i > 0){
            $dulieu = array();
            while($row = mysqli_fetch_array($ketqua)){ 
                $soLuong = $row['soLuong'];
                $tongGiaVanChuyen = $row['tongGiaVanChuyen'];
                $dulieu[] = array('soLuong' => $soLuong, 'tongGiaVanChuyen' => $tongGiaVanChuyen);
            }
            header("Content-Type: application/json; charset=UTF-8");
            echo json_encode($dulieu);
        }
    }
    
    public function xemHangDangGiao($sql){
        $link = $this->connect();
        $ketqua = mysqli_query($link, $sql); 
        $i = mysqli_num_rows($ketqua); 
        if($i > 0){
            $dulieu = array();
            while($row = mysqli_fetch_array($ketqua)){ 
                $soLuong1 = $row['soLuong1'];
                $hangDangGiao = $row['hangDangGiao'];
                $dulieu[] = array('soLuong1' => $soLuong1, 'hangDangGiao' => $hangDangGiao);
            }
            header("Content-Type: application/json; charset=UTF-8");
            echo json_encode($dulieu);
        }
    }

    public function xemALLDonHangforBC($sql){
        $link = $this->connect();
        $result = mysqli_query($link, $sql);
        
        if (!$result) {
            echo json_encode(array('message' => 'Lỗi truy vấn: ' . mysqli_error($link)));
            exit(); 
        }
        
        $numRows = mysqli_num_rows($result);
        if ($numRows > 0) {
            $data = array();
            
            while ($row = mysqli_fetch_assoc($result)) {
                $maBuuCuc = $row['maBuuCuc'];
                $Id_TaoDonHang= $row['Id_TaoDonHang'];
                $tenDonHang = $row['tenDonHang'];
                $Id_TaiKhoan = $row['Id_TaiKhoan'];
                $Id_PhanLoaiNguoiDung= $row['Id_PhanLoaiNguoiDung'];
                $tenDonHang = $row['tenDonHang'];
                $tenNG = $row['tenNG'];
                $tenNN = $row['tenNN'];
                $diaChiNhanGop = $row['diaChiNhanGop'];
                $ngayLapDon = $row['ngayLapDon'];
                $trangThaiDonHang = $row['trangThaiDonHang'];
                $maVanDon = $row['maVanDon'];
                $loaiNguoiDung = $row['loaiNguoiDung'];
                
                $data[] = array(
                    'maBuuCuc' => $maBuuCuc,
                    'Id_TaoDonHang' => $Id_TaoDonHang,
                    'Id_PhanLoaiNguoiDung' => $Id_PhanLoaiNguoiDung,
                    'Id_TaiKhoan' => $Id_TaiKhoan,
                    'tenDonHang' => $tenDonHang,
                    'tenNG' => $tenNG,
                    'tenNN' => $tenNN,
                    'diaChiNhanGop' => $diaChiNhanGop,
                    'ngayLapDon' => $ngayLapDon,
                    'trangThaiDonHang' => $trangThaiDonHang,
                    'maVanDon' => $maVanDon,
                    'loaiNguoiDung' => $loaiNguoiDung
                );
            }
            
            header("Content-Type: application/json; charset=UTF-8");
            echo json_encode($data);
        } else {
            echo json_encode(array('message' => 'Không có dữ liệu'));
        }
    }

    public function selectDonHangforDateofNVGH($sql, $params = array()) {
        $link = $this->connect();
        $stmt = mysqli_prepare($link, $sql);
        
        if (!$stmt) {
            echo json_encode(array('message' => 'Lỗi truy vấn: ' . mysqli_error($link)));
            exit(); 
        }
    
        if (!empty($params)) {
            mysqli_stmt_bind_param($stmt, $params[0], ...array_slice($params, 1));
        }
    
        $result = mysqli_stmt_execute($stmt);
        
        if (!$result) {
            echo json_encode(array('message' => 'Lỗi truy vấn: ' . mysqli_stmt_error($stmt)));
            exit(); 
        }
    
        $data = array();
        $resultSet = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($resultSet)) {
            $data[] = $row;
        }
    
        mysqli_stmt_close($stmt);
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($data);
    }
    
    public function xemDoanhThuCaNhan($sql, $params = array()) {
        $link = $this->connect();
        $stmt = mysqli_prepare($link, $sql);
        
        if (!$stmt) {
            echo json_encode(array('message' => 'Lỗi truy vấn: ' . mysqli_error($link)));
            exit(); 
        }
    
        if (!empty($params)) {
            mysqli_stmt_bind_param($stmt, $params[0], ...array_slice($params, 1));
        }
    
        $result = mysqli_stmt_execute($stmt);
        
        if (!$result) {
            echo json_encode(array('message' => 'Lỗi truy vấn: ' . mysqli_stmt_error($stmt)));
            exit(); 
        }
    
        $data = array();
        $resultSet = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($resultSet)) {
            $data[] = $row;
        }
    
        mysqli_stmt_close($stmt);
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($data);
    }

    public function xemDonHangThanhToan($sql, $params = array()){
        $link = $this->connect();
        $stmt = mysqli_prepare($link, $sql);
        if (!$stmt) {
            echo json_encode(array('message' => 'Lỗi truy vấn: ' . mysqli_error($link)));
            exit(); 
        }
        if (!empty($params)) {
            mysqli_stmt_bind_param($stmt, $params[0], ...array_slice($params, 1));
        }
        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            echo json_encode(array('message' => 'Lỗi truy vấn: ' . mysqli_stmt_error($stmt)));
            exit(); 
        }
        $data = array();
        $resultSet = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($resultSet)) {
            $data[] = $row;
        }
        mysqli_stmt_close($stmt);
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($data);
    }

    public function xemDHforCaNhan($sql, $params = array()){
        $link = $this->connect();
        $stmt = mysqli_prepare($link, $sql);
        if (!$stmt) {
            echo json_encode(array('message' => 'Lỗi truy vấn: ' . mysqli_error($link)));
            exit(); 
        }
        if (!empty($params)) {
            mysqli_stmt_bind_param($stmt, $params[0], ...array_slice($params, 1));
        }
        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            echo json_encode(array('message' => 'Lỗi truy vấn: ' . mysqli_stmt_error($stmt)));
            exit(); 
        }
        $data = array();
        $resultSet = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($resultSet)) {
            $data[] = $row;
        }
        mysqli_stmt_close($stmt);
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($data);
    }

    public function xemDHofCaNhanforCancel($sql, $params = array()){
        $link = $this->connect();
        $stmt = mysqli_prepare($link, $sql);
        if (!$stmt) {
            echo json_encode(array('message' => 'Lỗi truy vấn: ' . mysqli_error($link)));
            exit(); 
        }
        if (!empty($params)) {
            mysqli_stmt_bind_param($stmt, $params[0], ...array_slice($params, 1));
        }
        $result = mysqli_stmt_execute($stmt);
        if (!$result) {
            echo json_encode(array('message' => 'Lỗi truy vấn: ' . mysqli_stmt_error($stmt)));
            exit(); 
        }
        $data = array();
        $resultSet = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($resultSet)) {
            $data[] = $row;
        }
        mysqli_stmt_close($stmt);
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($data);
    }
}
?>