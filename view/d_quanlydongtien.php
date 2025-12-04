<?php
// File này được include từ d_giaodiennguoidung.php
// Session và $maNhanVien đã được định nghĩa ở file cha

// Kiểm tra nếu được truy cập trực tiếp (không qua file cha)
if (!isset($maNhanVien) || empty($maNhanVien)) {
    echo "<script>alert('Vui lòng truy cập qua menu Quản lý dòng tiền!'); window.location.href='d_giaodiennguoidung.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý dòng tiền - Hoa hồng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* Override màu header cho trang quản lý dòng tiền */
        .navbar, .navbar-custom, nav, header {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%) !important;
        }

        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 25px;
            color: white;
            margin-bottom: 20px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }
        .stats-card.success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }
        .stats-card.warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .stats-card.info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .stats-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .stats-label {
            font-size: 1rem;
            opacity: 0.9;
        }
        .card-custom {
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border: none;
            margin-bottom: 25px;
        }
        .card-header-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            padding: 20px;
            font-weight: 600;
        }
        .table thead th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }
        .table tbody tr:hover {
            background-color: #f1f3f5;
        }
        .badge-custom {
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 500;
        }
        .icon-box {
            width: 60px;
            height: 60px;
            background-color: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 300px;
        }
        h1 {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 30px;
        }
        /* Style cho bộ lọc */
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }
        .form-label i {
            margin-right: 5px;
            color: #667eea;
        }
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 10px 12px;
            transition: all 0.3s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        #btnResetFilter {
            border-radius: 8px;
            padding: 8px 20px;
            transition: all 0.3s;
        }
        #btnResetFilter:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        #filterInfo {
            font-size: 0.9rem;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center">
                    <i class="fas fa-wallet"></i> Quản lý Dòng Tiền - Hoa Hồng
                </h1>
            </div>
        </div>

        <!-- Loading -->
        <div id="loadingSpinner" class="loading-spinner">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <!-- Nội dung chính -->
        <div id="mainContent" style="display: none;">
            <!-- Thống kê tổng quan -->
            <div class="row">
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="icon-box">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stats-number" id="tongDonDaGiao">0</div>
                        <div class="stats-label">Tổng đơn đã giao</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card success">
                        <div class="icon-box">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="stats-number" id="tongHoaHong">0 đ</div>
                        <div class="stats-label">Tổng hoa hồng</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card warning">
                        <div class="icon-box">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="stats-number" id="donThangNay">0</div>
                        <div class="stats-label">Đơn tháng này</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card info">
                        <div class="icon-box">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="stats-number" id="hoaHongThangNay">0 đ</div>
                        <div class="stats-label">Hoa hồng tháng này</div>
                    </div>
                </div>
            </div>

            <!-- Thông tin tỷ lệ hoa hồng -->
            <div class="row">
                <div class="col-md-8">
                    <div class="alert alert-info mb-4" style="height: 100%;">
                        <i class="fas fa-info-circle"></i>
                        <strong>Công thức:</strong> Tiền hoa hồng = Giá trị đơn hàng × Tỷ lệ %
                        <br><small><em>Lưu ý: Chỉ các đơn giao từ ngày hôm nay trở đi mới được tính hoa hồng.</em></small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border: none; border-radius: 15px; height: 100%;">
                        <div class="card-body text-white text-center d-flex flex-column justify-content-center">
                            <h3 class="mb-2" id="giaHoaHong" style="font-size: 3rem; font-weight: bold;">0%</h3>
                            <p class="mb-0" style="font-size: 0.95rem; opacity: 0.95;">Tỷ lệ hoa hồng của bạn</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bảng chi tiết đơn hàng -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-custom">
                        <div class="card-header card-header-custom">
                            <i class="fas fa-list"></i> Chi Tiết Đơn Hàng Đã Giao
                        </div>
                        <div class="card-body">
                            <!-- Bộ lọc -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <label class="form-label"><i class="fas fa-search"></i> Mã Vận Đơn</label>
                                    <input type="text" id="filterMaVanDon" class="form-control" placeholder="Nhập mã vận đơn...">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label"><i class="fas fa-calendar-alt"></i> Từ Ngày</label>
                                    <input type="date" id="filterTuNgay" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label"><i class="fas fa-calendar-check"></i> Đến Ngày</label>
                                    <input type="date" id="filterDenNgay" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label"><i class="fas fa-filter"></i> Trạng Thái</label>
                                    <select id="filterTrangThai" class="form-select">
                                        <option value="">Tất cả</option>
                                        <option value="Đã giao" selected>Đã giao</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <button id="btnResetFilter" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-redo"></i> Đặt lại bộ lọc
                                    </button>
                                    <span id="filterInfo" class="ms-3 text-muted"></span>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%;">STT</th>
                                            <th style="width: 15%;">Mã Vận Đơn</th>
                                            <th style="width: 25%;">Tên Đơn Hàng</th>
                                            <th style="width: 15%;">Ngày Giao</th>
                                            <th style="width: 15%;">Phí Vận Chuyển</th>
                                            <th style="width: 15%;">Hoa Hồng</th>
                                            <th style="width: 10%;">Trạng Thái</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody">
                                        <tr>
                                            <td colspan="7" class="text-center">Đang tải dữ liệu...</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Lấy mã nhân viên từ PHP session
            var maNhanVien = <?php echo json_encode($maNhanVien); ?>;
            var allOrders = []; // Lưu toàn bộ dữ liệu gốc

            if (!maNhanVien) {
                alert('Không tìm thấy thông tin nhân viên!');
                return;
            }

            // Hàm hiển thị bảng
            function displayOrders(orders) {
                var tbody = $('#tableBody');
                tbody.empty();

                if (orders.length > 0) {
                    $.each(orders, function(index, item) {
                        var row = '<tr>' +
                            '<td class="text-center">' + (index + 1) + '</td>' +
                            '<td>' + item.maVanDon + '</td>' +
                            '<td>' + item.tenDonHang + '</td>' +
                            '<td class="text-center">' + item.ngayHTGiaoHang + '</td>' +
                            '<td class="text-end">' + formatMoney(item.giaVanChuyen) + ' đ</td>' +
                            '<td class="text-end"><strong class="text-success">' + formatMoney(item.hoaHongShipper) + ' đ</strong></td>' +
                            '<td class="text-center"><span class="badge bg-success badge-custom">Đã giao</span></td>' +
                            '</tr>';
                        tbody.append(row);
                    });
                    $('#filterInfo').text('Hiển thị ' + orders.length + ' đơn hàng');
                } else {
                    tbody.html('<tr><td colspan="7" class="text-center">Không tìm thấy đơn hàng nào</td></tr>');
                    $('#filterInfo').text('Không có kết quả');
                }
            }

            // Hàm lọc dữ liệu
            function filterOrders() {
                var filterMaVanDon = $('#filterMaVanDon').val().toLowerCase().trim();
                var filterTuNgay = $('#filterTuNgay').val();
                var filterDenNgay = $('#filterDenNgay').val();
                var filterTrangThai = $('#filterTrangThai').val();

                var filteredOrders = allOrders.filter(function(order) {
                    // Lọc theo mã vận đơn
                    if (filterMaVanDon && order.maVanDon.toLowerCase().indexOf(filterMaVanDon) === -1) {
                        return false;
                    }

                    // Lọc theo ngày (chuyển đổi từ dd-mm-yyyy sang yyyy-mm-dd)
                    if (filterTuNgay || filterDenNgay) {
                        var ngayGiaoParts = order.ngayHTGiaoHang.split('-');
                        var ngayGiao = new Date(ngayGiaoParts[2], ngayGiaoParts[1] - 1, ngayGiaoParts[0]);

                        if (filterTuNgay) {
                            var tuNgay = new Date(filterTuNgay);
                            if (ngayGiao < tuNgay) return false;
                        }

                        if (filterDenNgay) {
                            var denNgay = new Date(filterDenNgay);
                            denNgay.setHours(23, 59, 59, 999); // Set to end of day
                            if (ngayGiao > denNgay) return false;
                        }
                    }

                    // Lọc theo trạng thái (hiện tại chỉ có "Đã giao")
                    if (filterTrangThai && filterTrangThai !== 'Đã giao') {
                        return false;
                    }

                    return true;
                });

                displayOrders(filteredOrders);
            }

            // Event listeners cho bộ lọc
            $('#filterMaVanDon, #filterTuNgay, #filterDenNgay, #filterTrangThai').on('input change', function() {
                filterOrders();
            });

            // Nút reset bộ lọc
            $('#btnResetFilter').click(function() {
                $('#filterMaVanDon').val('');
                $('#filterTuNgay').val('');
                $('#filterDenNgay').val('');
                $('#filterTrangThai').val('Đã giao');
                displayOrders(allOrders);
            });

            // Gọi API lấy dữ liệu
            $.ajax({
                url: '../API/API_hoahong.php',
                method: 'GET',
                data: { maNhanVien: maNhanVien },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Cập nhật thống kê tổng quan
                        $('#tongDonDaGiao').text(response.tongQuat.soDonDaGiao);
                        $('#tongHoaHong').text(formatMoney(response.tongQuat.tongHoaHong) + ' đ');
                        $('#donThangNay').text(response.thangNay.soDonThang);
                        $('#hoaHongThangNay').text(formatMoney(response.thangNay.tongHoaHongThang) + ' đ');
                        $('#giaHoaHong').text(response.tongQuat.tyLeHoaHongHienTai + '%');

                        // Lưu dữ liệu gốc và hiển thị
                        allOrders = response.chiTietDonHang;
                        displayOrders(allOrders);

                        // Ẩn loading, hiện nội dung
                        $('#loadingSpinner').hide();
                        $('#mainContent').fadeIn();
                    } else {
                        alert('Lỗi: ' + response.message);
                    }
                },
                error: function() {
                    alert('Có lỗi khi tải dữ liệu!');
                    $('#loadingSpinner').hide();
                }
            });

            // Hàm format tiền
            function formatMoney(amount) {
                return new Intl.NumberFormat('vi-VN').format(amount);
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
