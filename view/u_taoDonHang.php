<?php
// Bắt đầu session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Xác định đường dẫn gốc
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

// KIỂM TRA QUYỀN TRUY CẬP
// Phần kiểm tra quyền truy cập - CẬP NHẬT
$isCustomerLoggedIn = isset($_SESSION['user']) && $_SESSION['user']['role'] == 'khachhang';
$isStaffCreating = isset($_SESSION['staff_creating_order']) && $_SESSION['staff_creating_order'] === true;

if (!$isCustomerLoggedIn && !$isStaffCreating) {
    header("Location: dangNhap.php");
    exit();
}


// Include Controller
include_once(BASE_PATH . "/control/ctaodonhang.php");

// LẤY THÔNG TIN NGƯỜI GỬI
$row = ['tenND' => '', 'sdtND' => '', 'diaChi' => '']; 

if ($isCustomerLoggedIn && !$isStaffCreating) {
    if (isset($_SESSION['nguoidung']['id_user'])) {
        $conn = new mysqli('localhost', 'root', '', 'HPship');
        
        if (!$conn->connect_error) {
            $user_id = mysqli_real_escape_string($conn, $_SESSION['nguoidung']['id_user']);
            $sql = "SELECT tenND, sdtND, diaChi FROM taikhoan WHERE Id_TaiKhoan = '$user_id'";
            $result = $conn->query($sql);
            
            if ($result && $result->num_rows == 1) {
                $row = $result->fetch_assoc();
            }
            $conn->close();
        }
    }
}

// Hàm chuyển đổi mã địa chỉ
function getCodeToNameForAddress($table_name, $code_column, $name_column, $code) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=HPship", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec("SET NAMES utf8");

        $query = "SELECT $name_column FROM $table_name WHERE $code_column = :code";
        $statement = $pdo->prepare($query);
        $statement->execute([':code' => $code]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result ? $result[$name_column] : null;
    } catch (PDOException $e) {
        error_log("Lỗi getCodeToNameForAddress: " . $e->getMessage());
        return null;
    }
}

