<?php
include_once "connect2.php";

class model_dk {
    function insertTK($name, $phone, $mk, $mail, $mucdichsudung, $classification, $quymovanchuyen){
        $p = new connect_db();
        $conn = $p->open_kn(); // Mở kết nối

        $string = "INSERT INTO taikhoan(tenND, sdtND, mkND, emailND, mucDichSuDung, nganhHang, quyMoVanChuyen)
        VALUES ('".$name."', '".$phone."',  '".$mk."','".$mail."', '".$mucdichsudung."', '".$classification."','".$quymovanchuyen."')";
        $result = mysqli_query($conn, $string);

        $p->close_kn($conn); // Đóng kết nối

        return $result;
    }

    function selectSdt($phone){
        $p = new connect_db();
        $conn = $p->open_kn(); // Mở kết nối

        $query = "SELECT *
        FROM `taikhoan`
        WHERE `sdtND` = '".$phone."'";
        $tbl = mysqli_query($conn, $query);

        $p->close_kn($conn); // Đóng kết nối

        return $tbl;
    }
}

?>
