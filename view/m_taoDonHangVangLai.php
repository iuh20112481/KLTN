<?php
// ===== PARTIAL VIEW - Được include vào m_giaodiennguoidung.php =====
// Không có <!DOCTYPE>, <html>, <head>, <body> vì parent đã có

// Xác định đường dẫn gốc
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

// Lấy thông tin nhân viên từ session (đã được set trong parent)
$nhanVien = $_SESSION['nvbc'] ?? [];
$id_nhanvien = $nhanVien['id'] ?? null;
$id_buucuc = $nhanVien['id_buucuc'] ?? null;

// Include Controller & Model
include_once(BASE_PATH . "/control/ctaodonhang.php");
include_once(BASE_PATH . "/model/connect1.php");

// Hàm tạo mã vận đơn
function generateMaVanDon() {
    $prefix = 'HP';
    $timestamp = date('ymd');
    $random = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
    return $prefix . $timestamp . $random;
}

// Hàm chuyển đổi mã địa chỉ sang tên
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

// Xử lý submit form
$message = '';
$messageType = '';

if (isset($_POST["btn_submit_vanglai"])) {
    $ngay = date('Y-m-d');
    $tenng = trim($_POST["tenng"] ?? '');
    $telng = trim($_POST["telng"] ?? '');
    $dcng = trim($_POST["dcng"] ?? '');
    $tennn = trim($_POST["tennn"] ?? '');
    $telnn = trim($_POST["telnn"] ?? '');
    $dcnn = trim($_POST["dcnn"] ?? '');
    $lvl1 = $_POST["lvl1"] ?? '';
    $lvl2 = $_POST["lvl2"] ?? '';
    $lvl3 = $_POST["lvl3"] ?? '';
    $lvl1_1 = $_POST["lvl1_1"] ?? '';
    $lvl2_1 = $_POST["lvl2_1"] ?? '';
    $lvl3_1 = $_POST["lvl3_1"] ?? '';
    $tensp = trim($_POST["tensp"] ?? '');
    $madh = trim($_POST["madh"] ?? '');
    $soluong = intval($_POST["soluong"] ?? 0);
    $khoiluong = floatval($_POST["khoiluong"] ?? 0);
    $chieudai = floatval($_POST["chieudai"] ?? 0);
    $chieurong = floatval($_POST["chieurong"] ?? 0);
    $chieucao = floatval($_POST["chieucao"] ?? 0);
    $ghichu = trim($_POST["ghichu"] ?? '');
    $classification = $_POST["classification"] ?? '';
    $phithuho = floatval($_POST["total-cost-with-phithuho"] ?? 0);
    $giavanchuyen = floatval($_POST["shipping_cost"] ?? 0);
    $giaohang = $_POST["shipping_method"] ?? null;
    $mand = null; // Khách vãng lai

    // Chuyển đổi mã địa chỉ
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
        $maVanDon = generateMaVanDon();
        $message = "Đơn hàng khách vãng lai đã được tạo thành công! Mã vận đơn: " . $maVanDon;
        $messageType = 'success';
    } else {
        $message = "Lỗi khi tạo đơn hàng!";
        $messageType = 'error';
    }
}
?>

<!-- CSS cho trang này -->
<style>
    .form-vanglai {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .alert-vanglai {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        border-left: 5px solid #ffd700;
    }
    .alert-vanglai h4 { margin: 0 0 5px 0; color: white; }
    .alert-vanglai p { margin: 0; font-size: 13px; opacity: 0.9; }
    .section-title {
        font-weight: bold;
        margin: 20px 0 15px 0;
        padding-bottom: 10px;
        border-bottom: 2px solid #eee;
    }
    .form-group { margin-bottom: 15px; }
    .btn-submit-vanglai {
        background-color: #ff6339;
        border: none;
        color: white;
        padding: 12px 30px;
        font-size: 16px;
        border-radius: 5px;
    }
    .btn-submit-vanglai:hover {
        background-color: #e55a33;
        color: white;
    }
    #shipping-cost-display-vl {
        font-size: 18px;
        color: #ff6339;
        font-weight: bold;
    }
