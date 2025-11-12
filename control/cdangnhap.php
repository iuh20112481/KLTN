<?php

include("../model/mdangnhap.php");

class control_dn {
    function getDn($sdt, $mk) {
        $p = new model_dn();
        return $p->selectNd($sdt, $mk);
    }

    function checkUserRoles($sdt, $mk) {
        $p = new model_dn();
        $userRole = $p->selectUserRoles($sdt, $mk);
        return $userRole;
    } 

    function getBuuCucInfo($idTaiKhoan) {
        $p = new model_dn();
        return $p->getBuuCucInfo($idTaiKhoan);
    }
    
}
?>