// XỬ LÝ SUBMIT FORM
if (isset($_POST["btn_submit"])) {
    $ngay = date('Y-m-d');
    $tenng = $_POST["tenng"] ?? '';
    $tennn = $_POST["tennn"] ?? '';
    $dcng = $_POST["dcng"] ?? '';
    $dcnn = $_POST["dcnn"] ?? '';
    $telng = $_POST["telng"] ?? '';
    $telnn = $_POST["telnn"] ?? '';
    $lvl1 = $_POST["lvl1"] ?? '';
    $lvl2 = $_POST["lvl2"] ?? '';
    $lvl3 = $_POST["lvl3"] ?? '';
    $lvl1_1 = $_POST["lvl1_1"] ?? '';
    $lvl2_1 = $_POST["lvl2_1"] ?? '';
    $lvl3_1 = $_POST["lvl3_1"] ?? '';
    $tensp = $_POST["tensp"] ?? '';
    $madh = $_POST["madh"] ?? '';
    $soluong = $_POST["soluong"] ?? 0;
    $khoiluong = $_POST["khoiluong"] ?? 0;
    $chieudai = $_POST["chieudai"] ?? 0;
    $chieurong = $_POST["chieurong"] ?? 0;
    $chieucao = $_POST["chieucao"] ?? 0;
    $ghichu = $_POST["ghichu"] ?? '';
    $classification = $_POST["classification"] ?? '';
    $phithuho = $_POST["total-cost-with-phithuho"] ?? 0;
    $giavanchuyen = $_POST["shipping_cost"] ?? 0;
    $giaohang = $_POST["shipping_method"] ?? null;
    
    if ($isStaffCreating) {
        $mand = null;
    } else {
        $mand = $_SESSION['nguoidung']['id_user'] ?? null;
    }
    
    $lvl1_name = getCodeToNameForAddress('provinces', 'code', 'full_name', $lvl1);
    $lvl2_name = getCodeToNameForAddress('districts', 'code', 'full_name', $lvl2);
    $lvl3_name = getCodeToNameForAddress('wards', 'code', 'full_name', $lvl3);
    $lvl1_1_name = getCodeToNameForAddress('provinces', 'code', 'full_name', $lvl1_1);
    $lvl2_1_name = getCodeToNameForAddress('districts', 'code', 'full_name', $lvl2_1);
    $lvl3_1_name = getCodeToNameForAddress('wards', 'code', 'full_name', $lvl3_1);

    $control = new control_taodonhang();
    $result = $control->insertTaoDonHang(
        $tenng, $tennn, $dcng, $dcnn, $telng, $telnn,
        $lvl1_name, $lvl2_name, $lvl3_name,
        $lvl1_1_name, $lvl2_1_name, $lvl3_1_name,
        $tensp, $madh, $soluong, $khoiluong, $chieudai, 
        $chieurong, $chieucao, $giaohang, $ghichu, 
        $mand, $ngay, $classification, $phithuho, $giavanchuyen
    );

    if ($result) {
        echo "<script>alert('Đơn hàng đã được tạo thành công!');</script>";
    } else {
        echo "<script>alert('Lỗi khi tạo đơn hàng!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Đơn Hàng</title>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css" />
    
    <style>
        @font-face {
            font-family: 'Samsung One 400';
            src: url('../WEBSITE_EXHIBITION/font/SamsungOne-400.ttf') format('woff2'),
                url('../WEBSITE_EXHIBITION/font/SamsungOne-400.ttf') format('truetype');
            font-weight: 400;
            font-style: normal;
        }
        @font-face {
            font-family: 'Samsung One 700';
            src: url('../font/SamsungOne-700.ttf') format('truetype');
            font-weight: 700;
            font-style: normal;
        }
        @font-face {
            font-family: 'SamsungSharpSans-Bold_SMCPS';
            src: url('../font/iCiel-SamsungSharpSans-Bold_SMCPS.ttf') format('truetype');
            font-weight: bold;
            font-style: normal;
        }
        h2, h4, #staticBackdropLabel {
            font-family: 'SamsungSharpSans-Bold_SMCPS', Arial, sans-serif !important;
        }
        label {
            font-family: 'Samsung One 700', Arial, sans-serif !important;
        }
        .btn-outline-primary {
            --bs-btn-active-bg: none !important;
            --bs-btn-active-color: #11007a !important;
            --bs-btn-color: #000000;
        }
        .bootstrap-select.btn-group .btn .caret {
            display: none;
        }
        #shipping-cost-display {
            font-family: 'SamsungSharpSans-Bold_SMCPS', Arial, sans-serif !important;
        }
        #btn_submit {
            font-family: 'Samsung One 700', Arial, sans-serif !important;
            background-color: #ff6339;
            border: none;
            font-size: 18px;
        }
        .body {
            font-size: unset!important;
        }
        .d-flex {
            display: inline-flex !important;
        }
        .fade {
            opacity: 1;
        }
        .modal-content {
            margin-top: 69px;
        }
    </style>
</head>

