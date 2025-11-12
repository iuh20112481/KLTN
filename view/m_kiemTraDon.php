<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiểm Tra đơn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>

    .container-fluid {
        padding: 0;
    }

    .container {
        padding: 0;
    }

    .row {
        margin: 0;
    }

    .table {
        margin: 0;
    }

    .table th {
        text-align: center;
    }

    .table td {
        text-align: center;
    }

    .table th {
        background-color: #f2f2f2;
    }

    .table th,
    .table td {
        border: 1px solid #e0e0e0;
    }

    .table th,
    .table td {
        padding: 10px;
    }

    .table th {
        font-size: 16px;
    }

    .table td {
        font-size: 14px;
    }

    .table tbody tr:hover {
        background-color: #f2f2f2;
    }

    .badge {
        font-size: 14px;
    }

    .text-bg-success {
        background-color: #28a745;
        color: #fff;
    }

    .text-bg-primary {
        background-color: #007bff;
        color: #fff;
    }

    .text-bg-danger {
        background-color: #dc3545;
        color: #fff;
    }

    .text-bg-secondary {
        background-color: #6c757d;
        color: #fff;
    }
</style>
</head>
<body>
    <br>
    <div class="container-fluid">
        <div class="row">
            
            <br>
            <h3 class="container text-center">DANH SÁCH ĐƠN HÀNG</h3>
            <hr>

            <!-- DANH SÁCH ĐƠN HÀNG -->
                <div class="row ">
                    <table class="table table-hover" id="orderTable">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã đơn hàng</th>
                                <th>Mã vận đơn</th>
                                <th>Tên đơn hàng</th>
                                <th>Tên người gửi</th>
                                <th>Tên người nhận</th>
                                <th>Địa chỉ giao</th>
                                <th>Địa chỉ nhận</th>
                                <th>Ngày lập đơn giao</th>
                                <th>Trạng thái đơn hàng</th>

                            </tr>
                        </thead>

                        <?php
                            include_once "control/cdonhang.php";
                            $p = new control_donhang;
                            $tbltq = $p->getAllDonHang();
                            $dem = 1;
                            if ($tbltq) {
                                if (mysqli_num_rows($tbltq) > 0) {
                                    echo "<tbody>";
                                    while ($row = mysqli_fetch_assoc($tbltq)) {
                                        echo "<tr data-toggle='modal' data-target='#staticBackdrop'><td>" . $dem++ . "</td><td>" . $row["maDonHang"] . "</td><td>" . $row["maVanDon"] . "</td><td>" . $row['tenDonHang'] . "</td><td>" . $row['tenNG'] . "</td><td>" . $row['tenNN'] . "</td><td>" . $row['diaChiGiao'] . "</td><td>" . $row['diaChiNhan'] . "</td><td>" .$row['ngayLapDon'] . "</td><td>" . getBadge($row['trangThaiDonHang']) . "</td></tr>"; 
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
                                        return "<span class='badge rounded-pill text-bg-success'>Đã giao</span>";
                                    case 'Đang giao':
                                        return "<span class='badge rounded-pill text-bg-primary'>Đang giao</span>";
                                    case 'Hoàn trả':
                                        return "<span class='badge rounded-pill text-bg-danger'>Hoàn trả</span>";
                                    default:
                                        return "<span class='badge rounded-pill text-bg-secondary'>Không xác định</span>";
                                }
                            }
                            ?>


                    </table>
                </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Thông tin đơn hàng</h1>
                    </div>
                    <div class="modal-body">
                        <!-- Nội dung của modal -->
                        <p><strong>Mã đơn hàng: </strong><span id="modalOrderCode"></span></p>
                        <p><strong>Mã vận đơn: </strong><span id="modalTrackingCode"></span></p>
                        <p><strong>Tên đơn hàng: </strong> <span id="modalTenDonHang"></span></p>
                        <p><strong>Tên người gửi: </strong> <span id="modalTenNguoiGui"></span></p>
                        <p><strong>Tên người nhận: </strong> <span id="modalTenNguoiNhan"></span></p>

                        <!-- Các thông tin khác... -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary">Lưu thay đổi</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sự kiện click cho từng dòng trong bảng
        document.getElementById('orderTable').addEventListener('click', function (event) {
            const target = event.target;
            if (target.tagName === 'TD' && target.parentNode.dataset.toggle === 'modal') {
                // Lấy dữ liệu tương ứng từ các ô cột
                const orderCode = target.parentNode.children[1].textContent;
                const trackingCode = target.parentNode.children[2].textContent;
                const TenDonHang = target.parentNode.children[3].textContent;
                const TenNguoiGui = target.parentNode.children[4].textContent;
                const TenNguoiNhan = target.parentNode.children[5].textContent;
                // Hiển thị dữ liệu trong modal
                document.getElementById('modalOrderCode').textContent = orderCode;
                document.getElementById('modalTrackingCode').textContent = trackingCode;
                document.getElementById('modalTenDonHang').textContent = TenDonHang;
                document.getElementById('modalTenNguoiGui').textContent = TenNguoiGui;
                document.getElementById('modalTenNguoiNhan').textContent = TenNguoiNhan;
                // Mở modal
                const modal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
                modal.show();
            }
        });
    </script>

</body>
</html>