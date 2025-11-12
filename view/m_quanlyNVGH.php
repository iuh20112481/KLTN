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

    // Retrieve post office information from the session
    $buuCucInfo = $_SESSION['buu_cuc_info'] ?? [];
    $maBuuCuc = $buuCucInfo['maBuuCuc'] ?? null;

    // Create an instance of the staff account controller
    $p = new controller_tk();

    // Fetch a list of delivery staff for the current post office
    $dsNVGH = $p->getDSNVGH($maBuuCuc);

    // Display the post office code heading
    if ($maBuuCuc) {
        echo "<br>";
        echo "<h2 id='h2-content' class='text-center'>QUẢN LÝ NHÂN SỰ BƯU CỤC : {$maBuuCuc}</h2>";
    } else {
        echo "<h1>Không có danh sách</h1>";
    }

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
?>

    <div class="container-fluid">
        <table class='nhandonhang' id="">
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

            <tbody>
                <?php
                if (count($dsNVGH) > 0) {
                    foreach ($dsNVGH as $nvgh) {
                        echo "<tr class='nv-row' data-toggle='modal' data-target='#nvModal' 
                            data-id='{$nvgh['Id_TaiKhoan']}' 
                            data-name='{$nvgh['tenND']}' 
                            data-phone='{$nvgh['sdtND']}'
                            data-role='{$nvgh['loaiNguoiDung']}'
                            data-email='{$nvgh['emailND']}'
                            data-staff-code='{$nvgh['maNhanVien']}'
                            data-postal-code='{$nvgh['maBuuCuc']}'

                            >";
                            echo "<td class='text-center'>{$nvgh['Id_TaiKhoan']}</td>";
                            echo "<td>{$nvgh['tenND']}</td>";
                            echo "<td class='text-center'>{$nvgh['sdtND']}</td>";
                            echo "<td>{$nvgh['loaiNguoiDung']}</td>";
                            echo "<td>{$nvgh['emailND']}</td>";
                            echo "<td class='text-center'>{$nvgh['maNhanVien']}</td>";
                            echo "<td class='text-center'>{$nvgh['maBuuCuc']}</td>";
                            echo "<td class='text-center'><button class='btn btn-accept delete-btn ' data-id='" . $nvgh['Id_TaiKhoan'] . "'>Xóa Nhân viên</button></td>";
                            echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Không có dữ liệu</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Modal chi tiết nhân viên -->
        <div class="modal fade" id="nvModal" tabindex="-1" role="dialog" aria-labelledby="nvModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="nvModalLabel">Thông tin nhân viên</h5>

                    </div>
                    <div class="modal-body">
                        <p><strong>ID Tài khoản:</strong> <span class="thongtin" id="nvId"></span></p>
                        <p><strong>Họ và tên:</strong> <span class="thongtin" id="nvName"></span></p>
                        <p><strong>Số điện thoại:</strong> <span class="thongtin" id="nvPhone"></span></p>
                        <p><strong>Chức vụ:</strong> <span class="thongtin" id="nvRole"></span></p>
                        <p><strong>Email:</strong> <span class="thongtin" id="nvEmail"></span></p>
                        <p><strong>Mã nhân viên:</strong> <span class="thongtin" id="nvStaffCode"></span></p>
                        <p><strong>Mã bưu cục:</strong> <span class="thongtin" id="nvPostalCode"></span></p>
                        <p><strong>Số lượng đơn hàng:</strong> <span class="thongtin" id="tongDonHang"></span></p> <!-- Hiển thị số lượng đơn hàng -->
                        <p><strong>Số lượng đơn đã giao:</strong> <span class="thongtin" id="tongdondagiao"></span></p> <!-- Hiển thị số lượng đơn đã giao -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bảng danh sách -->
    <!-- Liên kết Bootstrap JS và jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

    <!-- Script để hiển thị chi tiết trong modal -->
    <script>
        $(document).ready(function() {
            $(".nv-row").click(function() {
                // Lấy thông tin từ thuộc tính data của dòng được chọn
                var id = $(this).data("id");
                var name = $(this).data("name");
                var phone = $(this).data("phone");
                var role = $(this).data("role");
                var email = $(this).data("email");
                var staffCode = $(this).data("staff-code");
                var postalCode = $(this).data("postal-code");

                // Gán thông tin vào các phần tử modal
                $("#nvId").text(id);
                $("#nvName").text(name);
                $("#nvPhone").text(phone);
                $("#nvRole").text(role);
                $("#nvEmail").text(email);
                $("#nvStaffCode").text(staffCode);
                $("#nvPostalCode").text(postalCode);

                // Gửi yêu cầu để nhận thông tin về số lượng đơn hàng
                $.ajax({
                    url: '../control/ctaikhoan.php', // Đường dẫn đến tệp PHP xử lý yêu cầu
                    type: 'POST',
                    data: { maNhanVien: staffCode }, // Gửi mã nhân viên
                    success: function(response) {
                        var data = JSON.parse(response); 
                        if (data.tongdonhang !== undefined && data.tongdondagiao !== undefined) { // Kiểm tra mảng kết quả
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
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".delete-btn").click(function() {
                var idTaiKhoan = $(this).data("id");

                if (confirm("Bạn có chắc chắn muốn xóa nhân viên này?")) {
                    // Gọi hàm xóa thông qua Ajax
                    $.ajax({
                        url: 'm_giaodiennguoidung.php?page=adsnvgh&q=delete&id=' + idTaiKhoan,
                        type: 'GET',
                        success: function(response) {
                            location.reload();
                            
                        },
                        error: function() {
                            alert('Lỗi xóa nhân viên giao hàng!');
                        }
                    });
                }
            });
        });
    </script>

</body>
</html>
