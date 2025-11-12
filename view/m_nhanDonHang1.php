<?php
// Kiểm tra xem người dùng đã gửi dữ liệu hay chưa
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['orders']) && isset($_POST['shippingCodes'])) {
    // Mở kết nối đến cơ sở dữ liệu
    $conn = new mysqli("localhost", "root", "", "HPship");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Lấy dữ liệu từ biến POST
    $orders = json_decode($_POST['orders'], true);
    $shippingCodes = json_decode($_POST['shippingCodes'], true);

    // Duyệt qua mỗi đơn hàng và cập nhật mã vận đơn tương ứng vào cơ sở dữ liệu
    for ($i = 0; $i < count($orders); $i++) {
        $orderId = $orders[$i][0]; // ID đơn hàng
        $shippingCode = $shippingCodes[$i]; // Mã vận đơn tương ứng

        // Cập nhật mã vận đơn trong cơ sở dữ liệu
        $sql = "UPDATE donhang SET maVanDon='$shippingCode' WHERE Id_TaoDonHang='$orderId'";
        if ($conn->query($sql) === TRUE) {
            echo "Cập nhật mã vận đơn thành công cho đơn hàng có ID: " . $orderId . "<br>";
        } else {
            echo "Lỗi khi cập nhật mã vận đơn: " . $conn->error . "<br>";
        }
    }

    // Đóng kết nối đến cơ sở dữ liệu
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiểm Tra đơn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    </style>
</head>
<body>
    <br>
    <div class="container-fluid">
        <div class="row">
            <br>
            <h3 class="container text-center">DANH SÁCH TẠO ĐƠN HÀNG</h3>
            <hr>
            <div class="row" action="../control/save_shipping_codes.php">
                <form method="post" action="#">
                    <table class="table table-hover" id="orderTable">
                        <thead>
                            <tr>
                                <th>ID Đơn hàng</th>
                                <th>Mã đơn hàng</th>
                                <th>Tên đơn hàng</th>
                                <th>Tên người gửi</th>
                                <th>Tên người nhận</th>
                                <th>Địa chỉ nhận</th>
                                <th>Ngày lập đơn giao</th>
                                <th>Trạng thái đơn hàng</th>
                                <th>Mã vận đơn</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $servername = "localhost";
                            $username = "root";
                            $password = ""; 
                            $dbname = "HPship";
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            // Kiểm tra kết nối
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                            // Truy vấn cơ sở dữ liệu để lấy dữ liệu đơn hàng chưa có mã vận đơn
                            $sql = "SELECT taodonhang.Id_TaoDonHang, 
                                    taodonhang.maDonHang, 
                                    taodonhang.tenDonHang, 
                                    taodonhang.tenNG, 
                                    taodonhang.tenNN, 
                                    taodonhang.diaChiNhan, 
                                    taodonhang.ngayLapDon,
                                    donhang.maVanDon
                                    FROM taodonhang
                                    LEFT JOIN donhang ON taodonhang.Id_TaoDonHang = donhang.Id_TaoDonHang
                                    WHERE donhang.maVanDon IS NULL"; 
                            $result = $conn->query($sql);
                            // Hiển thị dữ liệu từ cơ sở dữ liệu trong bảng HTML
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr data-toggle=\"modal\" data-target=\"#staticBackdrop\">";
                                    echo "<td>" . $row["Id_TaoDonHang"] . "</td>";
                                    echo "<td>" . $row["maDonHang"] . "</td>";
                                    echo "<td>" . $row["tenDonHang"] . "</td>";
                                    echo "<td>" . $row["tenNG"] . "</td>";
                                    echo "<td>" . $row["tenNN"] . "</td>";
                                    echo "<td>" . $row["diaChiNhan"] . "</td>";
                                    echo "<td>" . $row["ngayLapDon"] . "</td>";
                                    echo "<td>";
                                    echo "<select class=\"row form-select form-select-s mb-1\" onchange=\"updateShippingCode(this, '" . $row['Id_TaoDonHang'] . "')m\">";
                                    echo "<option selected disabled>Chọn</option>";
                                    echo "<option value=\"confirm\">Xác nhận đơn</option>";
                                    echo "<option value=\"cancel\">Hủy đơn hàng</option>";
                                    echo "</select>";
                                    echo "</td>";
                                    echo "<td class='shipping-code'>" . $row['maVanDon'] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='10'>Không có đơn hàng nào.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <input type="" id="orders" name="orders" value="" />
                    <input type="" id="shippingCodes" name="shippingCodes" value="" />
                    <div class="row">
                        <div class="col text-center">
                            <button type="button" class="btn btn-primary" onclick="summarizeOrders()">Tổng kết</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function updateShippingCode(selectElement, Id_TaoDonHang) {
            var selectedOption = selectElement.value;
            if (selectedOption === "confirm") {
                var today = new Date();
                var year = today.getFullYear();
                var month = (today.getMonth() + 1).toString().padStart(2, '0');
                var day = today.getDate().toString().padStart(2, '0');
                var shippingCode = "QS-" + day + month + year + "-" + Id_TaoDonHang;
                // Cập nhật mã vận đơn trong cột "Mã vận đơn"
                var shippingCodeCell = selectElement.parentNode.nextElementSibling;
                shippingCodeCell.textContent = shippingCode;
            } else if (selectedOption === "cancel") {
                var shippingCode = "Đơn hàng bị hủy";
                var shippingCodeCell = selectElement.parentNode.nextElementSibling;
                shippingCodeCell.textContent = shippingCode;
            }
        }

        function summarizeOrders() {
            var orders = [];
            var shippingCodes = [];
            var rows = document.querySelectorAll("#orderTable tbody tr");
            rows.forEach(function(row) {
                var order = [];
                var cells = row.querySelectorAll("td");
                cells.forEach(function(cell) {
                    order.push(cell.textContent);
                });
                orders.push(order);
                shippingCodes.push(row.querySelector(".shipping-code").textContent);
            });
            document.getElementById("orders").value = JSON.stringify(orders);
            document.getElementById("shippingCodes").value = JSON.stringify(shippingCodes);
            document.querySelector("form").submit();
        }
    </script>
</body>
</html>
