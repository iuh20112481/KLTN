<?php
include_once ("../model/m_u_donhang.php");

class control_user_donhang {
    function getAllDonHangND() {
        $p = new model_donhangND();
                $tbltq = $p->selectAllDonHangND(); 
                if (!$tbltq) {
            return false;
        } else {
            if (mysqli_num_rows($tbltq) > 0) {
                return $tbltq;
            } else {
                return 0;
            }
        }
    }
}
?>
