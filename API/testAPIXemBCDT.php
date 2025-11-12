<?php
session_start(); // Bắt buộc khi sử dụng session

// Lấy giá trị của maBuuCuc từ session
$maBuuCuc = $_SESSION['buu_cuc_info']['maBuuCuc'];

// Chuyển đổi giá trị của maBuuCuc sang JavaScript
echo "<script> var maBuuCuc = " . json_encode($maBuuCuc) . ";</script>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem Doanh Thu</title>
</head>
<body>
    <h2>Doanh Thu</h2>
    <p>Số Lượng: <span id="soLuong"></span></p>
    <p>Tổng Giá Vận Chuyển: <span id="tongGiaVanChuyen"></span></p>

    <script>
        // Định nghĩa hàm để gọi API
        function getDoanhThuFromAPI(maBuuCuc) {
            // Gửi yêu cầu AJAX đến API
            fetch('http://localhost:8080/WEBSITE_EXHIBITION/API/xemDoanhThuBC.php?maBuuCuc=' + maBuuCuc)
                .then(response => response.json()) // Chuyển đổi response sang JSON
                .then(data => {
                    // Xử lý dữ liệu được trả về từ API
                    console.log(data);
                    // Hiển thị dữ liệu trong trang HTML
                    let formattedDoanhThu = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(data.tongGiaVanChuyen);
                    document.getElementById('soLuong').innerText = data.soLuong;
                    document.getElementById('tongGiaVanChuyen').innerText = formattedDoanhThu;        
                })
                .catch(error => {
                    // Xử lý lỗi nếu có
                    console.error('Lỗi:', error);
                });
        }

        // Gọi hàm để lấy doanh thu khi trang được tải
        window.onload = function() {
            getDoanhThuFromAPI(maBuuCuc); 
        };
    </script>
</body>
</html>
