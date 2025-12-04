<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhân viên bưu cục</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .buucuc-section {
            margin-bottom: 30px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        .buucuc-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 20px;
            font-weight: bold;
            font-size: 18px;
        }
        .buucuc-info {
            background-color: #f8f9fa;
            padding: 10px 20px;
            border-bottom: 1px solid #ddd;
        }
        .buucuc-table {
            margin: 0;
        }
        .nhandonhang {
            width: 100%;
            border-collapse: collapse;
        }
        .nhandonhang thead {
            background-color: #e9ecef;
        }
        .nhandonhang th {
            padding: 12px;
            text-align: center;
            border: 1px solid #dee2e6;
        }
        .nhandonhang td {
            padding: 10px;
            border: 1px solid #dee2e6;
        }
        .nhandonhang tbody tr:hover {
            background-color: #f1f3f5;
        }
        .badge-buucuc {
            background-color: #667eea;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 14px;
        }
        .empty-message {
            text-align: center;
            padding: 20px;
            color: #6c757d;
        }
        .btn-add-staff {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 6px 15px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-add-staff:hover {
            background-color: #218838;
            color: white;
        }
        .buucuc-header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .buucuc-header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        /* Fix table column widths */
        .nhandonhang th:nth-child(1), .nhandonhang td:nth-child(1) { width: 80px !important; }
        .nhandonhang th:nth-child(2), .nhandonhang td:nth-child(2) { width: 200px !important; }
        .nhandonhang th:nth-child(3), .nhandonhang td:nth-child(3) { width: 140px !important; }
        .nhandonhang th:nth-child(4), .nhandonhang td:nth-child(4) { width: 150px !important; }
        .nhandonhang th:nth-child(5), .nhandonhang td:nth-child(5) { width: 250px !important; }
        .nhandonhang th:nth-child(6), .nhandonhang td:nth-child(6) { width: 120px !important; }
        .nhandonhang th:nth-child(7), .nhandonhang td:nth-child(7) { width: 120px !important; }
    </style>
</head>
<body>
<?php
    // Include the staff account management controller
    include_once "../control/ctaikhoan.php";

    // Create an instance of the staff account controller
    $p = new controller_tk();

    // Handle GET requests for staff member deletion
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['q'], $_GET['id'])) {
            $action = $_GET['q'];
            $idTaiKhoan = $_GET['id'];

            if ($action === 'delete' && $idTaiKhoan) {
                $deleteResult = $p->deleteNVBC($idTaiKhoan);

                // Handle deletion success or failure
                if ($deleteResult) {
                    echo "<script>alert('Xóa nhân viên bưu cục thành công!');</script>";
                    echo "<script>window.location.href = '?page=qlnvbc';</script>";
                } else {
                    echo "<script>alert('Lỗi xóa nhân viên bưu cục!');</script>";
                }
            }
        }
    }

    // Fetch ALL post offices (including those without staff)
    $allBuuCuc = $p->getAllBuuCuc();

    // Fetch a list of post office staff
    $dsNVBC = $p->getDSNVBC();

    // Initialize array with all post offices
    $nvbcByBuuCuc = [];
    foreach ($allBuuCuc as $buucuc) {
        $nvbcByBuuCuc[$buucuc['maBuuCuc']] = [
            'tenBuuCuc' => $buucuc['tenBuuCuc'],
            'diaChiBC' => $buucuc['diaChiBC'],
            'maBuuCucCode' => $buucuc['maBuuCuc'],
            'danhSach' => []
        ];
    }

    // Add staff to their respective post offices
    foreach ($dsNVBC as $nvbc) {
        $maBuuCucCode = $nvbc['maBuuCucCode']; // Use code from tenbc table
        if (isset($nvbcByBuuCuc[$maBuuCucCode])) {
            $nvbcByBuuCuc[$maBuuCucCode]['danhSach'][] = $nvbc;
        }
    }

    // Sort post offices by number of staff (descending - most staff first)
    uasort($nvbcByBuuCuc, function($a, $b) {
        return count($b['danhSach']) - count($a['danhSach']);
    });

    echo "<br>";
    echo "<div class='container-fluid'>";
    echo "<h2 id='h2-content' class='text-center mb-4'>QUẢN LÝ NHÂN VIÊN BƯU CỤC</h2>";

    if (count($nvbcByBuuCuc) > 0) {
        foreach ($nvbcByBuuCuc as $maBuuCuc => $info) {
            $soLuongNV = count($info['danhSach']);
            echo "<div class='buucuc-section'>";
            echo "<div class='buucuc-header'>";
            echo "<div class='buucuc-header-content'>";
            echo "<div class='buucuc-header-left'>";
            echo "<i class='fas fa-building'></i> Bưu cục: {$maBuuCuc} - {$info['tenBuuCuc']}";
            echo "</div>";
            echo "<div class='buucuc-header-left'>";
            echo "<span class='badge-buucuc'>{$soLuongNV} nhân viên</span>";
            echo "<button class='btn-add-staff' onclick='showAddStaffModal(\"{$info['maBuuCucCode']}\", \"{$info['tenBuuCuc']}\")'>";
            echo "<i class='fas fa-user-plus'></i> Thêm nhân viên";
            echo "</button>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "<div class='buucuc-info'>";
            echo "<i class='fas fa-map-marker-alt'></i> Địa chỉ: {$info['diaChiBC']}";
            echo "</div>";

            echo "<table class='nhandonhang buucuc-table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th style='width: 80px;'>ID</th>";
            echo "<th>Họ và tên</th>";
            echo "<th style='width: 140px;'>Số điện thoại</th>";
            echo "<th style='width: 150px;'>Chức vụ</th>";
            echo "<th>Email</th>";
            echo "<th style='width: 120px;'>Mã nhân viên</th>";
            echo "<th style='width: 120px;'>Thao tác</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            if (count($info['danhSach']) > 0) {
                foreach ($info['danhSach'] as $nvbc) {
                    echo "<tr>";
                    echo "<td class='text-center'>{$nvbc['Id_TaiKhoan']}</td>";
                    echo "<td>{$nvbc['tenND']}</td>";
                    echo "<td class='text-center'>{$nvbc['sdtND']}</td>";
                    echo "<td>{$nvbc['loaiNguoiDung']}</td>";
                    echo "<td>{$nvbc['emailND']}</td>";
                    echo "<td class='text-center'>{$nvbc['maNhanVien']}</td>";
                    echo "<td class='text-center'><button class='btn btn-danger btn-sm delete-btn' data-id='{$nvbc['Id_TaiKhoan']}' data-name='{$nvbc['tenND']}'>Xóa</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr>";
                echo "<td colspan='7' class='text-center' style='padding: 20px; color: #6c757d;'>";
                echo "<i class='fas fa-user-slash'></i> Chưa có nhân viên nào trong bưu cục này";
                echo "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        }
    } else {
        echo "<div class='empty-message'>";
        echo "<i class='fas fa-inbox fa-3x mb-3'></i>";
        echo "<h4>Không có nhân viên bưu cục nào trong hệ thống</h4>";
        echo "</div>";
    }

    echo "</div>";
?>

<!-- Modal xác nhận xóa -->
<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle"></i> Xác nhận xóa
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa nhân viên bưu cục:</p>
                <p class="text-center"><strong id="employee-name" style="font-size: 18px; color: #dc3545;"></strong></p>
                <p class="text-muted">Hành động này không thể hoàn tác!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <a id="delete-confirm-btn" href="#" class="btn btn-danger">Xác nhận xóa</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal thêm nhân viên bưu cục -->
<div class="modal fade" id="add-staff-modal" tabindex="-1" role="dialog" aria-labelledby="addStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h5 class="modal-title" id="addStaffModalLabel">
                    <i class="fas fa-user-plus"></i> Thêm nhân viên bưu cục
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <strong>Bưu cục:</strong> <span id="selected-buucuc-name"></span> (<span id="selected-buucuc-code"></span>)
                </div>
                <form id="add-staff-form">
                    <input type="hidden" id="form-buucuc-code" name="maBuuCuc">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="staff-name">Họ và tên <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="staff-name" name="tenND" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="staff-phone">Số điện thoại <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control" id="staff-phone" name="sdtND" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="staff-email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="staff-email" name="emailND" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="staff-password">Mật khẩu <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="staff-password" name="mkND" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="staff-gender">Giới tính</label>
                            <select class="form-control" id="staff-gender" name="gioiTinh">
                                <option value="Nam">Nam</option>
                                <option value="Nữ">Nữ</option>
                                <option value="Khác">Khác</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="staff-birthdate">Ngày sinh</label>
                            <input type="date" class="form-control" id="staff-birthdate" name="ngaySinh">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="staff-code">Mã nhân viên <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="staff-code" name="maNhanVien" readonly required placeholder="Sẽ được tạo tự động">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-info-circle" title="Mã tự động theo format: NVBC-{Tỉnh}-{BưuCục}-00x"></i>
                                </span>
                            </div>
                        </div>
                        <small class="text-muted">Format: NVBC-{Tỉnh}-{BưuCục}-001 (VD: NVBC-HCM-BDBT-001)</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                <button type="button" class="btn btn-primary" onclick="submitAddStaff()">
                    <i class="fas fa-save"></i> Lưu thông tin
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

<script>
$(document).ready(function() {
    // Handle delete button click
    $('.delete-btn').on('click', function(e) {
        e.preventDefault();

        var employeeId = $(this).data('id');
        var employeeName = $(this).data('name');

        // Set employee name in modal
        $('#employee-name').text(employeeName);

        // Set delete URL with parameters
        var deleteUrl = '?page=qlnvbc&q=delete&id=' + employeeId;
        $('#delete-confirm-btn').attr('href', deleteUrl);

        // Show modal
        $('#delete-modal').modal('show');
    });
});

// Function to generate staff code based on post office code
// Input: QS-BCHCM-BDBT -> Output: NVBC-HCM-BDBT-
function generateStaffCode(maBuuCucCode) {
    // Extract from code: QS-BCHCM-BDBT
    // Split by dash
    var parts = maBuuCucCode.split('-');

    if (parts.length >= 3) {
        // parts[0] = QS (prefix for buucuc)
        // parts[1] = BCHCM (BC = Bưu Cục, HCM = Hồ Chí Minh)
        // parts[2] = BDBT (Bạch Đằng Bình Thạnh)

        var provinceCode = parts[1]; // BCHCM, BCHN, BCDN, etc
        var officeCode = parts[2];   // BDBT, NDDD, etc

        // Extract city code from provinceCode (remove BC prefix)
        var cityCode = provinceCode.substring(2); // HCM, HN, DN, etc

        return 'NVBC-' + cityCode + '-' + officeCode + '-';
    }

    // Fallback
    return 'NVBC-XXX-XXX-';
}

// Function to show add staff modal
function showAddStaffModal(maBuuCucCode, tenBuuCuc) {
    // Set bưu cục info
    $('#selected-buucuc-code').text(maBuuCucCode);
    $('#selected-buucuc-name').text(tenBuuCuc);
    $('#form-buucuc-code').val(maBuuCucCode);

    // Clear form
    $('#add-staff-form')[0].reset();
    $('#form-buucuc-code').val(maBuuCucCode); // Set lại sau khi reset

    // Generate staff code prefix
    var codePrefix = generateStaffCode(maBuuCucCode);
    $('#staff-code').attr('placeholder', codePrefix + '00x (Tự động sinh)');

    // Show modal
    $('#add-staff-modal').modal('show');
}

// Function to submit add staff form
function submitAddStaff() {
    // Validate form
    var form = $('#add-staff-form')[0];
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    // Generate staff code
    var maBuuCucCode = $('#selected-buucuc-code').text();
    var codePrefix = generateStaffCode(maBuuCucCode);
    var staffCode = codePrefix + '001'; // You can implement auto-increment later
    $('#staff-code').val(staffCode);

    // Get form data
    var formData = {
        tenND: $('#staff-name').val(),
        sdtND: $('#staff-phone').val(),
        emailND: $('#staff-email').val(),
        mkND: $('#staff-password').val(),
        gioiTinh: $('#staff-gender').val(),
        ngaySinh: $('#staff-birthdate').val(),
        maNhanVien: staffCode,
        maBuuCuc: $('#selected-buucuc-code').text() // Use code, not name
    };

    // Disable submit button to prevent double submission
    var submitBtn = $('.btn-primary[onclick="submitAddStaff()"]');
    submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...');

    // Send AJAX request
    $.ajax({
        url: '../API/addNVBC.php',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert(response.message);
                $('#add-staff-modal').modal('hide');
                // Reload page to show new staff
                window.location.href = '?page=qlnvbc';
            } else {
                alert('Lỗi: ' + response.message);
                submitBtn.prop('disabled', false).html('<i class="fas fa-save"></i> Lưu thông tin');
            }
        },
        error: function(xhr, status, error) {
            alert('Lỗi kết nối server: ' + error);
            submitBtn.prop('disabled', false).html('<i class="fas fa-save"></i> Lưu thông tin');
        }
    });
}
</script>

</body>
</html>
