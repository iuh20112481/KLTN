<?php
// Bao gồm model
include_once("../model/mtaodonhang.php");

class control_taodonhang {

    // Phương thức chèn dữ liệu vào đơn hàng
    function insertTaoDonHang(
        $tenng, $tennn, $dcng, $dcnn, $telng, $telnn,
        $lvl1, $lvl2, $lvl3, $lvl1_1, $lvl2_1, $lvl3_1,
        $tensp, $madh, $soluong, $khoiluong, $chieudai, 
        $chieurong, $chieucao, $giaohang, $ghichu, $mand, 
        $ngay, $classification, $phithuho, $giavanchuyen
    ) {
        // Tạo instance của model_taodonhang
        $p = new model_taodonhang();

        // Thực hiện thao tác thêm dữ liệu
        $rs = $p->addTaoDonHang(
            $tenng, $tennn, $dcng, $dcnn, $telng, $telnn, 
            $lvl1, $lvl2, $lvl3, $lvl1_1, $lvl2_1, $lvl3_1,
            $tensp, $madh, $soluong, $khoiluong, $chieudai,
            $chieurong, $chieucao, $giaohang, $ghichu, $mand,
            $ngay, $classification, $phithuho, $giavanchuyen
        );

        // Kiểm tra kết quả và trả về
        if (!$rs) {
            return 0; // Thêm thất bại
        } else {
            return 1; // Thêm thành công
        }
    }
}
?>
