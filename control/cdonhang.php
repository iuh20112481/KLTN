<?php
include_once ("../model/mdonhang.php");

    class control_donhang {

        function getAllDonHangforNVBC($tenbuucuc) {

            $p = new model_donhang();
                    $tblDH = $p->selectALLDonHangforNVBC($tenbuucuc); 
                    if (!$tblDH) {
                return false;
            } else {
                if (mysqli_num_rows($tblDH) > 0) {
                    return $tblDH;
                } else {
                    return 0;
                }
            }
        }

        function getId_TaiKhoan(){
            $p=new model_donhang();
            $tbl=$p->selectId_TaiKhoan();
            if(!$tbl){
                return false;
            }
            else{
                if(mysqli_num_rows($tbl)>0){
                    return $tbl;
                }
                else{
                    return 0;
                }
            }
        }

        function insertDonHang($idTaiKhoan, $idTaoDonHang, $mabc , $trangThaiDonHang){
            $p=new model_donhang();
            $tbl=$p->insertDonHang($idTaiKhoan, $idTaoDonHang,$mabc,$trangThaiDonHang);
            if(!$tbl){
                return false;
            }
            else{
                return $tbl;
            }
        }

        function rejectDonHang($idTaiKhoan, $idTaoDonHang, $mabc, $trangthaidonhuy){
            $p=new model_donhang();
            $tbl=$p->rejectDonHang($idTaiKhoan, $idTaoDonHang ,$mabc ,$trangthaidonhuy);
            if(!$tbl){
                return false;
            }
            else{
                return $tbl;
            }
        }

        function getAllDonHangforNVGH($maBuuCuc){

            $p = new model_donhang();
                    $tblDH = $p->selectALLDonHangforNVGH($maBuuCuc); 
                    if (!$tblDH) {
                return false;
            } else {
                if (mysqli_num_rows($tblDH) > 0) {
                    return $tblDH;
                } else {
                    return 0;
                }
            }
        }

        function getmaNhanVien($idbuucuc){
            $p = new model_donhang();
                    $tblDH = $p->selectmaNhanVien($idbuucuc); 
                    if (!$tblDH) {
                return false;
            } else {
                if (mysqli_num_rows($tblDH) > 0) {
                    return $tblDH;
                } else {
                    return 0;
                }
            }
        }

        function getmaNhanVienbyidTaiKhoan($idTaiKhoan){
            $p=new model_donhang();
            $tbl=$p->selectmaNhanVienbyidTaiKhoan($idTaiKhoan);
            if(!$tbl){
                return false;
            }
            else{
                if(mysqli_num_rows($tbl)>0){
                    return $tbl;
                }
                else{
                    return 0;
                }
            }
        }

        function getALLDonHangofNVGH($maNhanVien){
            $p=new model_donhang();
            $tbl=$p->selectALLDonHangofNVGH($maNhanVien);
            if(!$tbl){
                return false;
            }
            else{
                if(mysqli_num_rows($tbl)>0){
                    return $tbl;
                }
                else{
                    return 0;
                }
            }
        }
        
        function updateDonHangforNVGH($idDonHang, $maNhanVien, $ngayPhanHangGiao, $trangThaiDonHangGiao) {
            $p = new model_donhang();
            $tbl = $p->updateDonHangforNVGH($idDonHang, $maNhanVien, $ngayPhanHangGiao , $trangThaiDonHangGiao);
            if (!$tbl) {
                return false;
            } else {
                return $tbl;
            }
        }        

        function checkIfAccepted($idTaoDonHang) {
            $p = new model_donhang(); 
            $query = "SELECT * FROM `donhang` WHERE `Id_TaoDonHang` = '$idTaoDonHang'"; 
    
            $result = $p->executeQuery($query); 
            if ($result && mysqli_num_rows($result) > 0) { 
                return true; 
            }
            return false; 
        }

        function updateDonHangofNVGH($idDonHang, $maNhanVien, $trangThaiDonHang, $ngayHTGiaoHang) {
                $p=new model_donhang();
                $tbl=$p->updateDonHangofNVGH($idDonHang, $maNhanVien, $trangThaiDonHang,$ngayHTGiaoHang);
                if(!$tbl){
                    return false;
                }
                else{
                    return $tbl;
                }
        }

        function getsortMAXNVGH(){
            $p=new model_donhang();
            $tbl=$p->sortMAXNVGH();
            if(!$tbl){
                return false;
            }
            else{
                if(mysqli_num_rows($tbl)>0){
                    return $tbl;
                }
                else{
                    return 0;
                }
            }
        }

        function getDoanhThuBC($maBuuCuc){
            $p=new model_donhang();
            $tbl=$p->DoanhthuBC($maBuuCuc);
            if(!$tbl){
                return false;
            }
            else{
                if(mysqli_num_rows($tbl)>0){
                    return $tbl;
                }
                else{
                    return 0;
                }
            }
        }

    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['action'] === 'updateDonHangofNVGH') {
            $idDonHang = $_POST['idDonHang'];
            $trangThaiDonHang = $_POST['trangThaiDonHang'];
            $maNhanVien = $_POST['maNhanVien'];
            $ngayHTGiaoHang = $_POST['ngayHTGiaoHang'];
            $p = new control_donhang();
            $result = $p->updateDonHangofNVGH($idDonHang, $maNhanVien, $trangThaiDonHang, $ngayHTGiaoHang);
            if ($result) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('success' => false, 'message' => 'Cập nhật đơn hàng thất bại'));
            }
        }
    }
    
    
?>  

