<?php
// Session đã được start từ m_giaodiennguoidung.php
if (!isset($_SESSION['nvbc'])) {
    echo "<div class='alert alert-danger'>Không có quyền truy cập</div>";
    exit();
}

$idUser = $_SESSION["nvbc"]['id_user'];
$nameUser = $_SESSION['name_user'];
$buuCucInfo = $_SESSION['buu_cuc_info'];
$maBuuCuc = $buuCucInfo['maBuuCuc'];

include_once("../control/choahong.php");
$controller = new control_hoahong();

// Lấy danh sách shipper của bưu cục
$shipperList = $controller->getAllShipperByBuuCuc($maBuuCuc);
?>
<style>
    .container-main {
            margin-top: 30px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .page-title {
            color: #2c3e50;
            margin-bottom: 30px;
            font-weight: 600;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .table thead th {
            background-color: #3498db;
            color: white;
            font-weight: 500;
            border: none;
            padding: 15px;
        }
        .table tbody td {
            padding: 15px;
            vertical-align: middle;
        }
        .input-hoahong {
            width: 150px;
            text-align: right;
        }
        .btn-update {
            background-color: #27ae60;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            transition: all 0.3s;
        }
        .btn-update:hover {
            background-color: #229954;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        .btn-back {
            background-color: #95a5a6;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }
        .btn-back:hover {
            background-color: #7f8c8d;
            color: white;
        }
        .alert-custom {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            animation: slideIn 0.3s;
        }
        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        .badge-info {
            background-color: #3498db;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
        }
</style>

<div id="alertContainer"></div>

<div class="container">
    <div class="container-main">
        <a href="?page=adsnvgh" class="btn-back">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>

            <h2 class="page-title">
                <i class="fas fa-money-bill-wave"></i> Quản lý hoa hồng Shipper
            </h2>

            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                <strong>Hướng dẫn:</strong> Thiết lập tỷ lệ phần trăm hoa hồng cho shipper.
                Hoa hồng sẽ được tính tự động khi shipper cập nhật trạng thái đơn hàng "Đã giao".
                <br><strong>Công thức:</strong> Tiền hoa hồng = Giá trị đơn hàng × Tỷ lệ %
                <br><strong>Ví dụ:</strong> Đơn hàng 100,000 VNĐ × 10% = Shipper nhận 10,000 VNĐ
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 5%;">STT</th>
                            <th style="width: 20%;">Mã Nhân Viên</th>
                            <th style="width: 25%;">Họ Tên</th>
                            <th style="width: 15%;">Số Điện Thoại</th>
                            <th style="width: 20%;">Tỷ lệ hoa hồng (%)</th>
                            <th style="width: 15%;">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($shipperList && mysqli_num_rows($shipperList) > 0) {
                            $i = 1;
                            while ($shipper = mysqli_fetch_assoc($shipperList)) {
                                echo "<tr>";
                                echo "<td class='text-center'>{$i}</td>";
                                echo "<td><span class='badge-info'>{$shipper['maNhanVien']}</span></td>";
                                echo "<td>{$shipper['hoTen']}</td>";
                                echo "<td class='text-center'>{$shipper['soDienThoai']}</td>";
                                echo "<td>";
                                echo "<input type='number' class='form-control input-hoahong'
                                      id='hoahong_{$shipper['maNhanVien']}'
                                      value='{$shipper['hoaHongMoiDon']}'
                                      min='0' max='100' step='0.1'
                                      data-manv='{$shipper['maNhanVien']}'>";
                                echo "</td>";
                                echo "<td class='text-center'>";
                                echo "<button class='btn btn-update btn-update-hoahong'
                                      data-manv='{$shipper['maNhanVien']}'>
                                      <i class='fas fa-save'></i> Cập nhật
                                      </button>";
                                echo "</td>";
                                echo "</tr>";
                                $i++;
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>Chưa có shipper nào trong bưu cục này</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Đợi jQuery load xong
        (function checkjQuery() {
            if (typeof jQuery === 'undefined') {
                setTimeout(checkjQuery, 100);
                return;
            }

            jQuery(document).ready(function($) {
                // Xử lý cập nhật hoa hồng
                $('.btn-update-hoahong').click(function() {
                    var maNhanVien = $(this).data('manv');
                    var hoaHongMoiDon = $('#hoahong_' + maNhanVien).val();

                    console.log('Updating: ', maNhanVien, hoaHongMoiDon); // Debug

                    if (hoaHongMoiDon === '' || hoaHongMoiDon < 0 || hoaHongMoiDon > 100) {
                        showAlert('Vui lòng nhập tỷ lệ phần trăm từ 0 đến 100', 'warning');
                        return;
                    }

                    $.ajax({
                        url: '../control/choahong.php',
                        method: 'POST',
                        data: {
                            action: 'updateHoaHong',
                            maNhanVien: maNhanVien,
                            hoaHongMoiDon: hoaHongMoiDon
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log('Response:', response); // Debug
                            if (response.success) {
                                showAlert('Cập nhật hoa hồng thành công!', 'success');
                            } else {
                                showAlert('Lỗi: ' + response.message, 'danger');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX Error:', xhr, status, error); // Debug
                            showAlert('Có lỗi xảy ra khi kết nối server: ' + error, 'danger');
                        }
                    });
                });

                // Hàm hiển thị thông báo
                function showAlert(message, type) {
                    var alertHtml = '<div class="alert alert-' + type + ' alert-dismissible fade show alert-custom" role="alert">' +
                        '<i class="fas fa-check-circle"></i> ' + message +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>';

                    $('#alertContainer').html(alertHtml);

                    setTimeout(function() {
                        $('.alert-custom').fadeOut(function() {
                            $(this).remove();
                        });
                    }, 3000);
                }

                // Format number khi nhập (cho phép số thập phân)
                $('.input-hoahong').on('input', function() {
                    var value = $(this).val();
                    // Cho phép số và dấu chấm thập phân
                    value = value.replace(/[^0-9.]/g, '');
                    // Chỉ cho phép một dấu chấm
                    var parts = value.split('.');
                    if (parts.length > 2) {
                        value = parts[0] + '.' + parts.slice(1).join('');
                    }
                    $(this).val(value);
                });
            });
        })();
    </script>
</div>
