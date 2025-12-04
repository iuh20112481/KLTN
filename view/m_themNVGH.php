<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Nhân Viên Giao Hàng</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Thêm một số kiểu dáng cho form và các yếu tố bên trong */
        option, select, input, textarea {
            font-family: 'Samsung One 400', Arial, sans-serif;
        }

        /* Hiệu ứng hover cho form control */
        .form-control:hover {
            border-color: #3490dc;
            box-shadow: 0 0 10px rgba(52, 144, 220, 0.3);
        }

        /* Hiệu ứng focus */
        .form-control:focus {
            border-color: #38c172;
            box-shadow: 0 0 10px rgba(56, 193, 114, 0.5);
        }

        /* Chuyển tiếp cho form control */
        .form-control {
            transition: all 0.3s ease;
        }

        /* Đổ bóng cho form */
        .form-wrapper {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
        }

        .form-wrapper:hover {
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        /* Hiệu ứng hover cho button */

        button:hover {
            background-color: #38c172;
            box-shadow: 0 0 10px rgba(52, 144, 220, 0.5);
        }
    </style>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <!-- Container cho thông báo -->
    <div id="alertContainer" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;"></div>

    <div class="d-flex justify-content-center align-items-center" style="min-height: 90vh; background-color: #f8f9fa;">  <!-- Căn giữa cả chiều ngang và chiều dọc -->
        <div class="col-md-8 col-lg-6 form-wrapper p-6 rounded-lg" style="background-color: #f3f3f3;">  <!-- Giới hạn chiều rộng -->
            <h2 id="h2-content" class="text-3xl text-center mb-6">Thêm nhân viên giao hàng</h2>

            <form id="employeeForm" method="post" action="../control/cthemNVGH.php"> 
                <div class="row mb-3">
                    <div class="col-md-6">  <!-- Phân phối cột -->
                        <label for="tennv" class="form-label">Tên Nhân Viên</label>
                        <input type="text" class="form-control" id="tennv" name="tennv" placeholder="Nhập tên nhân viên" required>
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label">Mật khẩu</label>  <!-- Sửa tên biến thành password -->
                        <input type="password" class="form-control" id="pass" name="pass" placeholder="Nhập mật khẩu" required>  <!-- Sửa loại input thành password -->
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="sdt" class="form-label">Số Điện Thoại</label>
                        <input type="tel" class="form-control" id="sdt" name="sdt" placeholder="Nhập số điện thoại" required>
                    </div>
                    <div class="col-md-6">
                        <label for="ngaysinh" class="form-label">Ngày Sinh</label>
                        <input type="date" class="form-control" id="ngaysinh" name="ngaysinh" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="gioitinh" class="form-label">Giới Tính</label>
                        <input type="text" class="form-control" id="gioitinh" name="gioitinh" placeholder="Nam/Nữ" required> 
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>  <!-- Sửa tên trường và nhãn -->
                        <input type="email" class="form-control" id="email" name="email" placeholder="Nhập Email" required>  
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="ngaynhan" class="form-label">Mã bưu cục</label>  
                        <input type="text" class="form-control" id="maBuuCuc" name="maBuuCuc" readonly value="<?php 
                                                        $buuCucInfo = $_SESSION['buu_cuc_info'] ?? [];
                                                        if (isset($buuCucInfo["Id_PhanLoaiNguoiDung"])) {
                                                            $_SESSION["nvbc"]["Id_PhanLoaiNguoiDung"] = $buuCucInfo["Id_PhanLoaiNguoiDung"];
                                                        }
                                                            echo $buuCucInfo['maBuuCuc'];?>">
                        <input type="hidden" class="form-control" id="Id_TenBC" name="Id_TenBC" readonly value="<?php 
                                                        $buuCucInfo = $_SESSION['buu_cuc_info'] ?? [];
                                                        if (isset($buuCucInfo["Id_PhanLoaiNguoiDung"])) {
                                                            $_SESSION["nvbc"]["Id_PhanLoaiNguoiDung"] = $buuCucInfo["Id_PhanLoaiNguoiDung"];
                                                        }
                                                            echo $buuCucInfo['Id_TenBC'];?>">                    
                    </div>
                    <div class="col-md-6">
                        <label for="manhanvien" class="form-label">Mã nhân viên</label> 
                        <input type="text" class="form-control" id="manhanvien" name="manhanvien" value="<?php include_once '../control/cdonhang.php';
                                                                                                                $p = new control_donhang();
                                                                                                                $result = $p->getsortMAXNVGH();
                                                                                                                if ($result && $result !== 0) {
                                                                                                                if (mysqli_num_rows($result) > 0) {
                                                                                                                $row = mysqli_fetch_assoc($result);  
                                                                                                                echo '' . $row['maNhanVien'];  
                                                                                                                } else {
                                                                                                                    echo 'Không tìm thấy dữ liệu.';
                                                                                                                }
                                                                                                                } else {
                                                                                                                    echo 'Lỗi truy vấn hoặc không có dữ liệu.';
                                                                                                                }
                                                                                                                ?>" required>
                    </div>
                </div>

                <div class="text-center mt-3 mb-4">
                    <button type="submit" class="btn btn-success col-sm-3 p-2 bg-gradient-success">Thêm Nhân Viên</button>
                </div>
            </form>
        </div>
    </div>

    <!-- jQuery và Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#employeeForm').on('submit', function(e) {
                e.preventDefault(); // Ngăn form submit mặc định

                // Lấy dữ liệu form
                var formData = $(this).serialize();

                // Gửi request AJAX
                $.ajax({
                    url: '../control/cthemNVGH.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        // Hiển thị thông báo
                        showAlert(response.success, response.message);

                        // Nếu thành công, reset form và cập nhật mã nhân viên mới
                        if (response.success) {
                            // Reset form trừ mã bưu cục và Id_TenBC
                            $('#tennv').val('');
                            $('#pass').val('');
                            $('#email').val('');
                            $('#sdt').val('');
                            $('#ngaysinh').val('');
                            $('#gioitinh').val('');

                            // Tăng mã nhân viên lên 1 cho lần thêm tiếp theo
                            var currentMaNV = parseInt($('#manhanvien').val());
                            $('#manhanvien').val(currentMaNV + 1);
                        }
                    },
                    error: function(xhr, status, error) {
                        showAlert(false, 'Có lỗi xảy ra khi gửi dữ liệu: ' + error);
                    }
                });
            });

            // Hàm hiển thị thông báo
            function showAlert(isSuccess, message) {
                var alertType = isSuccess ? 'alert-success' : 'alert-danger';
                var alertTitle = isSuccess ? 'Thành công!' : 'Lỗi!';

                var alertHtml = `
                    <div class="alert ${alertType} alert-dismissible fade show" role="alert">
                        <strong>${alertTitle}</strong> ${message}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                `;

                $('#alertContainer').html(alertHtml);

                // Tự động ẩn sau 5 giây
                setTimeout(function() {
                    $('#alertContainer .alert').fadeOut('slow', function() {
                        $(this).remove();
                    });
                }, 5000);
            }
        });
    </script>
</body>
</html>
