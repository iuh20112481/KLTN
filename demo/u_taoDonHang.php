<?php
// Bắt đầu session
include_once("../control/ctaodonhang.php");

// Hàm chuyển đổi mã địa chỉ sang tên
function getCodeToNameForAddress($table_name, $code_column, $name_column, $code) {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=HPship", "root", "");
        $pdo->exec("set names utf8");

        $query = "SELECT $name_column FROM $table_name WHERE $code_column = :code";
        $statement = $pdo->prepare($query);
        $statement->execute([':code' => $code]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result ? $result[$name_column] : null;
    } catch (PDOException $e) {
        // Xử lý lỗi kết nối cơ sở dữ liệu
        die("Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage());
    }
}

// Xử lý khi nút submit được nhấn
if (isset($_POST["btn_submit"])) {
    // Lấy dữ liệu từ form
    $ngay = date('d/m/Y'); // Ngày hiện tại
    $tenng = $_POST["tenng"];
    $tennn = $_POST["tennn"];
    $dcng = $_POST["dcng"];
    $dcnn = $_POST["dcnn"];
    $telng = $_POST["telng"];
    $telnn = $_POST["telnn"];
    $lvl1 = $_POST["lvl1"];
    $lvl2 = $_POST["lvl2"];
    $lvl3 = $_POST["lvl3"];
    $lvl1_1 = $_POST["lvl1_1"];
    $lvl2_1 = $_POST["lvl2_1"];
    $lvl3_1 = $_POST["lvl3_1"];
    $tensp = $_POST["tensp"];
    $madh = $_POST["madh"];
    $soluong = $_POST["soluong"];
    $khoiluong = $_POST["khoiluong"];
    $chieudai = $_POST["chieudai"];
    $chieurong = $_POST["chieurong"];
    $chieucao = $_POST["chieucao"];
    $ghichu = $_POST["ghichu"];
    $classification = $_POST["classification"];
    $mand = $_SESSION['nguoidung']['id_user']; // ID người dùng
    $phithuho = $_POST["phithuho"];
    $giavanchuyen = $_POST["shipping-cost-hidden"];
    if (isset($_POST["giaohang"])) {
        $giaohang = $_POST["giaohang"];
    } else {
        $giaohang = null;
    }


    // Chuyển đổi mã địa chỉ sang tên
    $lvl1_name = getCodeToNameForAddress('provinces', 'code', 'full_name', $lvl1);
    $lvl2_name = getCodeToNameForAddress('districts', 'code', 'full_name', $lvl2);
    $lvl3_name = getCodeToNameForAddress('wards', 'code', 'full_name', $lvl3);

    $lvl1_1_name = getCodeToNameForAddress('provinces', 'code', 'full_name', $lvl1_1);
    $lvl2_1_name = getCodeToNameForAddress('districts', 'code', 'full_name', $lvl2_1);
    $lvl3_1_name = getCodeToNameForAddress('wards', 'code', 'full_name', $lvl3_1);

    // Chèn dữ liệu vào cơ sở dữ liệu
    $control = new control_taodonhang();
    $result = $control->insertTaoDonHang(
        $tenng, $tennn, $dcng, $dcnn, $telng, $telnn,
        $lvl1_name, $lvl2_name, $lvl3_name,
        $lvl1_1_name, $lvl2_1_name, $lvl3_1_name,
        $tensp, $madh, $soluong,
        $khoiluong, $chieudai, $chieurong, $chieucao,
        $giaohang, $ghichu, $mand, $ngay,
        $classification, $phithuho, $giavanchuyen // Sử dụng giá trị từ trường ẩn
    );

    if ($result) {
        echo "Dữ liệu đã được lưu thành công."; // Thông báo thành công
    } else {
        echo "Lỗi khi lưu dữ liệu."; // Thông báo lỗi nếu lưu không thành công
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />

    <title>Tạo đơn Hàng</title>
  
    <style>
                /* Custom FONT */
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

            h2, h4, #staticBackdropLabel{
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

            #shipping-cost-display{
                font-family: 'SamsungSharpSans-Bold_SMCPS', Arial, sans-serif !important;
    
            }
            #btn_submit {
                font-family: 'Samsung One 700', Arial, sans-serif !important;
                background-color: #ff6339;
                border: none;
                font-size: 18px;
            }
            .body{
                font-size: unset!important;
            }
            .d-flex {
                display: inline-flex !important;
            }
           .fade {
                opacity: 1;
            }
    </style>
</head>

<body name="container-fluid">
    
    <form id="form-id" action="" method="post">
        <div class="container-fluid">
            <br>
            <div class="form-taodon container-fluid">
                <h2>Tạo đơn hàng mới</h2>
                <br>
            <!-- BÊN GỬI -->
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
                                                        <input type="text" class="form-control" id="tenng" name="tenng" placeholder="Nhập họ tên" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="fullName" class="form-label">Số điện thoại </label>
                                                        <input type="tel" class="form-control" id="telng" name="telng" placeholder="Nhập số điện thoại" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="fullName" class="form-label">Địa chỉ</label>
                                                        <input type="text" class="form-control" id="dcng" name="dcng" placeholder="Nhập địa chỉ" required>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="needs-validation" novalidate>

                                                    <div class="mb-3">
                                                            <label for="fullName" class="form-label">Tỉnh thành phố</label>
                                                                <?php
                                                                    include_once '../model/connect.php';
                                                                    $model = new Model();
                                                                    $rows = $model->fetch_lvl1();
                                                                ?>
                                                            <select name="lvl1" id="lvl1" class="form-control selectpicker" data-live-search="true">
                                                                <option value="select">Chọn tỉnh</option>
                                                                <?php
                                                                if (!empty($rows)) {
                                                                    foreach ($rows as $row) { ?>
                                                                        <option value="<?php echo $row['code']; ?>"><?php echo $row['full_name']; ?></option>
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

                <hr style="border: 1px solid #000";>

                <div class="form-container">
            <!-- BÊN NHẬN -->
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
                                                    <input type="text" class="form-control" id="tennn" name="tennn" placeholder="Nhập họ tên" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="fullName" class="form-label">Số điện thoại </label>
                                                    <input type="tel" class="form-control" id="telnn" name="telnn" placeholder="Nhập số điện thoại" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="fullName" class="form-label">Địa chỉ</label>
                                                    <input type="text" class="form-control" id="dcnn" name="dcnn" placeholder="Nhập địa chỉ" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="needs-validation" novalidate>

                                                <div class="mb-3">
                                                        <label for="fullName" class="form-label">Tỉnh thành phố</label>
                                                            <?php
                                                                include_once '../model/connect.php';
                                                                $model = new Model();
                                                                $rows = $model->fetch_lvl1_1();
                                                            ?>
                                                        <select name="lvl1_1" id="lvl1_1" class="form-control selectpicker" data-live-search="true">
                                                            <option value="select">Chọn tỉnh</option>
                                                            <?php
                                                            if (!empty($rows)) {
                                                                foreach ($rows as $row) { ?>
                                                                    <option value="<?php echo $row['code']; ?>"><?php echo $row['full_name']; ?></option>
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
            <hr style="border: 1px solid #000";>
                    
            <!-- SẢN PHẨM -->            
                    <h4 id="h4">Sản phẩm</h4>   

            <div class="container">
                <div class="row">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <form class="row g-4">
                                <div class="col-sm-3">
                                    <label for="productName" class="form-label">Tên sản phẩm</label>
                                    <input type="text" class="form-control" id="tensp" name="tensp" placeholder="Nhập tên sản phẩm" required>
                                </div>

                                <div class="col-sm-3">
                                    <label for="orderCode" class="form-label">Mã đơn hàng</label>
                                    <input type="text" class="form-control" id="madh" name="madh" placeholder="Nhập mã đơn hàng" required>
                                </div>

                                <div class="col-sm-3">
                                    <label for="orderCode" class="form-label">Số lượng</label>
                                    <input type="number" class="form-control" id="soluong" name="soluong" placeholder="Nhập số lượng" required>
                                </div>

                                <div class="col-sm-3">
                                    <label for="option-nganhhang">Ngành hàng</label>
                                    <div class="dropdown-nganhhang">
                                        <select id="classification" name="classification" class="form-control">
                                            <option value="chon" selected disabled>Chọn ngành hàng</option>
                                            <option value="Thời trang">Thời trang</option>
                                            <option value="Thể thao & Dã ngoại">Thể thao & Dã ngoại</option>
                                            <option value="Trang sức và phụ kiện thời trang">Trang sức và phụ kiện thời trang</option>
                                            <option value="Phụ kiện điện thoại, laptop & điện tử ">Phụ kiện điện thoại, laptop & điện tử </option>
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
                                    <input type="number" class="form-control" id="khoiluong" name="khoiluong" placeholder="Nhập khối lượng" required>
                                </div>

                                <div class="col-sm-3">
                                    <label for="length" class="form-label">Chiều dài (m)</label>
                                    <input type="text" class="form-control" id="chieudai" name="chieudai" placeholder="Nhập chiều dài" required>
                                </div>

                                <div class="col-sm-3">
                                    <label for="width" class="form-label">Chiều rộng (m)</label>
                                    <input type="text" class="form-control" id="chieurong" name="chieurong" placeholder="Nhập chiều rộng" required>
                                </div>

                                <div class="col-sm-3">
                                    <label for="height" class="form-label">Chiều cao (m)</label>
                                    <input type="text" class="form-control" id="chieucao" name="chieucao" placeholder="Nhập chiều cao" required>
                                </div>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>     

            <hr style="border: 1px solid #000";>
            <!-- Mục để chọn hình thức vận chuyển -->
            <div class="container text-left">
                <div class="row">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <select class="form-select form-select-lg col-lg-3" id="giaohang" name="giaohang" required>
                                <option value="select" selected disabled>Chọn hình thức vận chuyển</option>
                                <option value="GHN" name="giaohang">Giao Hàng Nhanh</option>
                                <option value="GHTK" name="giaohang">Giao Hàng Tiết Kiệm</option>
                            </select>
                        </li>
                    </ul>
                </div>
            </div>

            <hr style="border: 1px solid #000";>

            <div class="row">
                <div class="col-sm-3">
                            <div class="input-group">
                                <span class="input-group-text"><h4>Phí thu hộ</h4></span>
                                <textarea class="form-control" aria-label="With textarea" name="phithuho" id="phithuho" placeholder="Nhập phí thu hộ" oninput="formatNumber()"></textarea>
                            </div>
                        </div>                                        
                        <!-- GHI CHÚ -->
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-text"><h4>Ghi chú đơn hàng</h4></span>
                                <textarea class="form-control" aria-label="With textarea" name="ghichu" id="ghichu" placeholder="Nhập ghi chú"></textarea>
                            </div>
                        </div>
                </div>
                
            <input type="hidden" id="province_code_display" name="province_code_display" readonly>
            <input type="hidden" id="district_code_display" name="district_code_display" readonly>
            <input type="hidden" id="province_code_display1" name="province_code_display1" readonly>
            <input type="hidden" id="district_code_display1" name="district_code_display1" readonly>
            <input type="hidden" id="khoiluong_copy" name="khoiluong_copy" readonly>

            <input type="hidden" id="province_comparison_result" name="province_comparison_result" readonly placeholder="Tỉnh trùng khớp?">
            <input type="hidden" id="district_comparison_result" name="district_comparison_result" readonly placeholder="Quận/Huyện trùng khớp?">
            <input type="hidden" id="region_comparison_result" name="region_comparison_result" readonly placeholder="Vùng hành chính trùng khớp?">
            <input type="hidden" id="selected-shipping-method" name="selected-shipping-method" readonly placeholder="Hình thức đã chọn">
            <hr style="border: 1px solid #000";>
            <!-- Các trường khác -->

            <br>
            <div class="row">
                <div class="d-flex">  <!-- Đặt các phần tử theo chiều ngang -->
                    <div class="ms-auto">  <!-- Đẩy phần tử sang góc phải -->
                        <div id="shipping-cost-display" style="font-size: 20px; color: #ff6339;"></div>  <!-- Nội dung cần hiển thị -->
                        <input type="hidden" id="shipping-cost-hidden" name="shipping-cost-hidden">  <!-- Trường ẩn -->
                        <div class="d-grid gap-2">
                            <button type="submit" name="btn_submit" class="btn btn-primary" id="btn_submit">Tạo đơn hàng</button>  <!-- Nút submit -->
                        </div>                                    
                    </div>
                </div>
            </div>

        </div>
                                                                
            <br>

            <div style="display:none;">
                    <?php
                    // Thiết lập múi giờ là Asia/Ho_Chi_Minh
                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                    // Lấy ngày hiện tại và in ra màn hình
                    $ngay = date('d/m/Y');
                    echo "<p style='text-algin:center;'>Ngày hiện tại là: $ngay</p>";
                    ?>
            </div>

    </form>

<!-- SCRIPT THANH TÌM KIẾM SELECT -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
<script src="script.js"></script>

<!-- Script -->
<script>
 $(document).ready(function() {
    // Hàm tính chi phí vận chuyển
    function tinhGiaVanChuyen(khoiluong, province_code_giao, province_code_nhan, district_code_giao, district_code_nhan, administrative_region_id_giao, administrative_region_id_nhan, shipping_method) {
        const giaBanDau = 5000; 
        const giaPhatSinh = 2500; 

        let tongGia = giaBanDau;

        // Tính phí phát sinh dựa trên khối lượng
        if (khoiluong > 0.5) {
            tongGia += Math.ceil((khoiluong - 0.5) / 0.5) * giaPhatSinh;
        }

        // Kiểm tra mã tỉnh
        if (province_code_giao !== province_code_nhan) {
            tongGia += 30000; 
        }

        // Kiểm tra quận/huyện
        if (district_code_giao !== district_code_nhan) {
            tongGia += 10000; 
        }

        // Kiểm tra vùng hành chính
        if (administrative_region_id_giao !== administrative_region_id_nhan) {
            tongGia += 20000; 
        }

        // Kiểm tra hình thức vận chuyển
        if (shipping_method === "GHN") {
            tongGia += 12000; 
        } else if (shipping_method === "GHTK") {
            tongGia += 4000; 
        }

        return tongGia;
    }

    // Hàm định dạng số với dấu phân cách hàng nghìn
    function formatWithThousandSeparator(number) {
        return new Intl.NumberFormat('en-GB', {
            style: 'decimal',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(number);
    }

    // Kiểm tra xem tất cả các giá trị cần thiết đã được nhập hay chưa
    function isReadyToCalculate() {
        const khoiluong = parseFloat($("#khoiluong_copy").val());
        const province_code_giao = $("#province_code_display").val();
        const province_code_nhan = $("#province_code_display1").val();
        const district_code_giao = $("#district_code_display").val();
        const district_code_nhan = $("#district_code_display1").val();
        const administrative_region_id_giao = $("#province_comparison_result").val();
        const administrative_region_id_nhan = $("#region_comparison_result").val();
        const shipping_method = $("#selected-shipping-method").val();

        // Kiểm tra tất cả các giá trị quan trọng đã có hay chưa
        return khoiluong > 0 && province_code_giao && province_code_nhan && district_code_giao && district_code_nhan && administrative_region_id_giao && administrative_region_id_nhan && shipping_method;
    }

    // Hàm để tính chi phí vận chuyển và hiển thị
    function calculateShippingCost() {
        if (!isReadyToCalculate()) {
            $("#shipping-cost-hidden").val(""); 
            $("#shipping-cost-display").text(""); 
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

        const shippingCost = tinhGiaVanChuyen(
            khoiluong,
            province_code_giao,
            province_code_nhan,
            district_code_giao,
            district_code_nhan,
            administrative_region_id_giao,
            administrative_region_id_nhan,
            shipping_method
        );

        $("#shipping-cost-hidden").val(shippingCost); 
        const formattedShippingCost = formatWithThousandSeparator(shippingCost);
        $("#shipping-cost-display").html("<div style='font-size: 20px; color: blue;'>Tổng Thanh Toán :</div>" + formattedShippingCost + " VNĐ");
    }

    // Đăng ký sự kiện khi giá trị quan trọng thay đổi
    $("#khoiluong, #lvl1, #lvl1_1, #lvl2, #lvl2_1, #giaohang").on("change", calculateShippingCost);

    // Đảm bảo tính chi phí trước khi gửi form
    $("#form-id").on("submit", function() {
        calculateShippingCost(); 
        return true; 
    });

    });   
</script>

</body>
</html>
