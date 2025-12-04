<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách nhân viên giao hàng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<?php
    // Include the staff account management controller
    include_once "../control/ctaikhoan.php";

    // Kiểm tra quyền: Admin hay NVBC
    $isAdmin = isset($_SESSION['admin']) ? true : false;
    $maBuuCucDefault = 'all';

    if (!$isAdmin && isset($_SESSION['buu_cuc_info']['maBuuCuc'])) {
        // NVBC chỉ xem của bưu cục mình
        $maBuuCucDefault = $_SESSION['buu_cuc_info']['maBuuCuc'];
    }

    // Create an instance of the staff account controller
    $p = new controller_tk();

    // Handle GET requests for staff member deletion
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['q'], $_GET['id'])) {
            $action = $_GET['q'];
            $idTaiKhoan = $_GET['id'];

            if ($action === 'delete' && $idTaiKhoan) {
                $deleteResult = $p->deleteNVGH($idTaiKhoan);

                // Handle deletion success or failure
                if ($deleteResult) {
                    echo "<script>alert('Xóa nhân viên giao hàng thành công!')</script>";
                } else {
                    echo "<script>alert('Lỗi xóa nhân viên giao hàng!')</script>";
                }
            }
        }
    }

    echo "<script> var defaultMaBuuCuc = " . json_encode($maBuuCucDefault) . ";</script>";
    echo "<script> var isAdmin = " . json_encode($isAdmin) . ";</script>";
