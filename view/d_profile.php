<?php
    if (!isset($_SESSION['user']) || !isset($_SESSION["nvgh"]['id_user'])) {
        header("Location: dangNhap.php");
        exit();
    }

    if (isset($_SESSION['user']) || isset($_SESSION["nvgh"]['id_user'])) {
        $conn = new mysqli('localhost', 'root', '', 'HPship');
        if ($conn->connect_error) {
            die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
        }

        $user_id = $_SESSION['nvgh']['id_user'];
        $sql = "SELECT tenND, sdtND, emailND, mkND, mucDichSuDung, nganhHang, quyMoVanChuyen, diaChi FROM taikhoan WHERE Id_TaiKhoan = '$user_id'";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
    <!-- <link rel="stylesheet" href="../css/style.css"> -->
</head>
<style>
    .bootstrap-select.btn-group .btn .caret {
        display: none;
    }
    .container-fluid::before {
        content: none !important;
    }
    .container-fluid::after {
        content: none !important;
    }
    .bg-body-tertiary {
        --bs-bg-opacity: 1;
        background-color: rgb(36 213 207) !important;
    }
    .offcanvas{
        background-color: #ecf4fd;
        --bs-offcanvas-padding-x: 1.9rem;
        --bs-offcanvas-padding-y: 1.6rem;
    }    
    .navbar{
        --bs-navbar-padding-y: 1rem;
    }
    .navbar-nav {
        float: none;
    }
    .navbar-toggler {
        --bs-navbar-toggler-padding-y: 0.8rem ;
        --bs-navbar-toggler-padding-x: 1.5rem ;
        --bs-navbar-toggler-font-size: 1.5rem ;
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

                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="diaChi">Địa Chỉ:</label>
                                <input type="text" class="form-control" id="inputDiaChi" name="inputDiaChi" value="<?php echo $row['diaChi']; ?>" placeholder="Nhập Số nhà và tên đường" required>
                                <br>
                                <input type="text" class="form-control" id="diaChigop" name="diaChigop" readonly>
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
</body>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
<script src="../js/script.js"></script>
<script>
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
</body>
</html>