<body name="container-fluid">
    <form id="form-id" action="" method="post">
        <div class="container-fluid">
            <div class="form-taodon container-fluid">
                <h2>Tạo đơn hàng mới</h2>
                <br>
                <h4 id="h4">Bên gửi</h4>
                
                <div class="container">
                    <table class="table table-bordered">
                        <tr>
                            <td id="myTable" class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="needs-validation" novalidate>
                                            <div class="mb-3">
                                                <label for="fullName" class="form-label">Họ và tên</label>
                                                <input type="text" class="form-control" id="tenng" name="tenng" 
                                                       placeholder="Nhập họ tên" 
                                                       value="<?php echo htmlspecialchars($row['tenND'] ?? ''); ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="fullName" class="form-label">Số điện thoại</label>
                                                <input type="tel" class="form-control" id="telng" name="telng" 
                                                       placeholder="Nhập số điện thoại" 
                                                       value="<?php echo htmlspecialchars($row['sdtND'] ?? ''); ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="fullName" class="form-label">Địa chỉ</label>
                                                <input type="text" class="form-control" id="dcng" name="dcng" 
                                                       placeholder="Nhập địa chỉ" 
                                                       value="<?php echo htmlspecialchars($row['diaChi'] ?? ''); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="needs-validation" novalidate>
                                            <div class="mb-3">
                                                <label for="fullName" class="form-label">Tỉnh thành phố</label>
                                                <?php
                                                    include_once(BASE_PATH . '/model/mFetchAddress.php');
                                                    $model = new Model();
                                                    $rows_provinces = $model->fetch_lvl1();
                                                ?>
                                                <select name="lvl1" id="lvl1" class="form-control selectpicker" data-live-search="true">
                                                    <option value="select">Chọn tỉnh</option>
                                                    <?php
                                                    if (!empty($rows_provinces)) {
                                                        foreach ($rows_provinces as $province) { ?>
                                                            <option value="<?php echo htmlspecialchars($province['code']); ?>">
                                                                <?php echo htmlspecialchars($province['full_name']); ?>
                                                            </option>
                                                    <?php }
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="fullName" class="form-label">Quận huyện</label>
                                                <select name="lvl2" id="lvl2" class="form-control selectpicker" data-live-search="true">
                                                    <option value="select">Chọn quận</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="fullName" class="form-label">Phường xã</label>
                                                <select name="lvl3" id="lvl3" class="form-control selectpicker" data-live-search="true">
                                                    <option value="select">Chọn phường xã</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>                            
                            </td>
                        </tr>
                    </table>
                </div>

                <hr style="border: 1px solid #000">

                <div class="form-container">
                    <h4 id="h4">Bên nhận</h4>

                    <div class="container">
                        <table class="table table-bordered">
                            <tr>
                                <td id="myTable" class="needs-validation" novalidate>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="needs-validation" novalidate>
                                                <div class="mb-3">
                                                    <label for="fullName" class="form-label">Họ và tên</label>
                                                    <input type="text" class="form-control" id="tennn" name="tennn" 
                                                           placeholder="Nhập họ tên" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="fullName" class="form-label">Số điện thoại</label>
                                                    <input type="tel" class="form-control" id="telnn" name="telnn" 
                                                           placeholder="Nhập số điện thoại" required>
                                                    <div id="phone-error" style="color: red; display: none;">
                                                        Số điện thoại không hợp lệ. Vui lòng nhập số bắt đầu bằng 0 và có đúng 10 ký tự số.
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="fullName" class="form-label">Địa chỉ</label>
                                                    <input type="text" class="form-control" id="dcnn" name="dcnn" 
                                                           placeholder="Nhập địa chỉ" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="needs-validation" novalidate>
                                                <div class="mb-3">
                                                    <label for="fullName" class="form-label">Tỉnh thành phố</label>
                                                    <?php
                                                        $rows_provinces_1 = $model->fetch_lvl1_1();
                                                    ?>
                                                    <select name="lvl1_1" id="lvl1_1" class="form-control selectpicker" data-live-search="true">
                                                        <option value="select">Chọn tỉnh</option>
                                                        <?php
                                                        if (!empty($rows_provinces_1)) {
                                                            foreach ($rows_provinces_1 as $province_1) { ?>
                                                                <option value="<?php echo htmlspecialchars($province_1['code']); ?>">
                                                                    <?php echo htmlspecialchars($province_1['full_name']); ?>
                                                                </option>
                                                        <?php }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="fullName" class="form-label">Quận huyện</label>
                                                    <select name="lvl2_1" id="lvl2_1" class="form-control selectpicker" data-live-search="true">
                                                        <option value="select">Chọn quận</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="fullName" class="form-label">Phường xã</label>
                                                    <select name="lvl3_1" id="lvl3_1" class="form-control selectpicker" data-live-search="true">
                                                        <option value="select">Chọn phường xã</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                            
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>  

                <hr style="border: 1px solid #000">
                    
                <h4 id="h4">Sản phẩm</h4>   

                <div class="container">
                    <div class="row">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <form class="row g-4">
                                    <div class="col-sm-3">
                                        <label for="productName" class="form-label">Tên sản phẩm</label>
                                        <input type="text" class="form-control" id="tensp" name="tensp" 
                                               placeholder="Nhập tên sản phẩm" required>
                                    </div>

                                    <div class="col-sm-3">
                                        <label for="orderCode" class="form-label">Mã đơn hàng</label>
                                        <input type="text" class="form-control" id="madh" name="madh" 
                                               placeholder="Nhập mã đơn hàng" required>
                                    </div>

                                    <div class="col-sm-3">
                                        <label for="orderCode" class="form-label">Số lượng</label>
                                        <input type="number" class="form-control" id="soluong" name="soluong" 
                                               placeholder="Nhập số lượng" required>
                                    </div>

                                    <div class="col-sm-3">
                                        <label for="option-nganhhang">Ngành hàng</label>
                                        <div class="dropdown-nganhhang">
                                            <select id="classification" name="classification" class="form-control selectpicker">
                                                <option value="chon" selected disabled>Chọn ngành hàng</option>
                                                <option value="Thời trang">Thời trang</option>
                                                <option value="Thể thao & Dã ngoại">Thể thao & Dã ngoại</option>
                                                <option value="Trang sức và phụ kiện thời trang">Trang sức và phụ kiện thời trang</option>
                                                <option value="Phụ kiện điện thoại, laptop & điện tử">Phụ kiện điện thoại, laptop & điện tử</option>
                                                <option value="Tivi, thiết bị điện gia dụng">Tivi, thiết bị điện gia dụng</option>
                                                <option value="Đồ gia dụng">Đồ gia dụng</option>
                                                <option value="Hàng hóa dễ vỡ">Hàng hóa dễ vỡ</option>
                                                <option value="Thực phẩm, nông sản, hải sản">Thực phẩm, nông sản, hải sản</option>
                                                <option value="Sách & Văn phòng phẩm">Sách & Văn phòng phẩm</option>
                                                <option value="Mỹ phẩm">Mỹ phẩm</option>
                                                <option value="Điện thoại & thiết bị điện tử">Điện thoại & thiết bị điện tử</option>
                                                <option value="Xe máy & Phương tiện giao thông">Xe máy & Phương tiện giao thông</option>
                                                <option value="Cây cối">Cây cối</option>
                                                <option value="Hàng tiêu dùng, tạp hóa">Hàng tiêu dùng, tạp hóa</option>
                                                <option value="Khác">Khác</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <label for="weight" class="form-label">Khối lượng (KG)</label>
                                        <input type="number" class="form-control" id="khoiluong" name="khoiluong" 
                                               placeholder="Nhập khối lượng" required>
                                    </div>

                                    <div class="col-sm-3">
                                        <label for="length" class="form-label">Chiều dài (m)</label>
                                        <input type="text" class="form-control" id="chieudai" name="chieudai" 
                                               placeholder="Nhập chiều dài" required>
                                    </div>

                                    <div class="col-sm-3">
                                        <label for="width" class="form-label">Chiều rộng (m)</label>
                                        <input type="text" class="form-control" id="chieurong" name="chieurong" 
                                               placeholder="Nhập chiều rộng" required>
                                    </div>

                                    <div class="col-sm-3">
                                        <label for="height" class="form-label">Chiều cao (m)</label>
                                        <input type="text" class="form-control" id="chieucao" name="chieucao" 
                                               placeholder="Nhập chiều cao" required>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>     

                <hr style="border: 1px solid #000">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-check p-5">
                            <input class="form-check-input" type="checkbox" value="5000" id="phithuho" 
                                   style="padding:12px; backgound:dsd">
                            <label class="form-check-label" for="phithuho">
                                <h4>Phí thu hộ <i style="font-size: small;">(5.000 VNĐ)</i></h4>
                            </label>
                            <input type="hidden" id="total-cost-with-phithuho" name="total-cost-with-phithuho">
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <span class="input-group-text"><h4>Ghi chú đơn hàng</h4></span>
                            <textarea class="form-control" aria-label="With textarea" name="ghichu" id="ghichu" 
                                      placeholder="Nhập ghi chú"></textarea>
                        </div>
                    </div>
                </div>

                <hr style="border: 1px solid #000">
                <div class="row" id="form-id">
                    <div class="col-6">
                        <label for="discount-code" class="form-label">Hình thức giao hàng</label>
                        <select class="form-control selectpicker" id="selected-shipping-method" name="shipping_method">
                            <option value="" selected disabled>Chọn hình thức giao hàng</option>
                            <option value="GHN">Giao Hàng Nhanh (+12.000 VND)</option>
                            <option value="GHTK">Giao Hàng Tiết Kiệm (+4.000 VNĐ)</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="discount-code" class="form-label text-center">Nhập mã khuyến mãi</label>
                        <input class="form-control" type="text" id="discount-code" name="discount_code" 
                               placeholder="Nhập mã khuyến mãi">
                        <div id="discount-error" style="color: red; display: none;">Mã giảm giá không hợp lệ.</div>
                        <div id="discount-success" style="color: green; display: none;">Mã giảm giá hợp lệ.</div>
                        <input type="hidden" id="discountPercent" name="discount_percent">
                    </div>
                </div>

                <input type="hidden" id="province_code_display" name="province_code_display" readonly>
                <input type="hidden" id="district_code_display" name="district_code_display" readonly>
                <input type="hidden" id="province_code_display1" name="province_code_display1" readonly>
                <input type="hidden" id="district_code_display1" name="district_code_display1" readonly>
                <input type="hidden" id="khoiluong_copy" name="khoiluong_copy" readonly>
                <input type="hidden" id="province_comparison_result" name="province_comparison_result" readonly>
                <input type="hidden" id="district_comparison_result" name="district_comparison_result" readonly>
                <input type="hidden" id="region_comparison_result" name="region_comparison_result" readonly>
                <input type="hidden" id="selected-shipping-method" name="selected-shipping-method" readonly>
                
                <hr style="border: 1px solid #000">
                <br>

                <div class="row">
                    <div class="d-flex">
                        <div class="ms-auto">
                            <div id="shipping-cost-display" style="font-size: 20px; color: #ff6339;"></div>
                            <input type="hidden" id="shipping-cost-hidden" name="shipping_cost">                            
                            <div class="d-grid gap-2">
                                <button type="submit" name="btn_submit" class="btn btn-primary" id="btn_submit">
                                    Tạo đơn hàng
                                </button>
                            </div>                                    
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </div>
    </form>

<!-- ✅ QUAN TRỌNG: Thứ tự load JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="../js/script.js"></script>

<!-- ✅ Không cần setTimeout nữa vì script.js đã tự kiểm tra -->

<!-- ✅ FIX: Khởi tạo Bootstrap Select SAU KHI load xong -->
<script>
// Đợi 500ms để đảm bảo tất cả thư viện đã load
setTimeout(function() {
    console.log("=== INITIALIZING BOOTSTRAP SELECT ===");
    
    // Kiểm tra thư viện
    if (typeof $ === 'undefined') {
        alert('LỖI: jQuery chưa load!');
        return;
    }
    
    if (typeof $.fn.selectpicker === 'undefined') {
        alert('LỖI: Bootstrap Select chưa load!');
        return;
    }
    
    // Destroy selectpicker cũ (nếu có)
    try {
        $('.selectpicker').selectpicker('destroy');
    } catch(e) {
        console.log('Không có selectpicker cũ');
    }
    
    // Khởi tạo lại với config mới
    $('.selectpicker').selectpicker({
        liveSearch: true,
        size: 10,
        style: 'btn-default',
        width: '100%'
    });
    
    console.log('✅ Bootstrap Select initialized');
    console.log('✅ Options in #lvl1:', $('#lvl1 option').length);
    console.log('✅ Options in #lvl1_1:', $('#lvl1_1 option').length);
    
}, 500);
</script>

<!-- Script tính phí và discount -->
<script>
    $(document).ready(function() {
        const discountCodeInput = $("#discount-code");
        const discountError = $("#discount-error");
        const discountSuccess = $("#discount-success");

        function checkDiscountCode() {
            const discountCode = discountCodeInput.val();
            console.log("Mã giảm giá:", discountCode);

            fetch('../API/API_KM.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ discountCode: discountCode })
            })
            .then(response => response.json())
            .then(data => {
                console.log("Kết quả trả về từ server:", data);

                if (data.valid) {
                    discountError.css("display", "none");
                    discountSuccess.css("display", "block");
                    discountSuccess.text(`Mã giảm giá hợp lệ. Giảm giá ${data.discountPercent}%`);

                    $("#discountPercent").val(data.discountPercent);
                    calculateShippingCost();
                } else {
                    discountError.css("display", "block");
                    discountSuccess.css("display", "none");
                    discountError.text("Mã giảm giá không hợp lệ.");

                    $("#discountPercent").val(0);
                    calculateShippingCost();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                discountError.css("display", "block");
                discountSuccess.css("display", "none");
                discountError.text("Có lỗi xảy ra. Vui lòng thử lại.");
            });
        }

        discountCodeInput.on("change", checkDiscountCode);  

        function tinhGiaVanChuyen(khoiluong, province_code_giao, province_code_nhan, district_code_giao, district_code_nhan, administrative_region_id_giao, administrative_region_id_nhan, shipping_method) {
            const giaBanDau = 5000;
            const giaPhatSinh = 2500;
            let tongGia = giaBanDau;

            if (khoiluong > 0.5) {
                tongGia += Math.ceil((khoiluong - 0.5) / 0.5) * giaPhatSinh;
            }

            if (province_code_giao !== province_code_nhan) {
                tongGia += 30000;
            }

            if (district_code_giao !== district_code_nhan) {
                tongGia += 10000;
            }

            if (administrative_region_id_giao !== administrative_region_id_nhan) {
                tongGia += 20000;
            }

            if (shipping_method === "GHN") {
                tongGia += 12000;
            } else if (shipping_method === "GHTK") {
                tongGia += 4000;
            }

            return tongGia;
        }

        function formatWithThousandSeparator(number) {
            return new Intl.NumberFormat('en-GB', {
                style: 'decimal',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(number);
        }

        function isReadyToCalculate() {
            const khoiluong = parseFloat($("#khoiluong_copy").val());
            const province_code_giao = $("#province_code_display").val();
            const province_code_nhan = $("#province_code_display1").val();
            const district_code_giao = $("#district_code_display").val();
            const district_code_nhan = $("#district_code_display1").val();
            const administrative_region_id_giao = $("#province_comparison_result").val();
            const administrative_region_id_nhan = $("#region_comparison_result").val();
            const shipping_method = $("#selected-shipping-method").val();

            return khoiluong > 0 && province_code_giao && province_code_nhan && district_code_giao && district_code_nhan && administrative_region_id_giao && administrative_region_id_nhan && shipping_method;
        }

        function calculateShippingCost() {
            if (!isReadyToCalculate()) {
                $("#shipping-cost-hidden").val("");
                $("#shipping-cost-display").text("");
                $("#total-cost-with-phithuho").val("");
                return;
            }

            const khoiluong = parseFloat($("#khoiluong_copy").val());
            const province_code_giao = $("#province_code_display").val();
            const province_code_nhan = $("#province_code_display1").val();
            const district_code_giao = $("#district_code_display").val();
            const district_code_nhan = $("#district_code_display1").val();
            const administrative_region_id_giao = $("#province_comparison_result").val();
            const administrative_region_id_nhan = $("#region_comparison_result").val();
            const shipping_method = $("#selected-shipping-method").val();
            const discountPercent = parseFloat($("#discountPercent").val()) || 0;

            let shippingCost = tinhGiaVanChuyen(
                khoiluong,
                province_code_giao,
                province_code_nhan,
                district_code_giao,
                district_code_nhan,
                administrative_region_id_giao,
                administrative_region_id_nhan,
                shipping_method
            );

            const phithuhoChecked = $("#phithuho").is(":checked");

            if (phithuhoChecked) {
                shippingCost += 5000;
            }

            const discountAmount = (discountPercent / 100) * shippingCost;
            const finalCost = shippingCost - discountAmount;

            $("#shipping-cost-hidden").val(finalCost);

            if (phithuhoChecked) {
                $("#total-cost-with-phithuho").val(shippingCost);
            } else {
                $("#total-cost-with-phithuho").val("");
            }

            const formattedShippingCost = formatWithThousandSeparator(shippingCost);
            const formattedDiscountAmount = formatWithThousandSeparator(discountAmount);
            const formattedFinalCost = formatWithThousandSeparator(finalCost);

            $("#shipping-cost-display").html(`
                <div style='font-size: 18px; color: blue;'>Thành tiền :</div>
                ${formattedShippingCost} VNĐ
                <div style='font-size: 18px; color: #181800;'>Khuyến mãi :</div>
                - ${formattedDiscountAmount} VNĐ
                <hr style="border: 1px solid #000";>
                <div style='font-size: 25px; color: green;'>Tổng chi phí :</div>
                ${formattedFinalCost} VNĐ
            `);
        }

        const selectors = "#khoiluong_copy, #province_code_display, #province_code_display1, #district_code_display, #district_code_display1, #province_comparison_result, #region_comparison_result, #selected-shipping-method, #discount-code, #phithuho";
        $(selectors).on("change", calculateShippingCost);

        $("#form-id").on("submit", function() {
            calculateShippingCost();
            return true;
        });
    });
</script>

<!-- Validate số điện thoại -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const phoneInput = document.getElementById("telnn");
        const phoneError = document.getElementById("phone-error");

        function validatePhoneNumber() {
            const phoneNumber = phoneInput.value;
            const phoneRegex = /^0\d{9}$/;

            if (phoneRegex.test(phoneNumber)) {
                phoneError.style.display = "none";
                return true;
            } else {
                phoneError.style.display = "block";
                return false;
            }
        }

        phoneInput.addEventListener("input", validatePhoneNumber);

        const form = phoneInput.closest("form");
        if (form) {
            form.addEventListener("submit", function(event) {
                if (!validatePhoneNumber()) {
                    event.preventDefault();
                }
            });
        }
    });
</script>

</body>
</html>