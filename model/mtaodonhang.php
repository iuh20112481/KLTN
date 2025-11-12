<?php 
include_once "connect1.php";

class model_taodonhang {

    function addTaoDonHang($tenng, $tennn, $dcng, $dcnn, $telng, $telnn, 
                            $lvl1, $lvl2, $lvl3, $lvl1_1, $lvl2_1, $lvl3_1, 
                            $tensp, $madh, $soluong, $khoiluong,
                              $chieudai, $chieurong, $chieucao, 
                              $giaohang, $ghichu, $mand, $ngay, $classification, $phithuho, $giavanchuyen)
    {
        $p = new connect_db();
        $conn = $p->open_kn();
        if ($conn) {

            $string = "INSERT INTO `HPship`.`taodonhang` (
                `tenDonHang` ,
                `loaiDonHang` ,
                `soLuong` ,
                `khoiLuong` ,
                `phiThuHo` ,
                `hinhThucVanChuyen` ,
                `moTa` ,
                `tenNG` ,
                `tenNN` ,
                `sdtNG` ,
                `sdtNN` ,
                `diaChiGiao` ,
                `diaChiNhan` ,
                `quanHuyenGiao` ,
                `quanHuyenNhan` ,
                `phuongXaGiao` ,
                `phuongXaNhan` ,
                `maDonHang` ,
                `Id_TaiKhoan` ,
                `ngayLapDon` ,
                `tinhGiao` ,
                `tinhNhan` ,
                `chieuDai` ,
                `chieuCao` ,
                `chieuRong`,
                `giaVanChuyen`
                )
            VALUES ('".$tensp."', '".$classification."', '".$soluong."', '".$khoiluong."', '".$phithuho."',
                     '".$giaohang."', '".$ghichu."', '".$tenng."', '".$tennn."', '".$telng."', '".$telnn."',
                      '".$dcng."', '".$dcnn."', '".$lvl2."', '".$lvl2_1."', '".$lvl3."', '".$lvl3_1."', '".$madh."',
                       '".$mand."', '".$ngay."', '".$lvl1."', '".$lvl1_1."', '".$chieudai."', '".$chieucao."', '".$chieurong."', '".$giavanchuyen."')";
            
            $result = mysqli_query($conn, $string);
            
            if ($result) {
                // Thực hiện các công việc khác sau khi thêm dữ liệu thành công

                // Đóng kết nối sau khi hoàn thành tác vụ
                $p->close_kn($conn);
                return true;
            } else {
                // Xử lý lỗi khi không thể thêm dữ liệu vào cơ sở dữ liệu
                echo "<script>alert('Không thêm được đơn hàng')</script>";
                $p->close_kn($conn);
                return false;
            }
        } else {
            // Xử lý lỗi kết nối
            echo "<script>alert('Lỗi kết nối')</script>";
            return false;
        }
    }
}
?>
       