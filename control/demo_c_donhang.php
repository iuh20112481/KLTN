<?php
include_once "../model/connect1.php"; 
include_once "../control/cdangnhap.php";
$conn = connect_db::open_kn1();

// Xử lý khi người dùng nhấn nút gửi
if (isset($_POST['btnsubmit'])) {
    foreach ($_POST['order'] as $orderId => $data) {
        $idTaiKhoan = $data['Id_PhanLoaiNguoiDung'];
        $action = $data['action'];
        // Kiểm tra hành động
        if ($action === 'accept') {
            $sql = "INSERT INTO donhang (Id_TaoDonHang, Id_PhanLoaiNguoiDung) VALUES ('$orderId', '$idTaiKhoan')";
            if(mysqli_query($conn, $sql)) {
                echo "Dữ liệu đã được insert thành công.";
            } else {
                echo "Lỗi: " . mysqli_error($conn);
            }
        } elseif ($action === 'reject') {

            echo'HỦy ';
        }
    }
}

// Đóng kết nối cơ sở dữ liệu
connect_db::close_kn1($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            text-align: center;
        }
        th, td {
            border: 1px solid #770101;
            padding: 8px;
        }
        #select, #ngay {
            text-align: center;
            border-radius: 5px;
        }
        tr:hover {
            background-color: #eafcff;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php
    class docAPIdsdonhang{
        // Hàm để lấy dữ liệu từ API
        private function getdatabyurl($url){
            $client = curl_init($url);
            curl_setopt($client, CURLOPT_RETURNTRANSFER,1);
            $response=curl_exec($client);
            $results = json_decode($response);
            return $results;
        }

        // Hàm để hiển thị dữ liệu từ API trong bảng
        public function xuatdsAPIdonhang($url) {
            $results = $this->getdatabyurl($url);

            echo '<form id="orderForm" method="POST" action="#">
                <table id="orderTable">
                    <thead >
                        <tr style="background-color: #cce400">
                            <th>ID đơn hàng</th>
                            <th>Tên đơn hàng</th>
                            <th>Người gửi</th>
                            <th>Người nhận</th>
                            <th>Địa chỉ người nhận</th>
                            <th>Ngày lập đơn giao</th>
                            <th>Chấp nhận/Từ chối đơn hàng</th>
                        </tr>
                    ';
            foreach($results as $data){
                echo '<tr>
                        <td>'.$data->Id_TaoDonHang.'</td>   
                        <td>'.$data->tenDonHang.'</td>
                        <td>'.$data->tenNG.'</td>
                        <td>'.$data->tenNN.'</td>
                        <td>'.$data->diaChiNhanGop.'</td>
                        <td id="ngay">'.$data->ngayLapDon.'</td> 
                        <td id="select">
                            <select name="order['.$data->Id_TaoDonHang.'][action]">
                                <option value="accept">Chấp nhận</option>
                                <option value="reject">Từ chối</option>
                            </select>
                            <input type="hidden" name="order['.$data->Id_TaoDonHang.'][Id_PhanLoaiNguoiDung]" value="'.$data->Id_PhanLoaiNguoiDung.'">
                        </td>                 
                    </tr>';
            }
            echo '</thead>
                </table>
                <input type="submit" value="Gửi" name="btnsubmit" />
                </form>';       
        }
    }

    ?>
</body>
</html>
