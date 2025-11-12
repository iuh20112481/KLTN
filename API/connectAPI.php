<?php
class cnmoi{

    public function connect(){
        $con = mysqli_connect("localhost", "root", "", "HPship");
        if (!$con) {
            echo 'Không kết nối được CSDL';
            exit();
        } else {
            mysqli_set_charset($con, "UTF8");
            return $con;
        }
    }

    public function searchByMaVanDon($sql){
        $link = $this->connect();
        $ketqua = mysqli_query($link, $sql);
        if (!$ketqua) {
            echo json_encode(array('message' => 'Query error: ' . mysqli_error($link)));
            exit(); 
        }
    
        $i = mysqli_num_rows($ketqua);
        if ($i > 0) {
            $dulieu = array();
            while ($row = mysqli_fetch_assoc($ketqua)) {
                $tenDonHang = isset($row['tenDonHang']) ? $row['tenDonHang'] : null;
                $tenng = isset($row['tenNG']) ? $row['tenNG'] : null;
                $tennn = isset($row['tenNN']) ? $row['tenNN'] : null;
                $sdtng = isset($row['sdtNG']) ? $row['sdtNG'] : null;
                $giaVanChuyen = isset($row['giaVanChuyen']) ? $row['giaVanChuyen'] : null;
                $trangThaiLuuKho = isset($row['trangThaiLuuKho']) ? $row['trangThaiLuuKho'] : null;
                $tenBuuCuc = isset($row['tenBuuCuc']) ? $row['tenBuuCuc'] : null;
                $ngayBDGiaoHang = isset($row['ngayBDGiaoHang']) ? $row['ngayBDGiaoHang'] : null;
                $trangThaiDonHang = isset($row['trangThaiDonHang']) ? $row['trangThaiDonHang'] : null;
                $maVanDon = $row['maVanDon'];
                $dulieu[] = array('maVanDon' => $maVanDon, 'tenDonHang' => $tenDonHang, 'trangThaiDonHang' => $trangThaiDonHang, 
                                    'tenng' => $tenng, 'tennn' => $tennn, 'sdtng' => $sdtng, 'giaVanChuyen' => $giaVanChuyen, 
                                    'trangThaiLuuKho' => $trangThaiLuuKho, 'ngayBDGiaoHang' => $ngayBDGiaoHang , 'tenBuuCuc' => $tenBuuCuc);
            }
            header("Content-Type: application/json; charset=UTF-8");
            echo json_encode($dulieu);
        } else {
            echo json_encode(array('message' => 'Không có dữ liệu'));
        }
    }
    // function xemDoanhThuBC 
}
?>

<?php
    $p = new cnmoi();
    $maVanDon = isset($_REQUEST['maVanDon']) ? $_REQUEST['maVanDon'] : null;
    if ($maVanDon !== null) {
        $p->searchByMaVanDon("SELECT  DISTINCT
        taodonhang.tenDonHang,
        taodonhang.tenNG,
        taodonhang.tenNN,
        taodonhang.sdtNG,
        taodonhang.giaVanChuyen,  
        donhang.trangThaiLuuKho,
        donhang.ngayBDGiaoHang,
        donhang.maVanDon,
        donhang.trangThaiDonHang,
        tenbc.tenBuuCuc
    FROM 
        donhang 
    LEFT JOIN 
        taodonhang 
    ON 
        donhang.Id_TaoDonHang = taodonhang.Id_TaoDonHang
    LEFT JOIN
        buucuc 
    ON
        buucuc.maBuuCuc = donhang.maBuuCuc
    LEFT JOIN 
    	tenbc
    ON
    	tenbc.Id_TenBC = buucuc.Id_TenBC
    WHERE 
        donhang.maVanDon = '$maVanDon' 
    ORDER BY 
        donhang.maVanDon ASC;
    ");
    } else {
        echo json_encode(array('message' => 'Vui lòng cung cấp mã vận đơn'));
    }
?>
