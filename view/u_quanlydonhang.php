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
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        /* form {
            max-width: 500px;
            margin-bottom: 20px;
        } */

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        #statusStats div {
            margin-bottom: 5px;
        }
        form#filterForm.container{
            background: gainsboro;
            padding: 10px;
            border-radius: 10px;
        }

    </style>

</head>
<body>
    <div class="pt-5">
        <div class="mt-5">
        <h3 id="h2-content">Bộ Lọc</h3>
            <form class="container" id="filterForm">
                <div style="display: flex; justify-content: space-between;">
                    <div style="flex: 1; margin-right: 10px;">
                        <label for="maVanDon" id="p1-content">Mã Vận Đơn:</label>
                        <input class="form-control" type="text" id="maVanDon" name="maVanDon">
                    </div>
                    <div style="flex: 1; margin-right: 10px;">
                        <label for="sdtNN" id="p1-content">Số Điện Thoại Người Nhận:</label>
                        <input class="form-control" type="text" id="sdtNN" name="sdtNN">
                    </div>
                    <div style="flex: 1;">
                        <label for="trangThaiDonHang" id="p1-content">Trạng Thái Đơn Hàng:</label>
                        <select id="trangThaiDonHang" name="trangThaiDonHang" class="form-select-lg">
                            <option value="">Tất cả</option>
                            <option value="Chờ xác nhận">Chưa duyệt đơn</option>
                            <option value="Chờ xác nhận">Đã phân đơn</option>            
                            <option value="Đã xác nhận">Đã duyệt đơn</option>
                            <option value="Đang giao hàng">Đang giao hàng</option>
                            <option value="Đã giao">Đã giao</option>
                            <option value="Đã hủy">Đã hủy</option>
                        </select>
                    </div>
                </div>
                    <div class="text-center mt-1 mb-1">
                        <a type="button" onclick="fetchData()"><span id="p1-content" style="background-color: #4CAF50; color: white; padding: 10px 20px;border: none;border-radius: 4px;cursor: pointer;">LỌC</span></a>
                    </div>
            </form>

            <h3 id="h2-content" class="mt-3" >Danh sách đơn hàng</h3>
            <table id="orderTable" class="nhandonhang">
                <thead>
                    <tr>
                        <th class="th-style0">Mã Đơn Hàng</th>
                        <th class="th-style0">Id Tài Khoản</th>
                        <th class="th-style0">Mã Vận Đơn</th>
                        <th class="th-style0">Tên Đơn Hàng</th>
                        <th class="th-style0">Tên Người Nhận</th>
                        <th class="th-style0">Số Điện Thoại Người Nhận</th>
                        <th class="th-style0">Địa Chỉ Nhận</th>
                        <th class="th-style0">Trạng Thái Đơn Hàng</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be inserted here -->
                </tbody>
            </table>

            <h3 id="h2-content" class="mt-3">Thống kê đơn hàng của bạn</h3>
            <div class="mb-4" id="statusStats" style="background-color: lightgray; margin-right: 950px;padding: 15px; border-radius: 15px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);"></div>
        </div>
        
    </div>

<script>
    var Id_TaiKhoan = <?php echo json_encode($Id_TaiKhoan); ?>;
        
    function fetchData() {
        var maVanDon = document.getElementById('maVanDon').value;
        var sdtNN = document.getElementById('sdtNN').value;
        var trangThaiDonHang = document.getElementById('trangThaiDonHang').value;

        var baseUrl = 'http://localhost:8080/WEBSITE_EXHIBITION/API/API_xemDHforCaNhan.php';
        var url = `${baseUrl}?Id_TaiKhoan=${Id_TaiKhoan}`;

        if (maVanDon) {
            url += `&maVanDon=${encodeURIComponent(maVanDon)}`;
        }
        if (sdtNN) {
            url += `&sdtNN=${encodeURIComponent(sdtNN)}`;
        }
        if (trangThaiDonHang) {
            url += `&trangThaiDonHang=${encodeURIComponent(trangThaiDonHang)}`;
        }

        fetch(url)
            .then(response => response.json())
            .then(data => {
                displayData(data);
                displayStatistics(data);
            })
            .catch(error => console.error('Error:', error));
    }

    function displayData(data) {
    var tableBody = document.getElementById('orderTable').querySelector('tbody');
    tableBody.innerHTML = '';

    data.forEach(order => {
        var row = document.createElement('tr');

        Object.entries(order).forEach(([key, value]) => {
            var cell = document.createElement('td');
            if (value !== null) {
                cell.textContent = value;
            } else {
                switch (key) {
                    case 'maVanDon':
                        cell.textContent = 'Chưa có mã vận đơn';
                        break;
                    case 'trangThaiDonHang':
                        cell.textContent = 'Chưa duyệt đơn';
                        break;
                    default:
                        cell.textContent = 'N/A'; // Hoặc giá trị mặc định khác nếu không phải là mã vận đơn hoặc trạng thái đơn hàng
                        break;
                }
            }
            row.appendChild(cell);
        });

        tableBody.appendChild(row);
    });
}


    function displayStatistics(data) {
    var statusCounts = {
        'Đã giao': 0,
        'Đang giao': 0,
        'Đã hủy': 0,
        'Đang chờ phân đơn': 0,
        'Đã phân đơn': 0,
        'Chưa duyệt đơn': 0 // Thay 'null' bằng 'Chưa duyệt đơn'
    };

    data.forEach(order => {
        if (order.trangThaiDonHang !== null) {
            statusCounts[order.trangThaiDonHang]++;
        } else {
            statusCounts['Chưa duyệt đơn']++; // Thay 'null' bằng 'Chưa duyệt đơn'
        }
    });

    var statsDiv = document.getElementById('statusStats');
    statsDiv.innerHTML = '';

    Object.entries(statusCounts).forEach(([status, count]) => {
        var statItem = document.createElement('div');
        statItem.textContent = `${status}: ${count}`;
        statsDiv.appendChild(statItem);
    });
}

</script>

</body>
</html>
