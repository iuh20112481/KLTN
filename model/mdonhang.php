<?php
include_once "connect1.php";

    class model_donhang {

        function getAddressByUserId($userId) {
            $p = new connect_db();
            $conn = $p->open_kn();
    
            $query = "SELECT diaChi FROM taikhoan WHERE Id_TaiKhoan = '$userId'";
            $result = mysqli_query($conn, $query);
    
            $address = "";
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $address = $row['diaChi'];
            }
    
            $p->close_kn($conn);
            return $address;
        }
        
        function selectALLDonHangforNVBC($tenbuucuc) {
            $p = new connect_db();
            $conn = $p->open_kn();

            if ($conn) {
                // Sử dụng prepared statement để tránh SQL injection
                $query = "  SELECT DISTINCT
                                taodonhang.Id_TaoDonHang,
                                taodonhang.Id_TaiKhoan,
                                taodonhang.maDonHang,
                                taodonhang.tenDonHang,
                                taodonhang.tenNG,
                                taodonhang.tenNN,
                                CONCAT(
                                    taodonhang.diaChiNhan,
                                    ', ', taodonhang.phuongXaNhan,
                                    ', ', taodonhang.quanHuyenNhan,
                                    ', ', taodonhang.tinhNhan
                                ) AS diaChiNhanGop,
                                taodonhang.ngayLapDon,
                                donhang.trangThaiDonHang,
                                donhang.maVanDon,
                                phanloainguoidung.Id_PhanLoaiNguoiDung,
                                taikhoan.diaChi
                            FROM
                                taodonhang
                            LEFT JOIN
                                donhang
                                ON taodonhang.Id_TaoDonHang = donhang.Id_TaoDonHang
                            LEFT JOIN
                                taikhoan
                                ON taodonhang.Id_TaiKhoan = taikhoan.Id_TaiKhoan
                            LEFT JOIN
                                phanloainguoidung
                                ON taikhoan.Id_TaiKhoan = phanloainguoidung.Id_TaiKhoan
                            WHERE
                                donhang.Id_DonHang IS NULL
                                AND (
                                    ? LIKE CONCAT('%', taodonhang.tinhNhan, '%')
                                    OR ? LIKE CONCAT('%', taodonhang.quanHuyenNhan, '%')
                                )
                            ORDER BY
                                taodonhang.ngayLapDon DESC;
                            ";

                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "ss", $tenbuucuc, $tenbuucuc);
                mysqli_stmt_execute($stmt);
                $tbl = mysqli_stmt_get_result($stmt);
                mysqli_stmt_close($stmt);
                $p->close_kn($conn);
                return $tbl;
            } else {
                return false;
            }
        }
        
        function selectId_TaiKhoan(){
            $p=new connect_db();
            $conn=$p->open_kn();  
            if($conn){
                $query="SELECT Id_TaiKhoan FROM taodonhang";
                $tbl=mysqli_query($conn,$query);
                $p->close_kn($conn);
                return $tbl;
            }
            else{
                return false;
            }
        }

        function insertDonHang($idTaiKhoan, $idTaoDonHang, $mabc , $trangThaiDonHang){
            $p=new connect_db();
            $conn=$p->open_kn();
            if($conn){
                $query="INSERT INTO donhang (Id_TaoDonHang, Id_PhanLoaiNguoiDung, maBuuCuc, trangThaiDonHang, trangThaiLuuKho, ngayPhanHangGiao, ngayBDGiaoHang, maNhanVien) VALUES ('$idTaoDonHang', '$idTaiKhoan', '$mabc', '$trangThaiDonHang','','','','')";
                $result=mysqli_query($conn,$query);
                $p->close_kn($conn);
                return $result;
            }
            else{
                return false;
            }
        }

        function rejectDonHang($idTaiKhoan, $idTaoDonHang, $mabc, $trangthaidonhuy){
            $p=new connect_db();
            $conn=$p->open_kn();
            if($conn){
                $query="INSERT INTO donhang (Id_TaoDonHang, Id_PhanLoaiNguoiDung, maBuuCuc, trangThaiDonHang) VALUES ('$idTaoDonHang', '$idTaiKhoan', '$mabc', '$trangthaidonhuy')";
                $result=mysqli_query($conn,$query);
                $p->close_kn($conn);
                return $result;
            }
            else{
                return false;
            }
        }

        function selectALLDonHangforNVGH($maBuuCuc) {
            $p = new connect_db();
            $conn = $p->open_kn();
        
            if ($conn) {
                $query = "  SELECT 
                                donhang.Id_DonHang,
                                donhang.Id_TaoDonHang,
                                donhang.maVanDon,
                                taodonhang.tenDonHang,
                                CONCAT(
                                    taodonhang.diaChiNhan, 
                                    ', ', taodonhang.phuongXaNhan, 
                                    ', ', taodonhang.quanHuyenNhan, 
                                    ', ', taodonhang.tinhNhan
                                ) AS diaChiNhanGop
                            FROM 
                                donhang 
                            INNER JOIN 
                                taodonhang 
                                ON donhang.Id_TaoDonHang = taodonhang.Id_TaoDonHang
                            WHERE 
                                donhang.maNhanVien = ''
                                AND
                                donhang.maBuucuc = ? ;";
                
                if ($stmt = $conn->prepare($query)) {
                    $stmt->bind_param("s", $maBuuCuc);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $stmt->close();
                    $p->close_kn($conn);
                    return $result;
                } else {
                    // Lỗi trong việc chuẩn bị câu truy vấn
                    $p->close_kn($conn);
                    return false;
                }
            } else {
                return false;
            }
        }
        
        function selectmaNhanVien($idbuucuc){
            $p = new connect_db();
            $conn = $p->open_kn();
            
            if ($conn) {
                $query = " SELECT * 
                            FROM buucuc     
                            WHERE maNhanVien 
                            LIKE '%NVGH%' 
                            AND `Id_TenBC`= ? ;";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $idbuucuc);
                $stmt->execute();
                $result = $stmt->get_result();
                $stmt->close();
                $p->close_kn($conn);
                return $result;
            } else {
                return false;
            }
        }
        
        function updateDonHangforNVGH($idDonHang, $maNhanVien, $ngayPhanHangGiao, $trangThaiDonHangGiao) {
            $p = new connect_db();
            $conn = $p->open_kn();
            
            if ($conn) {
                // Sử dụng prepared statement để tránh tấn công SQL Injection
                $query = "UPDATE `donhang` 
                          SET `maNhanVien` = ?, `ngayPhanHangGiao` = ?, `trangThaiDonHang` = ? 
                          WHERE `Id_TaoDonHang` = ?";
        
                $stmt = mysqli_prepare($conn, $query);
                if ($stmt) {
                    // Gắn các giá trị vào các tham số
                    mysqli_stmt_bind_param($stmt, "sssi", $maNhanVien, $ngayPhanHangGiao, $trangThaiDonHangGiao, $idDonHang);
        
                    // Thực thi câu lệnh
                    mysqli_stmt_execute($stmt);
        
                    // Đóng kết nối và trả về kết quả
                    mysqli_stmt_close($stmt);
                    $p->close_kn($conn);
                    return true;
                } else {
                    // Nếu không thể chuẩn bị câu lệnh, trả về false
                    $p->close_kn($conn);
                    return false;
                }
            } else {
                // Nếu không thể kết nối đến cơ sở dữ liệu, trả về false
                return false;
            }
        }
        
        
        function executeQuery($query) {
            $p = new connect_db(); // Kết nối với cơ sở dữ liệu
            $conn = $p->open_kn(); // Mở kết nối
            $result = mysqli_query($conn, $query); // Thực hiện truy vấn
            $p->close_kn($conn); // Đóng kết nối
            return $result; // Trả về kết quả
        }

        function selectALLDonHangofNVGH($maNhanVien){
            $p = new connect_db();
            $conn = $p->open_kn();
            
            if ($conn) {
                $query = "SELECT
                donhang.Id_DonHang,
                donhang.maVanDon,
                donhang.trangThaiDonHang,
                taodonhang.tenDonHang,
                taodonhang.sdtNN,
                taodonhang.sdtNG,
                CONCAT(
                    taodonhang.diaChiNhan,
                    ', phường ', taodonhang.phuongXaNhan,
                    ', ', taodonhang.quanHuyenNhan,
                    ', ', taodonhang.tinhNhan
                ) AS diaChiNhanGop
            FROM
                donhang
            INNER JOIN
                taodonhang
                ON donhang.Id_TaoDonHang = taodonhang.Id_TaoDonHang
            WHERE
                donhang.maNhanVien = '$maNhanVien'
                AND
                    donhang.trangThaiDonHang IN ('', 'Đang giao');
            "; 
                $tbl = mysqli_query($conn, $query);
                $p->close_kn($conn);
                return $tbl; 
            } else {
                return false; 
            }
        }

        function selectmaNhanVienbyidTaiKhoan($idTaiKhoan){
            $p = new connect_db();
            $conn = $p->open_kn();
            
            if ($conn) {
                $query = "  SELECT 
                            buucuc.maNhanVien ,
                            tenbc.diaChiBC,
                            buucuc.maBuuCuc
                            FROM buucuc 
                            LEFT JOIN 
                            tenbc
                            ON buucuc.Id_TenBC = tenbc.Id_TenBC
                            WHERE Id_TaiKhoan='$idTaiKhoan';
                        ";
                $tbl = mysqli_query($conn, $query);
                $p->close_kn($conn);
                return $tbl; 
            } else {
                return false; 
            }
        }

        function updateDonHangofNVGH($idDonHang, $maNhanVien, $trangThaiDonHang, $ngayHTGiaoHang) {
            $p = new connect_db();
            $conn = $p->open_kn();

            if ($conn) {
                // Nếu trạng thái là "Đã giao", tính toán hoa hồng theo phần trăm
                if ($trangThaiDonHang == 'Đã giao') {
                    // Lấy thông tin đơn hàng: giá vận chuyển và tỷ lệ hoa hồng
                    $queryInfo = "SELECT
                                    tdh.giaVanChuyen,
                                    bc.hoaHongMoiDon as tyLeHoaHong
                                  FROM donhang dh
                                  JOIN taodonhang tdh ON dh.Id_TaoDonHang = tdh.Id_TaoDonHang
                                  JOIN buucuc bc ON dh.maNhanVien = bc.maNhanVien
                                  WHERE dh.Id_DonHang = ?";

                    $stmtInfo = mysqli_prepare($conn, $queryInfo);
                    mysqli_stmt_bind_param($stmtInfo, "i", $idDonHang);
                    mysqli_stmt_execute($stmtInfo);
                    $resultInfo = mysqli_stmt_get_result($stmtInfo);

                    if ($rowInfo = mysqli_fetch_assoc($resultInfo)) {
                        // Lấy giá vận chuyển (doanh thu) và tỷ lệ phần trăm
                        $giaVanChuyen = (float)$rowInfo['giaVanChuyen'];
                        $tyLeHoaHong = (float)$rowInfo['tyLeHoaHong'];

                        // Tính hoa hồng: Tiền hoa hồng = Doanh thu × (Tỷ lệ % / 100)
                        $hoaHongShipper = $giaVanChuyen * ($tyLeHoaHong / 100);

                        // Update với hoa hồng và lưu snapshot tỷ lệ
                        $query = "UPDATE donhang
                                  SET trangThaiDonHang = ?,
                                      ngayHTGiaoHang = ?,
                                      tyLeHoaHong = ?,
                                      hoaHongShipper = ?
                                  WHERE Id_DonHang = ?
                                  AND maNhanVien = ?";

                        $stmt = mysqli_prepare($conn, $query);
                        mysqli_stmt_bind_param($stmt, "ssddis",
                            $trangThaiDonHang,
                            $ngayHTGiaoHang,
                            $tyLeHoaHong,
                            $hoaHongShipper,
                            $idDonHang,
                            $maNhanVien
                        );
                    } else {
                        // Không tìm thấy thông tin, update bình thường
                        $query = "UPDATE donhang
                                  SET trangThaiDonHang = ?, ngayHTGiaoHang = ?
                                  WHERE Id_DonHang = ?
                                  AND maNhanVien = ?";
                        $stmt = mysqli_prepare($conn, $query);
                        mysqli_stmt_bind_param($stmt, "ssis", $trangThaiDonHang, $ngayHTGiaoHang, $idDonHang, $maNhanVien);
                    }

                    mysqli_stmt_close($stmtInfo);
                } else {
                    // Trạng thái khác "Đã giao", update bình thường
                    $query = "UPDATE donhang
                              SET trangThaiDonHang = ?, ngayHTGiaoHang = ?
                              WHERE Id_DonHang = ?
                              AND maNhanVien = ?";
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, "ssis", $trangThaiDonHang, $ngayHTGiaoHang, $idDonHang, $maNhanVien);
                }

                if ($stmt) {
                    $result = mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                } else {
                    return false;
                }

                $p->close_kn($conn);
                return $result;
            } else {
                return false;
            }
        }
        
        function selectALLDonHangofNVGHactioned($maNhanVien){
            $p = new connect_db();
            $conn = $p->open_kn();
            
            if ($conn) {
                $query = "SELECT 
                donhang.Id_DonHang,
                donhang.maVanDon,
                taodonhang.tenDonHang,
                taodonhang.sdtNN,
                taodonhang.sdtNG,
                donhang.trangThaiDonHang,
                CONCAT(
                    taodonhang.diaChiNhan, 
                    ', phường ', taodonhang.phuongXaNhan, 
                    ', ', taodonhang.quanHuyenNhan, 
                    ', ', taodonhang.tinhNhan
                ) AS diaChiNhanGop
            FROM 
                donhang 
            INNER JOIN 
                taodonhang 
                ON donhang.Id_TaoDonHang = taodonhang.Id_TaoDonHang
            WHERE 
                donhang.maNhanVien = '$maNhanVien';
            "; 
                $tbl = mysqli_query($conn, $query);
                $p->close_kn($conn);
                return $tbl; 
            } else {
                return false; 
            }
        }

        function sortMAXNVGH() {
            $p = new connect_db();
            $conn = $p->open_kn();
            if ($conn) {
                $query = "SELECT maNhanVien 
                FROM buucuc 
                WHERE CAST(SUBSTRING(maNhanVien, LENGTH('NVGH-HCM-NVBGV-') + 2) AS SIGNED) 
                = ( SELECT MAX(CAST(SUBSTRING(maNhanVien, LENGTH('NVGH-HCM-NVBGV-') + 2) AS SIGNED)) FROM buucuc );";
                $tbl = mysqli_query($conn, $query);
                $p->close_kn($conn);
                return $tbl;
            } else {
                return false;
            }
        }

        function DoanhthuBC($maBuuCuc){
            $p = new connect_db();
            $conn = $p->open_kn();
            if ($conn) {
                $query = " SELECT COUNT(taodonhang.giaVanChuyen) AS soLuong, SUM(taodonhang.giaVanChuyen) AS tongGiaVanChuyen
                           FROM 
                            taodonhang 
                           JOIN 
                            donhang ON taodonhang.Id_TaoDonHang = donhang.Id_TaoDonHang 
                           WHERE 
                            donhang.maBuuCuc = '$maBuuCuc' 
                           AND donhang.trangThaiDonHang = 'Đã giao';      
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
