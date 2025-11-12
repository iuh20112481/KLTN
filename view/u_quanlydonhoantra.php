<?php
if (!isset($_SESSION['nguoidung']['id_user'])) {
    die("id_user is not set in the session."); // Handle the error appropriately
}

$Id_TaiKhoan = $_SESSION['nguoidung']['id_user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="pt-5">
        <h3 id="h2-content" class="pt-5">Danh sách đơn hàng</h3>
        <table id="orderTable" class="nhandonhang">
            <thead>
                <tr>
                    <th class="th-style0">Id_TaoDonHang</th>
                    <th class="th-style0">Mã Đơn Hàng</th>
                    <th class="th-style0">Tên Đơn Hàng</th>
                    <th class="th-style0">Mã Vận Đơn</th>
                    <th class="th-style0">Giá Vận Chuyển</th>
                    <th class="th-style0">Tên Người Nhận</th>
                    <th class="th-style0">Số Điện Thoại Người Nhận</th>
                    <th class="th-style0">Địa Chỉ Nhận</th>
                    <th class="th-style0">Ngày Lập Đơn</th>
                    <th class="th-style0">Ngày HT Giao Hàng</th>
                    <th class="th-style0">Trạng Thái Đơn Hàng</th>
                    <th class="th-style0">Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be inserted here -->
            </tbody>
        </table>
    </div>

    <script>
        var Id_TaiKhoan = <?php echo json_encode($Id_TaiKhoan); ?>;
            
        function fetchData() {
            var baseUrl = 'http://localhost:8080/WEBSITE_EXHIBITION/api/API_xemDHofCaNhanforCancel.php';
            var url = `${baseUrl}?Id_TaiKhoan=${Id_TaiKhoan}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    displayData(data);
                })
                .catch(error => console.error('Error:', error));
        }

        function displayData(data) {
            var tableBody = document.getElementById('orderTable').querySelector('tbody');
            tableBody.innerHTML = '';

            data.forEach(order => {
                var row = document.createElement('tr');
                row.innerHTML = `
                    <td>${order.Id_TaoDonHang}</td>
                    <td>${order.maDonHang}</td>
                    <td>${order.tenDonHang}</td>
                    <td>${order.maVanDon}</td>
                    <td>${order.giaVanChuyen}</td>
                    <td>${order.tenNN}</td>
                    <td>${order.sdtNN}</td>
                    <td>${order.diaChiNhanGop}</td>
                    <td>${order.ngayLapDon}</td>
                    <td>${order.ngayHTGiaoHang}</td>
                    <td>${order.trangThaiDonHang}</td>
                    <td><button onclick="cancelOrder('${order.Id_TaoDonHang}')">Hủy</button></td>
                `;
                tableBody.appendChild(row);
            });
        }

        function cancelOrder(Id_TaoDonHang) {
            var baseUrl = 'http://localhost:8080/WEBSITE_EXHIBITION/API/API_xemDHofCaNhanforCancel.php';
            var urlParams = new URLSearchParams({ Id_TaoDonHang : Id_TaoDonHang });
            var url = baseUrl + '?' + urlParams.toString();

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Đã hủy đơn hàng với mã: ' + Id_TaoDonHang);
                        fetchData(); // Cập nhật lại danh sách đơn hàng sau khi hủy
                    } else {
                        alert('Không thể hủy đơn hàng với mã: ' + Id_TaoDonHang);
                    }
                })
                .catch(error => console.error('Error:', error));
        }


        // Tự động tải dữ liệu khi trang được tải
        fetchData();
    </script>
</body>
</html>
