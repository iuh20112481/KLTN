<?php
include_once("connectAPI.php");

$p = new cnmoi();
$maVanDon = isset($_REQUEST['maVanDon']) ? $_REQUEST['maVanDon'] : null;
if ($maVanDon !== null) {
    $p->searchByMaVanDon($maVanDon);
} else {
    echo json_encode(array('message' => 'Vui lòng cung cấp mã vận đơn'));
}
?>