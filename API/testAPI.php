<?php
include_once("connectAPI.php");
$p=new cnmoi();
$p->search("select *from donhang order by maVanDon asc");

?>