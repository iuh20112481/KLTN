<?php
    if (!isset($_SESSION['user']) || !isset($_SESSION["nguoidung"]['id_user'])) {
        header("Location: dangNhap.php");
        exit();
    }

    if (isset($_SESSION['user']) || isset($_SESSION["nguoidung"]['id_user'])) {
        $conn = new mysqli('localhost', 'root', '', 'HPship');
        if ($conn->connect_error) {
            die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
        }

        $user_id = $_SESSION['nguoidung']['id_user'];
        $sql = "SELECT tenND, sdtND, emailND, mkND, mucDichSuDung, nganhHang, quyMoVanChuyen, diaChi, soTK, maNH FROM taikhoan WHERE Id_TaiKhoan = '$user_id'";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
        } else {
            echo "Không tìm thấy thông tin tài khoản";
        }
        $conn->close();
    } else {
        echo "Bạn chưa đăng nhập";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Update</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- <link rel="stylesheet" href="../css/style.css"> -->
</head>
<style>
    .fade {
        opacity: 1;
    }
    .navbar-nav {
        float: none;
    }
    .container-fluid {
        padding-right: 0;
        padding-left: 0;
        margin-right: 0;
        margin-left: 0;
    }
    .modal-content{
        margin-top: 100px;
    }
    .navbar{
        --bs-navbar-padding-y: 1rem;
        border-radius: 0 ;
        padding: 15px;
    }
    .navbar-nav {
        float: none;
    }
    .navbar-toggler {
        --bs-navbar-toggler-padding-y: 0.8rem ;
        --bs-navbar-toggler-padding-x: 1.5rem ;
        --bs-navbar-toggler-font-size: 1.5rem ;
    }
    .offcanvas {
    background-color: #ecf4fd;
    --bs-offcanvas-padding-x: 1.9rem;
    --bs-offcanvas-padding-y: 1.3rem;
    }
    .bank-option img {
        width: 70px;
        height: 30px;
        margin-right: 10px;
    }
</style>
<body>
    <div class="container-fluid">
        <div class="row justify-content-center mb-3">
            <div class="col-md-8">
                <h2 class="text-center" id="h2-content">Chỉnh sửa thông tin tài khoản</h2>
                <form action="../control/c_updateprofile.php" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tenND">Tên Người Dùng:</label>
                                <input type="text" class="form-control" id="tenND" name="tenND" value="<?php echo $row['tenND']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="sdtND">Số Điện Thoại:</label>
                                <input type="text" class="form-control" id="sdtND" name="sdtND" value="<?php echo $row['sdtND']; ?>" required pattern="0\d{9}">
                            </div>
                            <div class="form-group">
                                <label for="emailND">Email:</label>
                                <input type="email" class="form-control" id="emailND" name="emailND" value="<?php echo $row['emailND']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="mucDichSuDung">Mục Đích Sử Dụng:</label>
                                <select class="form-control" id="mucDichSuDung" name="mucDichSuDung" required>
                                    <option value="Cá nhân" <?php if($row['mucDichSuDung'] == 'Cá nhân') echo 'selected'; ?>>Cá nhân</option>
                                    <option value="Doanh nghiệp" <?php if($row['mucDichSuDung'] == 'Doanh nghiệp') echo 'selected'; ?>>Doanh nghiệp</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="quyMoVanChuyen">Quy Mô Vận Chuyển:</label>
                                <select class="form-control" id="quyMoVanChuyen" name="quyMoVanChuyen" required>
                                    <option value="Không thường xuyên" <?php if($row['quyMoVanChuyen'] == 'Không thường xuyên') echo 'selected'; ?>>Không thường xuyên</option>
                                    <option value="Trên 100 đơn" <?php if($row['quyMoVanChuyen'] == 'Trên 100 đơn') echo 'selected'; ?>>Trên 100 đơn/tháng</option>
                                    <option value="Dưới 100 đơn" <?php if($row['quyMoVanChuyen'] == 'Dưới 100 đơn') echo 'selected'; ?>>Dưới 100 đơn/tháng</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="" class="">Chọn ngân hàng</label>
                                <select id="bank-dropdown" class="form-control">
                                    <option value="">Chọn ngân hàng</option>
                                </select>
                            </div>
                            
                            <input type="text" class="form-control" value="<?php echo $row['maNH']; ?>" readonly>

                            <div class="form-group">
                                <label for="STK">Số Tài Khoản</label>
                                <input type="text" class="form-control" id="STK" name="STK" value="<?php echo $row['soTK']; ?>" required>
                            </div>
                                <input type="hidden" class="form-control" id="output-maNH" name="output-maNH" readonly>
                                <input type="hidden" class="form-control" id="output-soTK" name="output-soTK" readonly>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            <label for="nganhHang">Ngành Hàng:</label>
                                <select class="form-control" id="nganhHang" name="nganhHang" required>
                                    <option value="Thời trang" <?php if($row['nganhHang'] == 'Thời trang') echo 'selected'; ?>>Thời trang</option>
                                        <option value="Mỹ phẩm" <?php if($row['nganhHang'] == 'Mỹ phẩm') echo 'selected'; ?>>Mỹ phẩm</option>
                                        <option value="Thể Thao & Dã Ngoại" <?php if($row['nganhHang'] == 'Thể Thao & Dã Ngoại') echo 'selected'; ?>>Thể Thao & Dã Ngoại</option>
                                        <option value="Trang Sức và phụ kiện thời trang" <?php if($row['nganhHang'] == 'Trang Sức và phụ kiện thời trang') echo 'selected'; ?>>Trang Sức và phụ kiện thời trang</option>
                                        <option value="Phụ kiện điện thoại, Laptop và điện tử" <?php if($row['nganhHang'] == 'Phụ kiện điện thoại, Laptop và điện tử') echo 'selected'; ?>>Phụ kiện điện thoại, Laptop và điện tử</option>
                                        <option value="Tivi, Thiết bị điện da dụng" <?php if($row['nganhHang'] == 'Tivi, Thiết bị điện da dụng') echo 'selected'; ?>>Tivi, Thiết bị điện da dụng</option>
                                        <option value="Đồ gia dụng" <?php if($row['nganhHang'] == 'Đồ gia dụng') echo 'selected'; ?>>Đồ gia dụng</option>
                                        <option value="Hàng hóa dễ vỡ" <?php if($row['nganhHang'] == 'Hàng hóa dễ vỡ') echo 'selected'; ?>>Hàng hóa dễ vỡ</option>
                                        <option value="Thực phẩm - nông sản - hải sản" <?php if($row['nganhHang'] == 'Thực phẩm - nông sản - hải sản') echo 'selected'; ?>>Thực phẩm - nông sản - hải sản</option>
                                        <option value="Sách và văn phòng phẩm" <?php if($row['nganhHang'] == 'Sách và văn phòng phẩm') echo 'selected'; ?>>Sách và văn phòng phẩm</option>
                                        <option value="Cây cối" <?php if($row['nganhHang'] == 'Cây cối') echo 'selected'; ?>>Cây cối</option>
                                        <option value="Điện thoại & thiết bị điện tử" <?php if($row['nganhHang'] == 'Điện thoại & thiết bị điện tử') echo 'selected'; ?>>Điện thoại & thiết bị điện tử</option>
                                        <option value="Xe máy và phương tiện giao thông" <?php if($row['nganhHang'] == 'Xe máy và phương tiện giao thông') echo 'selected'; ?>>Xe máy và phương tiện giao thông</option>
                                        <option value="Hàng tiêu dùng, tạp hóa" <?php if($row['nganhHang'] == 'Hàng tiêu dùng, tạp hóa') echo 'selected'; ?>>Hàng tiêu dùng, tạp hóa</option>
                                    <option value="Khác" <?php if($row['nganhHang'] == 'Khác') echo 'selected'; ?>>Khác</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="diaChi">Địa Chỉ:</label>
                                <input type="text" class="form-control" id="inputDiaChi" name="inputDiaChi" value="<?php echo $row['diaChi']; ?>" required>
                                <br>
                                <input type="text" class="form-control" id="diaChigop" name="diaChigop" readonly>
                            </div>
                            <div class="form-group">
                                <label for="mk">Mật Khẩu:</label>
                                <div class="row">
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="mkND" name="mkND" value="<?php echo $row['mkND']; ?>" required>
                                    </div>
                                    <div class="col-sm-2 pt-2 d-flex align-items-center justify-content-center" style="background-color: #ffe79052; padding-left: 19px; border-radius: 23px; width: 1px;">
                                        <i class="far fa-eye" id="togglePassword"></i>
                                    </div>
                                    </div>
                            </div>
                            <!-- Tỉnh - Quận - Phường selection -->
                            <div class="form-group">
                                <label for="fullName" class="form-label">Tỉnh thành phố</label>
                                <?php
                                    include_once '../model/mFetchAddress.php';
                                    $model = new Model();
                                    $rows = $model->fetch_lvl1();
                                ?>
                                <select name="lvl1" id="lvl1" class="form-control selectpicker" data-live-search="true">
                                    <option value="select">Chọn tỉnh</option>
                                    <?php
                                        if (!empty($rows)) {
                                            foreach ($rows as $row) { ?>
                                                <option value="<?php echo $row['code']; ?>"><?php echo $row['full_name']; ?></option>
                                    <?php   }
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="fullName" class="form-label">Quận huyện</label>
                                <select name="lvl2" id="lvl2" class="form-control selectpicker" data-live-search="true">
                                    <option value="select">Chọn quận</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="fullName" class="form-label">Phường xã</label>
                                <select name="lvl3" id="lvl3" class="form-control selectpicker" data-live-search="true">
                                    <option value="select">Chọn phường xã</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="d-flex">  <!-- Đặt các phần tử theo chiều ngang -->
                            <div class="ms-auto">  <!-- Đẩy phần tử sang góc phải -->
                                <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success">Cập Nhật</button>
                                </div>                                    
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>                                
    <input type="hidden" class="form-control" id="selectedProvince" name="selectedProvince" readonly>
    <input type="hidden" class="form-control" id="selectedDistrict" name="selectedDistrict" readonly>
    <input type="hidden" class="form-control" id="selectedWard" name="selectedWard" readonly>
</body>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
<script src="../js/script.js?=v01"></script>
<script>
        $(document).ready(function() {
            // Khi người dùng chọn tỉnh/thành phố
            $('#lvl1').on('change', function() {
                var selectedProvince = $(this).find("option:selected").text();
                $('#selectedProvince').val(selectedProvince);
                // Load danh sách quận/huyện tương ứng với mã tỉnh/thành phố được chọn
                var provinceCode = $(this).val();
                $.ajax({
                    url: 'fetch_districts.php',
                    type: 'POST',
                    data: { provinceCode: provinceCode },
                    success: function(response) {
                        $('#lvl2').html(response);
                        $('#lvl2').selectpicker('refresh');
                    }
                });
            });

            // Khi người dùng chọn quận/huyện
            $('#lvl2').on('change', function() {
                var selectedDistrict = $(this).find("option:selected").text();
                $('#selectedDistrict').val(selectedDistrict);
                // Load danh sách phường/xã tương ứng với mã quận/huyện được chọn
                var districtCode = $(this).val();
                $.ajax({
                    url: 'fetch_wards.php',
                    type: 'POST',
                    data: { districtCode: districtCode },
                    success: function(response) {
                        $('#lvl3').html(response);
                        $('#lvl3').selectpicker('refresh');
                    }
                });
            });

            // Khi người dùng chọn phường/xã
            $('#lvl3').on('change', function() {
                var selectedWard = $(this).find("option:selected").text();
                $('#selectedWard').val(selectedWard);
            });
        });

        $(document).ready(function() {
            // Lắng nghe sự kiện khi người dùng thay đổi giá trị của các select và input địa chỉ
            $('#lvl1, #lvl2, #lvl3, #inputDiaChi').on('change keyup', function() {
                // Lấy giá trị của các select và input địa chỉ
                var selectedProvince = $('#lvl1 option:selected').text();
                var selectedDistrict = $('#lvl2 option:selected').text();
                var selectedWard = $('#lvl3 option:selected').text();
                var inputAddress = $('#inputDiaChi').val();
                
                // Gộp các giá trị lại thành địa chỉ hoàn chỉnh
                var address = inputAddress + ', ' + selectedWard + ', ' + selectedDistrict + ', ' + selectedProvince;
                
                // Đưa địa chỉ gộp vào input diaChigop
                $('#diaChigop').val(address);
            });
        });
        // HIDDEN MẬT KHẨU 
        document.getElementById("togglePassword").addEventListener("click", function (event) {
            // Kiểm tra nếu người dùng click vào icon togglePassword
            if (event.target.id === "togglePassword") {
                var passwordField = document.getElementById("mkND");
                var type = passwordField.type === "password" ? "text" : "password";
                passwordField.type = type;

                this.classList.toggle("fa-eye");
                this.classList.toggle("fa-eye-slash");
            }
        });
</script>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- SCRIPT CHO SELECT NGÂN HÀNG  -->
    <script>
        $(document).ready(function() {
            // URL của API
            const apiUrl = 'https://api.vietqr.io/v2/banks';

            // Fetch dữ liệu từ API
            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.code === '00') {
                        // Lấy phần tử dropdown
                        const dropdown = $('#bank-dropdown');

                        // Duyệt qua danh sách ngân hàng và thêm vào dropdown
                        data.data.forEach(bank => {
                            const option = new Option(bank.name, bank.short_name, false, false);
                            dropdown.append(option).trigger('change');
                            const $option = $(option);
                            $option.data('img-src', bank.logo); // Lưu đường dẫn ảnh trong data attribute
                        });

                        // Khởi tạo Select2 với template để hiển thị hình ảnh
                        $('#bank-dropdown').select2({
                            templateResult: formatState,
                            templateSelection: formatState
                        });
                    } else {
                        console.error('Không thể lấy danh sách ngân hàng:', data.desc);
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi lấy danh sách ngân hàng:', error);
                });

            // Hàm để hiển thị template với hình ảnh
            function formatState(state) {
                if (!state.id) {
                    return state.text;
                }
                var $state = $(
                    '<span class="bank-option"><img src="' + $(state.element).data('img-src') + '" class="img-flag" /> ' + state.text + '</span>'
                );
                return $state;
            }

            // Bắt sự kiện thay đổi giá trị của dropdown và input
            $('#bank-dropdown').on('change', function() {
                var maNH = $(this).val();
                $('#output-maNH').val(maNH);
                console.log('Mã Ngân Hàng:', maNH);
            });

            $('#STK').on('input', function() {
                var soTK = $(this).val();
                $('#output-soTK').val(soTK);
                console.log('Số Tài Khoản:', soTK);
            });
        });
    </script>
</body>
</html>