</style>

<div class="form-vanglai">
    <!-- Banner -->
    <div class="alert-vanglai">
        <h4><i class="fa fa-user-plus"></i> Tạo đơn hàng - Khách vãng lai</h4>
        <p>Đơn hàng cho khách không có tài khoản | NV: <?php echo htmlspecialchars($nhanVien['ten'] ?? 'N/A'); ?></p>
    </div>

    <!-- Thông báo -->
    <?php if ($message): ?>
    <div class="alert alert-<?php echo $messageType == 'success' ? 'success' : 'danger'; ?>">
        <?php echo $message; ?>
    </div>
    <?php endif; ?>

    <form id="form-vanglai" action="?page=taoDonHangVangLai" method="post">

        <!-- NGƯỜI GỬI -->
        <div class="section-title"><i class="fa fa-paper-plane"></i> Thông tin người gửi</div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Họ tên <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="tenng" placeholder="Họ tên khách hàng" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Số điện thoại <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" name="telng" placeholder="0xxxxxxxxx" required pattern="0[0-9]{9}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Địa chỉ <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="dcng" placeholder="Số nhà, tên đường" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Tỉnh/Thành phố <span class="text-danger">*</span></label>
                    <?php
                        include_once(BASE_PATH . '/model/mFetchAddress.php');
                        $model = new Model();
                        $rows_provinces = $model->fetch_lvl1();
                    ?>
                    <select name="lvl1" id="lvl1_vl" class="form-control" required>
                        <option value="">Chọn tỉnh/thành</option>
                        <?php
                        if (!empty($rows_provinces)) {
                            foreach ($rows_provinces as $province) {
                                echo '<option value="' . htmlspecialchars($province['code']) . '">' . htmlspecialchars($province['full_name']) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Quận/Huyện <span class="text-danger">*</span></label>
                    <select name="lvl2" id="lvl2_vl" class="form-control" required>
                        <option value="">Chọn quận/huyện</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Phường/Xã <span class="text-danger">*</span></label>
                    <select name="lvl3" id="lvl3_vl" class="form-control" required>
                        <option value="">Chọn phường/xã</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- NGƯỜI NHẬN -->
        <div class="section-title"><i class="fa fa-map-marker"></i> Thông tin người nhận</div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Họ tên <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="tennn" placeholder="Họ tên người nhận" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Số điện thoại <span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" name="telnn" placeholder="0xxxxxxxxx" required pattern="0[0-9]{9}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Địa chỉ <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="dcnn" placeholder="Số nhà, tên đường" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Tỉnh/Thành phố <span class="text-danger">*</span></label>
                    <?php $rows_provinces_1 = $model->fetch_lvl1_1(); ?>
                    <select name="lvl1_1" id="lvl1_1_vl" class="form-control" required>
                        <option value="">Chọn tỉnh/thành</option>
                        <?php
                        if (!empty($rows_provinces_1)) {
                            foreach ($rows_provinces_1 as $province) {
                                echo '<option value="' . htmlspecialchars($province['code']) . '">' . htmlspecialchars($province['full_name']) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Quận/Huyện <span class="text-danger">*</span></label>
                    <select name="lvl2_1" id="lvl2_1_vl" class="form-control" required>
                        <option value="">Chọn quận/huyện</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Phường/Xã <span class="text-danger">*</span></label>
                    <select name="lvl3_1" id="lvl3_1_vl" class="form-control" required>
                        <option value="">Chọn phường/xã</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- SẢN PHẨM -->
        <div class="section-title"><i class="fa fa-box"></i> Thông tin sản phẩm</div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Tên sản phẩm <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="tensp" placeholder="Tên sản phẩm" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Mã đơn hàng</label>
                    <input type="text" class="form-control" name="madh" placeholder="Mã tham chiếu">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Số lượng <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="soluong" value="1" min="1" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Ngành hàng</label>
                    <select name="classification" class="form-control">
                        <option value="">Chọn ngành</option>
                        <option value="Thời trang">Thời trang</option>
                        <option value="Điện tử">Điện tử</option>
                        <option value="Thực phẩm">Thực phẩm</option>
                        <option value="Hàng dễ vỡ">Hàng dễ vỡ</option>
                        <option value="Khác">Khác</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Khối lượng (KG) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="khoiluong_vl" name="khoiluong" step="0.01" min="0.01" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Dài (m)</label>
                    <input type="number" class="form-control" name="chieudai" step="0.1">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Rộng (m)</label>
                    <input type="number" class="form-control" name="chieurong" step="0.1">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Cao (m)</label>
                    <input type="number" class="form-control" name="chieucao" step="0.1">
                </div>
            </div>
        </div>

        <!-- GIAO HÀNG & GHI CHÚ -->
        <div class="section-title"><i class="fa fa-truck"></i> Giao hàng & Thanh toán</div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Hình thức giao <span class="text-danger">*</span></label>
                    <select name="shipping_method" id="shipping_method_vl" class="form-control" required>
                        <option value="">Chọn hình thức</option>
                        <option value="GHN">Giao Hàng Nhanh (+12.000đ)</option>
                        <option value="GHTK">Giao Hàng Tiết Kiệm (+4.000đ)</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Phí thu hộ</label>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="phithuho_vl" value="5000"> Thu hộ (+5.000đ)
                        </label>
                    </div>
                    <input type="hidden" name="total-cost-with-phithuho" id="total-cost-phithuho-vl">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Ghi chú</label>
                    <textarea class="form-control" name="ghichu" rows="2" placeholder="Ghi chú đơn hàng"></textarea>
                </div>
            </div>
        </div>

        <!-- TỔNG PHÍ & SUBMIT -->
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-6">
                <div id="shipping-cost-display-vl"></div>
                <input type="hidden" name="shipping_cost" id="shipping-cost-hidden-vl">
            </div>
            <div class="col-md-6 text-right">
                <button type="submit" name="btn_submit_vanglai" class="btn btn-submit-vanglai">
                    <i class="fa fa-check-circle"></i> Tạo đơn hàng
                </button>
            </div>
        </div>
    </form>
</div>

<!-- JavaScript - Sử dụng jQuery đã load từ parent -->
<script>
// Đợi jQuery sẵn sàng
(function checkjQuery() {
    if (typeof jQuery === 'undefined') {
        setTimeout(checkjQuery, 100);
        return;
    }
    var $ = jQuery;
    $(document).ready(function() {
    // ===== AJAX LOAD ĐỊA CHỈ =====
    // Sử dụng event 'changed.bs.select' cho bootstrap-select hoặc 'change' cho select thường

    // Tỉnh gửi -> Quận gửi
    $("#lvl1_vl").on("changed.bs.select change", function() {
        var code = $(this).val();
        console.log("lvl1_vl changed:", code);
        if (!code) return;
        $.post("../control/c_quanhuyenxaphuong.php", {lvl1_id: code}, function(data) {
            console.log("lvl2 data:", data);
            var opts = '<option value="">Chọn quận/huyện</option>';
            if (data) {
                for (var i = 0; i < data.length; i++) {
                    opts += '<option value="' + data[i].code + '">' + data[i].full_name + '</option>';
                }
            }
            $("#lvl2_vl").html(opts);
            $("#lvl3_vl").html('<option value="">Chọn phường/xã</option>');
            // Refresh bootstrap-select nếu có
            if ($.fn.selectpicker) {
                $("#lvl2_vl, #lvl3_vl").selectpicker('refresh');
            }
        }, "json").fail(function(xhr, status, error) {
            console.error("AJAX error:", status, error);
        });
    });

    // Quận gửi -> Xã gửi
    $("#lvl2_vl").on("changed.bs.select change", function() {
        var code = $(this).val();
        console.log("lvl2_vl changed:", code);
        if (!code) return;
        $.post("../control/c_quanhuyenxaphuong.php", {lvl2_id: code}, function(data) {
            console.log("lvl3 data:", data);
            var opts = '<option value="">Chọn phường/xã</option>';
            if (data) {
                for (var i = 0; i < data.length; i++) {
                    opts += '<option value="' + data[i].code + '">' + data[i].full_name + '</option>';
                }
            }
            $("#lvl3_vl").html(opts);
            if ($.fn.selectpicker) {
                $("#lvl3_vl").selectpicker('refresh');
            }
        }, "json").fail(function(xhr, status, error) {
            console.error("AJAX error:", status, error);
        });
    });

    // Tỉnh nhận -> Quận nhận
    $("#lvl1_1_vl").on("changed.bs.select change", function() {
        var code = $(this).val();
        console.log("lvl1_1_vl changed:", code);
        if (!code) return;
        $.post("../control/c_quanhuyenxaphuong.php", {lvl1_1_id: code}, function(data) {
            console.log("lvl2_1 data:", data);
            var opts = '<option value="">Chọn quận/huyện</option>';
            if (data) {
                for (var i = 0; i < data.length; i++) {
                    opts += '<option value="' + data[i].code + '">' + data[i].full_name + '</option>';
                }
            }
            $("#lvl2_1_vl").html(opts);
            $("#lvl3_1_vl").html('<option value="">Chọn phường/xã</option>');
            if ($.fn.selectpicker) {
                $("#lvl2_1_vl, #lvl3_1_vl").selectpicker('refresh');
            }
        }, "json").fail(function(xhr, status, error) {
            console.error("AJAX error:", status, error);
        });
    });

    // Quận nhận -> Xã nhận
    $("#lvl2_1_vl").on("changed.bs.select change", function() {
        var code = $(this).val();
        console.log("lvl2_1_vl changed:", code);
        if (!code) return;
        $.post("../control/c_quanhuyenxaphuong.php", {lvl2_1_id: code}, function(data) {
            console.log("lvl3_1 data:", data);
            var opts = '<option value="">Chọn phường/xã</option>';
            if (data) {
                for (var i = 0; i < data.length; i++) {
                    opts += '<option value="' + data[i].code + '">' + data[i].full_name + '</option>';
                }
            }
            $("#lvl3_1_vl").html(opts);
            if ($.fn.selectpicker) {
                $("#lvl3_1_vl").selectpicker('refresh');
            }
        }, "json").fail(function(xhr, status, error) {
            console.error("AJAX error:", status, error);
        });
    });

    // ===== TÍNH PHÍ VẬN CHUYỂN =====
    function calculateCost() {
        var kl = parseFloat($("#khoiluong_vl").val()) || 0;
        var ship = $("#shipping_method_vl").val();
        var tinh1 = $("#lvl1_vl").val();
        var tinh2 = $("#lvl1_1_vl").val();

        if (!kl || !ship || !tinh1 || !tinh2) {
            $("#shipping-cost-display-vl").html('');
            return;
        }

        var cost = 5000; // Cơ bản
        if (kl > 0.5) cost += Math.ceil((kl - 0.5) / 0.5) * 2500;
        if (tinh1 !== tinh2) cost += 30000;
        if (ship === "GHN") cost += 12000;
        else if (ship === "GHTK") cost += 4000;
        if ($("#phithuho_vl").is(":checked")) {
            cost += 5000;
            $("#total-cost-phithuho-vl").val(cost);
        } else {
            $("#total-cost-phithuho-vl").val('');
        }

        $("#shipping-cost-hidden-vl").val(cost);
        $("#shipping-cost-display-vl").html('Tổng phí: <strong>' + cost.toLocaleString('vi-VN') + ' VNĐ</strong>');
    }

    $("#khoiluong_vl, #shipping_method_vl, #lvl1_vl, #lvl1_1_vl, #phithuho_vl").on("change input", calculateCost);
    }); // close $(document).ready
})(); // close checkjQuery
</script>
