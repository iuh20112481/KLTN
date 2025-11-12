<?php
class docapiBCDT {
    private function getdatabyurl($url) {
        $client = curl_init($url);
        curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($client);
        $results = json_decode($response);
        return $results;
    }

    public function xuatBCDT($url) {
        $results = $this->getdatabyurl($url);
        
        // Kiểm tra xem kết quả có phải là một mảng không
        if (is_array($results)) {
            echo '
                <table width="500px" border="1" style="border-collapse: collapse;">
                    <tbody>
                        <tr>
                            <td>Số lượng</td>
                            <td>Tổng giá vận chuyển</td>
                        </tr>
            ';

            // Lặp qua từng phần tử của mảng kết quả
            foreach ($results as $data) {
                // Kiểm tra xem phần tử có thuộc tính 'soLuong' và 'tongGiaVanChuyen' không
                if (isset($data->soLuong) && isset($data->tongGiaVanChuyen)) {
                    echo '
                        <tr>
                            <td>' . $data->soLuong . '</td>
                            <td>' . $data->tongGiaVanChuyen . '</td>
                        </tr>
                    ';
                }
            }

            echo '
                    </tbody>
                </table>
            ';
        } else {
            echo 'Dữ liệu không hợp lệ ';
        }
    }
}
?>
