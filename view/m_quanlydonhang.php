<?php
$maBuuCuc = $_SESSION['buu_cuc_info']['maBuuCuc'];
echo "<script> var maBuuCuc = " . json_encode($maBuuCuc) . ";</script>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Quản Lý Đơn Hàng Bưu Cục</title>
    <link rel="stylesheet" href="../css/style.css?v=22">
    <style>
        .badge-fixed-width {
            width: 140px; /* Đặt độ rộng cố định theo nhu cầu của bạn */
            display: inline-block;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="table-responsive">
    <br>
    <h2 id="h2-content" class="text-center">Quản Lý Đơn Hàng Bưu Cục</h2>
    <div class="container-fluid">
        <div class="row d-flex mb-2">
            <div class="col-12 d-flex justify-content-end">
                <!-- THANH TÌM KIẾM -->
                <div class="d-flex mr-3">
                    <span class="" id="p1-content">Tìm kiếm:</span>
                    <input type="text" class="form-control" id="search" placeholder="Nhập Mã Vận Đơn...">
                </div>
                
                <!-- LỌC THEO NGÀY -->
                <div class="d-flex mr-3">
                    <span class="mt-2" id="p1-content">Ngày:</span>
                    <input type="date" id="date" class="form-control ml-2">
                    <!-- Thẻ input để hiển thị giá trị ngày tháng -->
                    <input type="hidden" id="displayDate" class="form-control" readonly>
                </div>

                <!-- LỌC THEO TRẠNG THÁI ĐƠN HÀNG -->
                <div class="d-flex">
                    <span class="" id="p1-content">Trạng thái:</span>
                    <select id="select" class="form-select ml-2" aria-label="Default select example">
                        <option value="0" selected>Tất cả</option>
                        <option value="Đã Giao">Đã Giao</option>
                        <option value="Đang Giao">Đang Giao</option>
                        <option value="Đã hủy">Đã hủy</option>
                        <option value="Đang chờ phân đơn">Đang chờ phân đơn</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <table id="apiTable" class="nhandonhang mt-2">
        <thead>
            <tr>
                <th class="th-style3">Mã Bưu Cục</th>
                <th class="th-style3">Mã Đơn Hàng</th>
                <th class="th-style3">ID Tài Khoản</th>
                <th class="th-style3">Tên Người Gửi</th>
                <th class="th-style3">Tên Người Nhận</th>
                <th class="th-style3">Tên Đơn Hàng</th>
                <th class="th-style3">Mã Vận Đơn</th>
                <th class="th-style3">Ngày Lập Đơn</th>
                <th class="th-style3">Địa Chỉ Nhận</th>
                <th class="th-style3">Trạng Thái Đơn Hàng</th>
            </tr>
        </thead>
        <tbody id="apiTableBody">
            <!-- Dữ liệu sẽ được thêm vào đây bằng JavaScript -->
        </tbody>
    </table>
</div>
<script src="../js/m_quanlydonhang.js?v=22"></script>
</body>
</html>
