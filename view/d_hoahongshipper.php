<?php
/**
 * File: d_hoahongshipper_COMPLETE.php
 * Trang hiển thị hoa hồng shipper
 * 
 * ✅ FIX: Lấy mã nhân viên từ session
 * ✅ FIX: Xử lý lỗi API
 * ✅ FIX: Hiển thị dữ liệu thật
 */

session_start();

// Lấy mã nhân viên từ session
// Ưu tiên: Session > GET > Mặc định
$maNhanVien = $_SESSION['maNhanVien'] ?? $_GET['maNhanVien'] ?? 'NVGH-HCM-BDBT-006';

// Log để debug
error_log("=== TRANG HOA HỒNG ===");
error_log("Mã nhân viên: " . $maNhanVien);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoa Hồng Shipper</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .commission-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .commission-card h3 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .commission-card p {
            font-size: 1rem;
            opacity: 0.9;
        }
        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        .stats-card .icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        .stats-card .icon.success {
            color: #28a745;
        }
        .stats-card .icon.warning {
            color: #ffc107;
        }
        .stats-card .icon.danger {
            color: #dc3545;
        }
        .stats-card h4 {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .stats-card p {
            color: #6c757d;
            margin: 0;
        }
        .filter-section {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .commission-rate {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .btn-print {
            background: #667eea;
            color: white;
            border: none;
        }
        .btn-print:hover {
            background: #5568d3;
            color: white;
        }
        @media print {
            .filter-section, .btn-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-4" id="h2-content">
                    <i class="bi bi-cash-coin"></i> Hoa Hồng Giao Hàng
                </h1>
                <!-- Hiển thị mã nhân viên để debug -->
                <p class="text-center text-muted">Mã nhân viên: <strong><?php echo $maNhanVien; ?></strong></p>
            </div>
        </div>

        <!-- Thông tin cấu hình hoa hồng -->
        <div class="row">
            <div class="col-12">
                <div class="commission-rate">
                    <h5><i class="bi bi-gear-fill"></i> Cấu Hình Hoa Hồng</h5>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label>Đơn thành công:</label>
                            <input type="number" class="form-control" id="rate-success" value="15000" min="0">
                            <small class="text-muted">VNĐ/đơn</small>
                        </div>
                        <div class="col-md-3">
                            <label>Đơn đang giao:</label>
                            <input type="number" class="form-control" id="rate-shipping" value="5000" min="0">
                            <small class="text-muted">VNĐ/đơn</small>
                        </div>
                        <div class="col-md-3">
                            <label>Phụ cấp/km:</label>
                            <input type="number" class="form-control" id="rate-distance" value="2000" min="0">
                            <small class="text-muted">VNĐ/km</small>
                        </div>
                        <div class="col-md-3">
                            <label>Tổng km đã chạy:</label>
                            <input type="number" class="form-control" id="total-distance" value="0" min="0">
                            <small class="text-muted">km</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bộ lọc -->
        <div class="row">
            <div class="col-12">
                <div class="filter-section">
                    <div class="row align-items-end">
                        <div class="col-md-3">
                            <label id="p1-content">Từ ngày:</label>
                            <input type="date" class="form-control" id="from-date">
                        </div>
                        <div class="col-md-3">
                            <label id="p1-content">Đến ngày:</label>
                            <input type="date" class="form-control" id="to-date">
                        </div>
                        <div class="col-md-3">
                            <label id="p1-content">Trạng thái:</label>
                            <select class="form-control" id="status-filter">
                                <option value="">Tất cả</option>
                                <option value="Đã Giao">Đã Giao</option>
                                <option value="Đang Giao">Đang Giao</option>
                                <option value="Đã hủy">Đã hủy</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary btn-block" onclick="loadCommissionData()">
                                <i class="bi bi-search"></i> Lọc dữ liệu
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thống kê tổng quan -->
        <div class="row">
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="bi bi-box-seam icon success"></i>
                    <h4 id="total-success">0</h4>
                    <p>Đơn đã giao</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="bi bi-truck icon warning"></i>
                    <h4 id="total-shipping">0</h4>
                    <p>Đơn đang giao</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="bi bi-x-circle icon danger"></i>
                    <h4 id="total-cancelled">0</h4>
                    <p>Đơn đã hủy</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card text-center">
                    <i class="bi bi-receipt icon"></i>
                    <h4 id="total-orders">0</h4>
                    <p>Tổng đơn hàng</p>
                </div>
            </div>
        </div>

        <!-- Tổng hoa hồng -->
        <div class="row">
            <div class="col-12">
                <div class="commission-card text-center">
                    <p class="mb-2">Tổng Hoa Hồng</p>
                    <h3 id="total-commission">0 VNĐ</h3>
                    <button class="btn btn-print mt-3" onclick="printCommission()">
                        <i class="bi bi-printer"></i> In báo cáo
                    </button>
                </div>
            </div>
        </div>

        <!-- Chi tiết từng đơn -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-list-ul"></i> Chi Tiết Đơn Hàng</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã VĐ</th>
                                        <th>Tên Đơn Hàng</th>
                                        <th>Ngày Giao</th>
                                        <th>Trạng Thái</th>
                                        <th>Phí VC</th>
                                        <th>Hoa Hồng</th>
                                    </tr>
                                </thead>
                                <tbody id="order-details">
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // ✅ Lấy mã nhân viên từ PHP
        var maNhanVien = <?php echo json_encode($maNhanVien); ?>;
        
        console.log('=== DEBUG INFO ===');
        console.log('Mã nhân viên:', maNhanVien);

        // Thiết lập ngày mặc định
        window.onload = function() {
            const today = new Date();
            const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
            
            document.getElementById('from-date').valueAsDate = firstDay;
            document.getElementById('to-date').valueAsDate = today;
            
            console.log('From date:', document.getElementById('from-date').value);
            console.log('To date:', document.getElementById('to-date').value);
            
            loadCommissionData();
        };

        // Hàm chuyển đổi định dạng ngày
        function convertDateToDDMMYYYY(dateString) {
            const date = new Date(dateString);
            const day = ("0" + date.getDate()).slice(-2);
            const month = ("0" + (date.getMonth() + 1)).slice(-2);
            const year = date.getFullYear();
            return `${day}-${month}-${year}`;
        }

        // Hàm load dữ liệu hoa hồng
        function loadCommissionData() {
            const fromDate = document.getElementById('from-date').value;
            const toDate = document.getElementById('to-date').value;
            const status = document.getElementById('status-filter').value;

            if (!fromDate || !toDate) {
                alert('Vui lòng chọn khoảng thời gian!');
                return;
            }

            // Gọi API để lấy dữ liệu
            const fromDateDDMMYYYY = convertDateToDDMMYYYY(fromDate);
            const toDateDDMMYYYY = convertDateToDDMMYYYY(toDate);
            
            let url = `../API/API_hoahongshipper.php?maNhanVien=${encodeURIComponent(maNhanVien)}&fromDate=${fromDateDDMMYYYY}&toDate=${toDateDDMMYYYY}`;
            
            if (status) {
                url += `&trangThai=${encodeURIComponent(status)}`;
            }

            console.log('=== CALLING API ===');
            console.log('URL:', url);

            fetch(url)
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.text();
                })
                .then(text => {
                    console.log('Response text:', text);
                    try {
                        const data = JSON.parse(text);
                        console.log('Parsed data:', data);
                        
                        if (data.error) {
                            console.error('API Error:', data.message);
                            document.getElementById('order-details').innerHTML = 
                                `<tr><td colspan="7" class="text-center text-danger">${data.message}</td></tr>`;
                            return;
                        }
                        
                        if (Array.isArray(data)) {
                            displayCommissionData(data);
                        } else if (data.data && Array.isArray(data.data)) {
                            displayCommissionData(data.data);
                        } else {
                            console.warn('Unexpected data format:', data);
                            displayCommissionData([]);
                        }
                    } catch (e) {
                        console.error('JSON parse error:', e);
                        console.error('Response was:', text);
                        document.getElementById('order-details').innerHTML = 
                            `<tr><td colspan="7" class="text-center text-danger">Lỗi: ${e.message}</td></tr>`;
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    document.getElementById('order-details').innerHTML = 
                        `<tr><td colspan="7" class="text-center text-danger">Lỗi kết nối: ${error.message}</td></tr>`;
                });
        }

        // Hàm hiển thị dữ liệu
        function displayCommissionData(data) {
            console.log('=== DISPLAYING DATA ===');
            console.log('Number of orders:', data.length);
            
            const rateSuccess = parseFloat(document.getElementById('rate-success').value) || 15000;
            const rateShipping = parseFloat(document.getElementById('rate-shipping').value) || 5000;
            const rateDistance = parseFloat(document.getElementById('rate-distance').value) || 2000;
            const totalDistance = parseFloat(document.getElementById('total-distance').value) || 0;

            let totalSuccess = 0;
            let totalShipping = 0;
            let totalCancelled = 0;
            let totalCommission = 0;
            let html = '';

            if (data.length === 0) {
                html = '<tr><td colspan="7" class="text-center">Không có đơn hàng nào trong khoảng thời gian này</td></tr>';
            } else {
                data.forEach((item, index) => {
                    let commission = 0;
                    
                    if (item.trangThaiDonHang === 'Đã Giao' || item.trangThaiDonHang === 'Đã giao') {
                        totalSuccess++;
                        commission = rateSuccess;
                    } else if (item.trangThaiDonHang === 'Đang Giao' || item.trangThaiDonHang === 'Đang giao') {
                        totalShipping++;
                        commission = rateShipping;
                    } else if (item.trangThaiDonHang === 'Đã hủy') {
                        totalCancelled++;
                        commission = 0;
                    }

                    totalCommission += commission;

                    const statusClass = 
                        item.trangThaiDonHang === 'Đã Giao' || item.trangThaiDonHang === 'Đã giao' ? 'badge-success' :
                        item.trangThaiDonHang === 'Đang Giao' || item.trangThaiDonHang === 'Đang giao' ? 'badge-warning' :
                        'badge-danger';

                    html += `
                        <tr>
                            <td class="text-center">${index + 1}</td>
                            <td>${item.maVanDon}</td>
                            <td>${item.tenDonHang}</td>
                            <td class="text-center">${item.ngayHTGiaoHang || item.ngayPhanHangGiao}</td>
                            <td><span class="badge ${statusClass}">${item.trangThaiDonHang}</span></td>
                            <td class="text-right">${parseInt(item.giaVanChuyen || 0).toLocaleString('vi-VN')} ₫</td>
                            <td class="text-right font-weight-bold text-success">${commission.toLocaleString('vi-VN')} ₫</td>
                        </tr>
                    `;
                });

                // Thêm phụ cấp km
                const distanceBonus = totalDistance * rateDistance;
                totalCommission += distanceBonus;

                if (totalDistance > 0) {
                    html += `
                        <tr class="table-info">
                            <td colspan="6" class="text-right"><strong>Phụ cấp quãng đường (${totalDistance} km):</strong></td>
                            <td class="text-right font-weight-bold text-primary">${distanceBonus.toLocaleString('vi-VN')} ₫</td>
                        </tr>
                    `;
                }

                html += `
                    <tr class="table-success">
                        <td colspan="6" class="text-right"><strong>TỔNG HOA HỒNG:</strong></td>
                        <td class="text-right font-weight-bold text-success" style="font-size: 1.2rem;">${totalCommission.toLocaleString('vi-VN')} ₫</td>
                    </tr>
                `;
            }

            // Cập nhật giao diện
            document.getElementById('total-success').textContent = totalSuccess;
            document.getElementById('total-shipping').textContent = totalShipping;
            document.getElementById('total-cancelled').textContent = totalCancelled;
            document.getElementById('total-orders').textContent = data.length;
            document.getElementById('total-commission').textContent = totalCommission.toLocaleString('vi-VN') + ' VNĐ';
            document.getElementById('order-details').innerHTML = html;
            
            console.log('=== STATS ===');
            console.log('Success:', totalSuccess);
            console.log('Shipping:', totalShipping);
            console.log('Cancelled:', totalCancelled);
            console.log('Total commission:', totalCommission);
        }

        // Hàm in báo cáo
        function printCommission() {
            window.print();
        }

        // Tự động load lại khi thay đổi cấu hình
        document.getElementById('rate-success').addEventListener('change', loadCommissionData);
        document.getElementById('rate-shipping').addEventListener('change', loadCommissionData);
        document.getElementById('rate-distance').addEventListener('change', loadCommissionData);
        document.getElementById('total-distance').addEventListener('change', loadCommissionData);
    </script>
</body>
</html>