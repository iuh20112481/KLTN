
<?php
$Id_TaiKhoan = $_SESSION['nguoidung']['id_user'];
echo "<script> var Id_TaiKhoan = " . json_encode($Id_TaiKhoan) . ";</script>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<style>
    table td, .table th {
        padding: 7px;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }
    .card {
        background-color: #fff; 
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border: none !important; /* Thay đổi từ 'bordered' thành 'border' */
        }
    div#exampleModal1.modal.fade.show {
    background: #00000066;
    }
    /* Màu gradient cho các trạng thái */
    .bg-gradient-success {
        background: linear-gradient(to right, #00cf01, #009dff);
    }
    .bg-gradient-primary {
        background: linear-gradient(to right, #3e10ff, #accbcb);
    }
    .bg-gradient-danger {
        background: linear-gradient(to right, #ff3625, #9c5e5e);
    }        
    .bg-gradient-warning {
        background: linear-gradient(to right, #ffa700, #ffdab3);
    }
    .bg-gradient-info {
        background: linear-gradient(to right, #bd92ff, #d3daff);
    }
    .bg-gradient-secondary {
        background: linear-gradient(to right, #9be6cd, #d3daff);  
    }
    .bg-gradient-dark {
        background: linear-gradient(to right, #000000, #434343);
    }
    .badge-fixed-width {
        width: 140px; 
        display: inline-block;
        text-align: center;
    }
</style>
<body>
    <div class="pt-5">
    <h2 id="h2-content" class="text-center mt-3 p-3" style="color: darkblue;">Thống kê doanh thu</h2>

        <div class="container-fluid mt-1">
            <div class="row" id="cardRow">
                <!-- Các thẻ card sẽ được thêm vào đây bằng JavaScript -->
            </div>
        </div>

        <!-- Modal -->
        <div>
            <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog modal-xl">

                    <div class="modal-content">
                    <div class="mt-3 text-center">
                        <h4 id="h2-content">Chi Tiết Đơn Hàng</h4>
                    </div>

                    <div class="modal-body-DT">
                        <table class="table table-striped">
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

    </div>
    <div class="pt-3">
    <h3 class="container text-center" id="h2-content">DANH SÁCH ĐƠN HÀNG</h3>
        <!-- DANH SÁCH ĐƠN HÀNG -->
        <div class="row">
            <table class="table table-hover">
                <thead class='table-group-divider table-borderd border-primary'>
                    <tr>
                        <th class="th-style0 bg-primary-subtle table-borderd border-primary">STT</th>
                        <th class="th-style0 bg-primary-subtle table-borderd border-primary">Mã đơn hàng</td>
                        <th class="th-style0 bg-primary-subtle table-borderd border-primary">Mã vận đơn</td>
                        <th class="th-style0 bg-primary-subtle table-borderd border-primary">Tên đơn hàng</td>
                        <th class="th-style0 bg-primary-subtle table-borderd border-primary">Tên người nhận</th>
                        <th class="th-style0 bg-primary-subtle table-borderd border-primary">Số điện thoại</td>
                        <th class="th-style0 bg-primary-subtle table-borderd border-primary">Địa chỉ giao</td>
                        <th class="th-style0 bg-primary-subtle table-borderd border-primary">Trạng thái</td>
                    </tr>
                </thead>

                <?php
                        include_once "../control/c_u_donhang.php";
                        $p = new control_user_donhang;
                        $tbltq = $p->getAllDonHangND();
                        $dem = 1;
                        if ($tbltq) {
                            if (mysqli_num_rows($tbltq) > 0) {
                                echo '<tbody>';

                                while ($row = mysqli_fetch_assoc($tbltq)) {
                                    echo "<tr data-toggle='modal' data-target='#staticBackdrop'>
                                                <td class='text-center'>" . $dem++ . "</td>
                                                <td class='text-center'>" . $row["maDonHang"] . "</td>
                                                <td class='text-center'>" . $row["maVanDon"] . "</td>
                                                <td >" . $row['tenDonHang'] . "</td>
                                                <td>" . $row['tenNN'] . "</td>
                                                <td class='text-center'>" . $row['sdtNN'] . "</td>
                                                <td>" . $row['diaChiNhanGop'] . "</td>
                                                <td class='text-center'>" . getBadge($row['trangThaiDonHang']) . "</td>
                                            </tr>"; 
                                }
                                echo "</tbody>";
                                echo "<br>";
                            } else {
                                echo "<p style='text-align: center;'>Không có dữ liệu đơn hàng</p>";
                            }
                        } else {
                            echo "<p style='text-align: center;'>Không có dữ liệu!</p>";
                        }

                        function getBadge($trangThaiDonHang) {
                            switch ($trangThaiDonHang) {
                                case 'Đã giao':
                                    return "<span class='badge badge-fixed-width rounded-pill text-bg-success'>Đã giao</span>";
                                case 'Đang giao':
                                    return "<span class='badge badge-fixed-width rounded-pill text-bg-primary'>Đang giao</span>";
                                case 'Hoàn trả':
                                    return "<span class='badge badge-fixed-width rounded-pill text-bg-danger'>Hoàn trả</span>";
                                case 'Đã hủy':
                                    return "<span class='badge badge-fixed-width rounded-pill text-bg-danger'>Đã hủy</span>";
                                case 'Đang chờ phân đơn':
                                    return "<span class='badge badge-fixed-width rounded-pill text-bg-warning'>Đang chờ phân đơn</span>";
                                case 'Đã phân đơn':
                                    return "<span class='badge badge-fixed-width rounded-pill text-bg-info'>Đã phân đơn</span>";
                                default:
                                    return "<span class='badge badge-fixed-width rounded-pill text-bg-secondary'>Chưa duyệt đơn</span>";
                            }
                        }
                        ?>
            </table>
        </div>    
    </div>

<script>
        function getDoanhThuFromAPI(Id_TaiKhoan) {
            fetch('http://localhost:8080/WEBSITE_EXHIBITION/API/API_xemDoanhThuCaNhan.php?Id_TaiKhoan=' + Id_TaiKhoan)
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
                'Đã phân đơn': 'info',

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
                card.classList.add('col-lg-2', 'border-radius-20');

                const cardHTML = `
                    <div class="card bg-gradient-${cardData.mau} text-white">
                        <div class="card-body">
                            <h5 id="p1-content" class="card-title">${cardData.status}</h5>
                            <h4 id="h2-content" class="card-text text-center"><span class="text-white">${formatNumber(cardData.tongGiaVanChuyen)}</span> VNĐ</h4>
                            <h6 id="h2-content" class="card-text text-center"><a class="text-white" style="text-decoration:none;" href="#" data-chi-tiet="${cardData.chiTietDonHang}">Số đơn hàng: ${formatNumber(cardData.soLuong)}</a></h6>
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
            getDoanhThuFromAPI(Id_TaiKhoan);
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

                const myModal = new bootstrap.Modal(document.getElementById('exampleModal1'));
                myModal.show();
            }
        });
</script>   

</body>
</html>