
<?php
$maBuuCuc = $_SESSION['buu_cuc_info']['maBuuCuc'];
echo "<script> var maBuuCuc = " . json_encode($maBuuCuc) . ";</script>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê doanh thu</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .card {
        background-color: #fff; 
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border: none !important; /* Thay đổi từ 'bordered' thành 'border' */
        }

        /* Màu gradient cho các trạng thái */
        .bg-gradient-success {
            background: linear-gradient(to right, #00cf01, #009dff);}

        .bg-gradient-primary {
            background: linear-gradient(to right, #3e10ff, #accbcb);
        }

        .bg-gradient-danger {
            background: linear-gradient(to right, #ff3625, #9c5e5e);
        }
        .bg-gradient-info {
            background: linear-gradient(to right, #9be6cd, #d3daff);        
        }
    </style>
</head>
<body>
<div class="container-fluid">
     <h2 id="h2-content" class="text-center mt-3 p-1" style="color: darkblue;">Thống kê doanh thu</h2>
    <div class="container-fluid mt-1">
        <div class="row" id="cardRow">
            <!-- Các thẻ card sẽ được thêm vào đây bằng JavaScript -->
        </div>
    </div>
    <!-- Modal -->
    <div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog modal-xl">

                <div class="modal-content">
                <div class="mt-3 text-center">
                    <h4 id="h2-content">Chi Tiết Đơn Hàng</h4>
                </div>

                <div class="modal-body">
                    <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>Mã Đơn Hàng</th>
                        <th>Tên Đơn Hàng</th>
                        <th>Người Gửi</th>
                        <th>Người Nhận</th>
                        <th>Ngày Lập Đơn</th>
                        <th>Giá Vận Chuyển</th>
                        </tr>
                    </thead>
                    <tbody id="modalChiTietDonHang">
                        <!-- Thông tin chi tiết đơn hàng sẽ được thêm vào đây -->
                    </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                </div>

                </div>
            </div>
        </div>

    </div>   

    <div class="col-sm">

        <div class="container-fluid text-center mt-3">
            <div class="row align-items-start">

                <div class="col-4">
                    <?php
                        require_once 'm_chart2.php';
                    ?>
                </div>

                <div class="col-4">

                </div>

            </div>
        </div>

    </div>
</div>

<script>
        function getDoanhThuFromAPI(maBuuCuc) {
            fetch('http://localhost:8080/WEBSITE_EXHIBITION/API/API_xemDoanhThuBC.php?maBuuCuc=' + maBuuCuc)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    displayData(data);
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                });
        }

        function displayData(data) {
            const statuses = ['Đã giao', 'Đang giao', 'Đã hủy', 'Đang chờ phân đơn', 'Đã phân đơn'];
            const colors = {
                'Đã giao': 'success',
                'Đang giao': 'primary',
                'Đã hủy': 'danger',
                'Đang chờ phân đơn': 'warning',
                'Đã phân đơn': 'info'
            };
        

            statuses.forEach(status => {
                const cardData = data.find(item => item.status === status) || {
                    status: status,
                    soLuong: 0,
                    tongGiaVanChuyen: 0,
                    mau: colors[status],
                    chiTietDonHang: ''
                };

                const card = document.createElement('div');
                card.classList.add('col-sm-2');

                const cardHTML = `
                    <div class="card bg-gradient-${cardData.mau} text-white">
                        <div class="card-body">
                            <h5 id="p1-content" class="card-title">${cardData.status}</h5>
                            <h4 id="h2-content" class="card-text text-center"><span class="text-white">${formatNumber(cardData.tongGiaVanChuyen)}</span> VNĐ</h4>
                            <h6 id="h2-content" class="card-text text-center"><a class="text-white" href="#" data-chi-tiet="${cardData.chiTietDonHang}">Số đơn hàng: ${formatNumber(cardData.soLuong)}</a></h6>
                        </div>
                    </div>
                `;

                card.innerHTML = cardHTML;
                document.getElementById('cardRow').appendChild(card);
            });
        }

        function formatNumber(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        window.onload = function() {
            getDoanhThuFromAPI(maBuuCuc);
        };

        document.addEventListener('click', function(event) {
            if (event.target.matches('[data-chi-tiet]')) {
                event.preventDefault();
                const chiTietDonHang = event.target.dataset.chiTiet;
                const records = chiTietDonHang ? chiTietDonHang.split(';') : [];
                const modalBody = document.getElementById('modalChiTietDonHang');
                modalBody.innerHTML = '';

                records.forEach(record => {
                    const fields = record.split('|');
                    const row = document.createElement('tr');
                    fields.forEach(field => {
                        const cell = document.createElement('td');
                        cell.textContent = field.trim();
                        row.appendChild(cell);
                    });
                    modalBody.appendChild(row);
                });

                const myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
                myModal.show();
            }
        });
    </script>   
</body>
</html>