?>

    <div class="container-fluid">
        <!-- Header -->
        <div class="row mt-3 mb-3">
            <div class="col-md-12">
                <h2 id="h2-content" class="text-center">QUẢN LÝ NHÂN VIÊN GIAO HÀNG</h2>
            </div>
        </div>

        <!-- Bộ lọc bưu cục và nút thêm NVGH (chỉ cho Admin) -->
        <?php if ($isAdmin): ?>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <label for="selectBuuCucFilter" class="form-label fw-bold">
                            <i class="fa-solid fa-building"></i> Lọc theo bưu cục:
                        </label>
                        <select class="form-select form-control" id="selectBuuCucFilter" onchange="filterByBuuCuc()">
                            <option value="all">Tất cả bưu cục</option>
                            <!-- Các option sẽ được thêm bằng JavaScript -->
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <button class="btn btn-success btn-lg" onclick="openAddNVGHModal()" style="width: 100%;">
                    <i class="fa-solid fa-plus"></i> Thêm nhân viên giao hàng
                </button>
            </div>
        </div>
        <?php endif; ?>

        <!-- Bảng danh sách NVGH -->
        <table class='nhandonhang' id="tableNVGH">
            <thead>
                <tr>
                    <th class='th-style0'>ID Tài khoản</th>
                    <th class='th-style0'>Họ và tên</th>
                    <th class='th-style0'>Số điện thoại</th>
                    <th class='th-style0'>Chức vụ</th>
                    <th class='th-style0'>Email</th>
                    <th class='th-style0'>Mã nhân viên</th>
                    <th class='th-style0'>Mã bưu cục</th>
                    <th class='th-style0'>Thao tác</th>
                </tr>
            </thead>

            <tbody id="tableBodyNVGH">
                <!-- Dữ liệu sẽ được load bằng JavaScript -->
            </tbody>
        </table>

        <!-- Modal chi tiết nhân viên -->
        <div class="modal fade" id="nvModal" tabindex="-1" role="dialog" aria-labelledby="nvModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="nvModalLabel">Thông tin nhân viên</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>ID Tài khoản:</strong> <span class="thongtin" id="nvId"></span></p>
                        <p><strong>Họ và tên:</strong> <span class="thongtin" id="nvName"></span></p>
                        <p><strong>Số điện thoại:</strong> <span class="thongtin" id="nvPhone"></span></p>
                        <p><strong>Chức vụ:</strong> <span class="thongtin" id="nvRole"></span></p>
                        <p><strong>Email:</strong> <span class="thongtin" id="nvEmail"></span></p>
                        <p><strong>Mã nhân viên:</strong> <span class="thongtin" id="nvStaffCode"></span></p>
                        <p><strong>Mã bưu cục:</strong> <span class="thongtin" id="nvPostalCode"></span></p>
                        <p><strong>Số lượng đơn hàng:</strong> <span class="thongtin" id="tongDonHang"></span></p>
                        <p><strong>Số lượng đơn đã giao:</strong> <span class="thongtin" id="tongdondagiao"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal thêm nhân viên giao hàng -->
        <div class="modal fade" id="addNVGHModal" tabindex="-1" role="dialog" aria-labelledby="addNVGHModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNVGHModalLabel">Thêm nhân viên giao hàng</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formAddNVGH">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="addHoTen">Họ và tên <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="addHoTen" name="hoTen" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="addSDT">Số điện thoại <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="addSDT" name="sdt" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="addEmail">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="addEmail" name="email" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="addBuuCuc">Bưu cục <span class="text-danger">*</span></label>
                                        <select class="form-control" id="addBuuCuc" name="maBuuCuc" required>
                                            <option value="">-- Chọn bưu cục --</option>
                                            <!-- Danh sách bưu cục sẽ được load bằng JavaScript -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="addMatKhau">Mật khẩu <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="addMatKhau" name="matKhau" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="addMaNVGH">Mã nhân viên (tự động)</label>
                                <input type="text" class="form-control" id="addMaNVGH" name="maNhanVien" readonly>
                                <small class="form-text text-muted">Mã sẽ được tạo tự động dựa trên bưu cục được chọn</small>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        <button type="button" class="btn btn-success" onclick="submitAddNVGH()">
                            <i class="fa-solid fa-save"></i> Lưu
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        let allNVGH = []; // Lưu trữ toàn bộ danh sách NVGH

        // Load danh sách bưu cục (chỉ cho admin)
        function loadDanhSachBuuCuc() {
            if (!isAdmin) return;

            fetch('http://localhost:8080/WEBSITE_EXHIBITION/API/API_getDanhSachBuuCuc.php')
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        const selectFilter = document.getElementById('selectBuuCucFilter');
                        const selectAdd = document.getElementById('addBuuCuc');

                        result.data.forEach(buuCuc => {
                            // Thêm vào dropdown lọc
                            const optionFilter = document.createElement('option');
                            optionFilter.value = buuCuc.maBuuCuc;
                            optionFilter.textContent = buuCuc.tenBuuCuc + ' - ' + buuCuc.diaChiBC;
                            selectFilter.appendChild(optionFilter);

                            // Thêm vào dropdown form thêm NVGH
                            const optionAdd = document.createElement('option');
                            optionAdd.value = buuCuc.maBuuCuc;
                            optionAdd.textContent = buuCuc.tenBuuCuc + ' - ' + buuCuc.diaChiBC;
                            selectAdd.appendChild(optionAdd);
                        });
                    }
                })
                .catch(error => console.error('Lỗi khi load danh sách bưu cục:', error));
        }

        // Mở modal thêm NVGH
        function openAddNVGHModal() {
            document.getElementById('formAddNVGH').reset();
            document.getElementById('addMaNVGH').value = '';
            $('#addNVGHModal').modal('show');
        }

        // Tự động tạo mã NVGH khi chọn bưu cục
        $('#addBuuCuc').on('change', function() {
            const maBuuCuc = $(this).val();
            if (maBuuCuc) {
                fetch(`http://localhost:8080/WEBSITE_EXHIBITION/API/API_getNextMaNVGH.php?maBuuCuc=${maBuuCuc}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('addMaNVGH').value = data.maNVGH;
                        }
                    })
                    .catch(error => console.error('Lỗi:', error));
            }
        });

        // Submit form thêm NVGH
        function submitAddNVGH() {
            const form = document.getElementById('formAddNVGH');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            const formData = {
                hoTen: document.getElementById('addHoTen').value,
                sdt: document.getElementById('addSDT').value,
                email: document.getElementById('addEmail').value,
                maBuuCuc: document.getElementById('addBuuCuc').value,
                matKhau: document.getElementById('addMatKhau').value,
                maNhanVien: document.getElementById('addMaNVGH').value
            };

            fetch('http://localhost:8080/WEBSITE_EXHIBITION/API/API_addNVGH.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Thêm nhân viên giao hàng thành công!');
                    $('#addNVGHModal').modal('hide');
                    loadDanhSachNVGH($('#selectBuuCucFilter').val() || 'all');
                } else {
                    alert('Lỗi: ' + (data.message || 'Không thể thêm nhân viên'));
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                alert('Lỗi kết nối!');
            });
        }

        // Load danh sách NVGH
        function loadDanhSachNVGH(maBuuCuc = 'all') {
            const url = maBuuCuc === 'all'
                ? 'http://localhost:8080/WEBSITE_EXHIBITION/API/API_getAllNVGH.php'
                : `http://localhost:8080/WEBSITE_EXHIBITION/API/API_getNVGHByBuuCuc.php?maBuuCuc=${maBuuCuc}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    allNVGH = data;
                    displayNVGH(data);
                })
                .catch(error => console.error('Lỗi:', error));
        }

        // Hiển thị danh sách NVGH
        function displayNVGH(data) {
            const tbody = document.getElementById('tableBodyNVGH');
            tbody.innerHTML = '';

            if (data.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" class="text-center">Không có dữ liệu</td></tr>';
                return;
            }

            data.forEach(nvgh => {
                const row = document.createElement('tr');
                row.className = 'nv-row';
                row.setAttribute('data-toggle', 'modal');
                row.setAttribute('data-target', '#nvModal');
                row.setAttribute('data-id', nvgh.Id_TaiKhoan);
                row.setAttribute('data-name', nvgh.tenND);
                row.setAttribute('data-phone', nvgh.sdtND);
                row.setAttribute('data-role', nvgh.loaiNguoiDung);
                row.setAttribute('data-email', nvgh.emailND);
                row.setAttribute('data-staff-code', nvgh.maNhanVien);
                row.setAttribute('data-postal-code', nvgh.maBuuCuc);

                row.innerHTML = `
                    <td class="text-center">${nvgh.Id_TaiKhoan}</td>
                    <td>${nvgh.tenND}</td>
                    <td class="text-center">${nvgh.sdtND}</td>
                    <td>${nvgh.loaiNguoiDung}</td>
                    <td>${nvgh.emailND}</td>
                    <td class="text-center">${nvgh.maNhanVien}</td>
                    <td class="text-center">${nvgh.maBuuCuc}</td>
                    <td class="text-center">
                        <button class="btn btn-accept delete-btn" data-id="${nvgh.Id_TaiKhoan}" onclick="event.stopPropagation()">
                            Xóa Nhân viên
                        </button>
                    </td>
                `;
                tbody.appendChild(row);
            });

            // Re-attach event handlers
            attachEventHandlers();
        }

        // Filter theo bưu cục
        function filterByBuuCuc() {
            const selectElement = document.getElementById('selectBuuCucFilter');
            const maBuuCuc = selectElement.value;
            loadDanhSachNVGH(maBuuCuc);
        }

        // Attach event handlers
        function attachEventHandlers() {
            // Event cho dòng trong bảng
            $(".nv-row").off('click').on('click', function(e) {
                if ($(e.target).hasClass('delete-btn') || $(e.target).closest('.delete-btn').length) {
                    return;
                }

                const id = $(this).data("id");
                const name = $(this).data("name");
                const phone = $(this).data("phone");
                const role = $(this).data("role");
                const email = $(this).data("email");
                const staffCode = $(this).data("staff-code");
                const postalCode = $(this).data("postal-code");

                $("#nvId").text(id);
                $("#nvName").text(name);
                $("#nvPhone").text(phone);
                $("#nvRole").text(role);
                $("#nvEmail").text(email);
                $("#nvStaffCode").text(staffCode);
                $("#nvPostalCode").text(postalCode);

                // Lấy thông tin đơn hàng
                $.ajax({
                    url: '../control/ctaikhoan.php',
                    type: 'POST',
                    data: { maNhanVien: staffCode },
                    success: function(response) {
                        const data = JSON.parse(response);
                        if (data.tongdonhang !== undefined && data.tongdondagiao !== undefined) {
                            $("#tongDonHang").text(data.tongdonhang);
                            $("#tongdondagiao").text(data.tongdondagiao);
                        } else {
                            $("#tongDonHang").text('Không có dữ liệu');
                            $("#tongdondagiao").text('Không có dữ liệu');
                        }
                    },
                    error: function() {
                        $("#tongDonHang").text('Lỗi kết nối');
                        $("#tongdondagiao").text('Lỗi kết nối');
                    }
                });
            });

            // Event cho nút xóa
            $(".delete-btn").off('click').on('click', function(e) {
                e.stopPropagation();
                const idTaiKhoan = $(this).data("id");

                if (confirm("Bạn có chắc chắn muốn xóa nhân viên này?")) {
                    $.ajax({
                        url: 'admin_giaodiennguoidung.php?page=adsnvgh&q=delete&id=' + idTaiKhoan,
                        type: 'GET',
                        success: function(response) {
                            alert('Xóa nhân viên thành công!');
                            // Reload lại danh sách
                            if (isAdmin) {
                                const currentFilter = $('#selectBuuCucFilter').val();
                                loadDanhSachNVGH(currentFilter);
                            } else {
                                loadDanhSachNVGH(defaultMaBuuCuc);
                            }
                        },
                        error: function() {
                            alert('Lỗi xóa nhân viên giao hàng!');
                        }
                    });
                }
            });
        }

        // Load dữ liệu khi trang được tải
        $(document).ready(function() {
            if (isAdmin) {
                loadDanhSachBuuCuc();
            }
            loadDanhSachNVGH(defaultMaBuuCuc);
        });
    </script>

</body>
</html>
