<?php 
class cmnoii {
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
            // Hiển thị thông tin lỗi
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
            header("Content-Type: application/json; charset=UTF-8"); // Sửa lỗi chính tả và định dạng header
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
            header("Content-Type: application/json; charset=UTF-8"); // Sửa lỗi chính tả và định dạng header
            echo json_encode($dulieu);
        }
    }

    public function xemALLDonHangforBC($sql){
        // Thiết lập kết nối tới cơ sở dữ liệu
        $link = $this->connect();
        
        // Thực thi truy vấn SQL được cung cấp
        $result = mysqli_query($link, $sql);
        
        // Kiểm tra lỗi khi thực thi truy vấn
        if (!$result) {
            echo json_encode(array('message' => 'Lỗi truy vấn: ' . mysqli_error($link)));
            exit(); 
        }
        
        // Kiểm tra có dữ liệu trả về không
        $numRows = mysqli_num_rows($result);
        if ($numRows > 0) {
            // Khởi tạo một mảng để lưu trữ dữ liệu được truy vấn
            $data = array();
            
            // Lặp qua từng dòng kết quả và lấy dữ liệu cần thiết
            while ($row = mysqli_fetch_assoc($result)) {
                // Trích xuất dữ liệu từ mỗi dòng
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
                
                // Thêm dữ liệu đã trích xuất vào mảng kết quả
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
            
            // Đặt tiêu đề phản hồi thành định dạng JSON
            header("Content-Type: application/json; charset=UTF-8");
            
            // Chuyển đổi mảng kết quả thành JSON và xuất ra
            echo json_encode($data);
        } else {
            // Nếu không có dữ liệu trả về, xuất thông báo không có dữ liệu
            echo json_encode(array('message' => 'Không có dữ liệu'));
        }
    }

    public function selectDonHangforDateofNVGH($sql, $params = array()) {
        // Thiết lập kết nối tới cơ sở dữ liệu
        $link = $this->connect();
        
        // Chuẩn bị câu truy vấn SQL với các tham số dấu chấm hỏi
        $stmt = mysqli_prepare($link, $sql);
        
        // Kiểm tra lỗi khi chuẩn bị câu truy vấn
        if (!$stmt) {
            echo json_encode(array('message' => 'Lỗi truy vấn: ' . mysqli_error($link)));
            exit(); 
        }
    
        // Bind các giá trị vào câu truy vấn
        if (!empty($params)) {
            mysqli_stmt_bind_param($stmt, $params[0], ...array_slice($params, 1));
        }
    
        // Thực thi truy vấn SQL
        $result = mysqli_stmt_execute($stmt);
        
        // Kiểm tra lỗi khi thực thi truy vấn
        if (!$result) {
            echo json_encode(array('message' => 'Lỗi truy vấn: ' . mysqli_stmt_error($stmt)));
            exit(); 
        }
    
        // Lấy kết quả từ câu truy vấn
        $data = array();
        $resultSet = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($resultSet)) {
            $data[] = $row;
        }
    
        // Đóng câu truy vấn
        mysqli_stmt_close($stmt);
    
        // Đặt tiêu đề phản hồi thành định dạng JSON
        header("Content-Type: application/json; charset=UTF-8");
        
        // Chuyển đổi mảng kết quả thành JSON và xuất ra
        echo json_encode($data);
    }
    
    public function xemDoanhThuCaNhan($sql, $params = array()) {
        // Thiết lập kết nối tới cơ sở dữ liệu
        $link = $this->connect();
        
        // Chuẩn bị câu truy vấn SQL với các tham số dấu chấm hỏi
        $stmt = mysqli_prepare($link, $sql);
        
        // Kiểm tra lỗi khi chuẩn bị câu truy vấn
        if (!$stmt) {
            echo json_encode(array('message' => 'Lỗi truy vấn: ' . mysqli_error($link)));
            exit(); 
        }
    
        // Bind các giá trị vào câu truy vấn
        if (!empty($params)) {
            mysqli_stmt_bind_param($stmt, $params[0], ...array_slice($params, 1));
        }
    
        // Thực thi truy vấn SQL
        $result = mysqli_stmt_execute($stmt);
        
        // Kiểm tra lỗi khi thực thi truy vấn
        if (!$result) {
            echo json_encode(array('message' => 'Lỗi truy vấn: ' . mysqli_stmt_error($stmt)));
            exit(); 
        }
    
        // Lấy kết quả từ câu truy vấn
        $data = array();
        $resultSet = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($resultSet)) {
            $data[] = $row;
        }
    
        // Đóng câu truy vấn
        mysqli_stmt_close($stmt);
    
        // Đặt tiêu đề phản hồi thành định dạng JSON
        header("Content-Type: application/json; charset=UTF-8");
        
        // Chuyển đổi mảng kết quả thành JSON và xuất ra
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