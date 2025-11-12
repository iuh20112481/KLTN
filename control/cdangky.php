<?php 
include("../model/mdangky.php");

class control_dk {
    function addTK($name, $phone, $mk, $mail, $mucdichsudung, $classification, $quymovanchuyen)
    {
        $p = new model_dk();
        $rs = $p->insertTK($name, $phone, $mk, $mail, $mucdichsudung, $classification, $quymovanchuyen);
        if (!$rs) {
            return 0;
        } else {
            return 1;
        }
    }
    

    function getSdt($phone) {
        // Kiểm tra dữ liệu đầu vào
        if (empty($phone)) {
            return -1; 
        }

        $p = new model_dk();
        $tblProduct = $p->selectSdt($phone);
        if (!$tblProduct) {
            return false;
        } else {
            return $tblProduct;
        }
    }
}
?>
