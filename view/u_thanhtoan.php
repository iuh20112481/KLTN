<?php
    // Bắt đầu phiên session
    // Kiểm tra xem người dùng đã đăng nhập chưa, nếu chưa thì chuyển hướng đến trang đăng nhập
    if (!isset($_SESSION['user']) || !isset($_SESSION['nguoidung']['id_user'])) {
        header("Location: dangNhap.php");
        exit();
    }

    // Lấy giá trị của Id_TaiKhoan từ session
    $Id_TaiKhoan = $_SESSION['nguoidung']['id_user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        div#paymentModal.modal.fade.show{
            transition: opacity .15s linear;
            background: #0000007d;
        }
    </style>
    <title>Document</title>
</head>
<body>
    <div class="container-fluid mt-5">
        <div class="row">
            <div class="col-12 mt-4">
                <h3 class="" id="h2-content">Thanh Toán Phí Vận Chuyển</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="nhandonhang">
                    <thead>
                        <tr>
                            <th class="th-style">STT</th>
                            <th class="th-style">Tên sản phẩm</th>
                            <th class="th-style">Mã đơn hàng</th>
                            <th class="th-style">Mã vận đơn</th>
                            <th class="th-style">Người gửi</th>
                            <th class="th-style">Số Điện Thoại Người Gửi</th>
                            <th class="th-style">Địa chỉ thanh toán</th>
                            <th class="th-style">Ngày lập đơn</th>
                            <th class="th-style">Phí vận chuyển</th>
                            <th class="th-style">HTVC</th>
                            <th class="th-style">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        <!-- AUTO FILL  -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Modal lớn bao gồm form thanh toán kèm mã QR -->
    <div class="modal fade p-0" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl p-0">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel"><span id="h2-content">Thanh Toán Phí Vận Chuyển</span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body-1">
                    <form id="payment-form" class="row g-3" style="padding: 25px;">
                        <div class="col-md-6">
                            <label for="recipient-name" class="form-label" id="p1-content">Họ Tên:</label>
                            <input type="text" class="form-control" id="recipient-name" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="address" class="form-label" id="p1-content">Địa Chỉ:</label>
                            <input type="text" class="form-control" id="address" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="sdt" class="form-label" id="p1-content">Số Điện Thoại:</label>
                            <input type="text" class="form-control" id="sdt" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="stk" class="form-label" id="p1-content">Số Tài Khoản:</label>
                            <input type="text" class="form-control" id="stk" >
                        </div>
                        <div class="col-md-6">
                            <label for="NH" class="form-label" id="p1-content">Ngân Hàng:</label>
                            <input type="text" class="form-control" id="NH" >
                        </div>
                        <div class="col-md-6">
                            <label for="tenDH" class="form-label" id="p1-content">Tên Đơn Hàng:</label>
                            <input type="text" class="form-control" id="tenDH" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="maVanDon" class="form-label" id="p1-content">Mã Vận Đơn:</label>
                            <input type="text" class="form-control" id="maVanDon" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="maDH" class="form-label" id="p1-content">Mã Đơn Hàng:</label>
                            <input type="text" class="form-control" id="maDH" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="ngayGD" class="form-label" id="p1-content">Ngày giao dich:</label>
                            <input type="text" class="form-control" id="ngaygd" readonly value="<?php
                                                                                                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                                                                                                    echo date('Y-m-d');
                                                                                                ?>">                        
                        </div>
                        <div class="col-md-6">
                            <label for="tgGD" class="form-label" id="p1-content">Thời gian giao dịch:</label>
                            <input type="time" class="form-control" id="tggd" readonly value="<?php
                                                                                                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                                                                                                    echo date('H:i');
                                                                                                ?>">                        
                        </div>
                        <hr class="mt-2">
                        <div class="col-md-12 text-end mb-2">
                            <label for="content" class="form-label d-flex" id="p1-content">Nội Dung Ghi Chú:</label>
                            <textarea class="form-control" id="content" rows="2"></textarea>
                        <br>
                            <label for="amount" class="form-label" id="p1-content">Số tiền:</label>
                            <input type="text" class="col-2 p-2" id="amount" readonly disabled>
                            <label for="amount" class="form-label" id="p1-content">VNĐ</label>
                        </div>
                        <hr class="mt-2">

                        <div class="col-md-12 text-center">
                            <label for="qr-code" class="form-label" id="p1-content">Mã QR:</label>
                            <div id="qr-code" class="d-flex justify-content-center"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <!-- Nút "Xác nhận" -->
                    <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal" id="confirm-payment-btn">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>

<script>
    // Hàm để gọi API và lấy dữ liệu
    function getDoanhThuFromAPI(Id_TaiKhoan) {
        fetch('http://localhost:8080/WEBSITE_EXHIBITION/API/API_xemDanhSachThanhToan.php?Id_TaiKhoan=' + Id_TaiKhoan)
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    console.error(data.message);
                } else {
                    displayData(data);
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
            });
    }

    // Hàm để tách số điện thoại
    function formatPhoneNumber(phoneNumber) {
        return phoneNumber.replace(/(\d{4})(\d{3})(\d{3})/, '$1 $2 $3');
    }

    // Hàm để hiển thị dữ liệu lên bảng
    function displayData(data) {
        const tableBody = document.getElementById('table-body');
        

        data.forEach((item, index) => {
            const row = document.createElement('tr');

            row.innerHTML = `
                <td class="text-center">${index + 1}</td>
                <td>${item.tenDonHang}</td>
                <td class="text-center">${item.maDonHang}</td>
                <td>${item.maVanDon}</td>
                <td>${item.tenNG}</td>
                <td class="text-center">${formatPhoneNumber(item.sdtNG)}</td>
                <td>${item.diaChi}</td>
                <td class="text-center">${item.ngayLapDon}</td>
                <td class="text-center">${item.giaVanChuyen}</td>
                <td class="text-center">${item.hinhThucVanChuyen}</td>
                <td>
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#paymentModal" data-item='${JSON.stringify(item)}' style="font-size:small;">Thanh toán</button>
                </td>
            `;

            tableBody.appendChild(row);
        });
    }

// Xử lý sự kiện khi mở modal và hiển thị QR code
document.getElementById('paymentModal').addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const item = JSON.parse(button.getAttribute('data-item'));

    // Hiển thị thông tin đơn hàng
    document.getElementById('recipient-name').value = item.tenND;
    document.getElementById('address').value = item.diaChi;
    document.getElementById('amount').value = item.giaVanChuyen;
    document.getElementById('maDH').value = item.maDonHang;
    document.getElementById('sdt').value = formatPhoneNumber(item.sdtNG);
    document.getElementById('stk').value = item.soTK;
    document.getElementById('NH').value = item.maNH;
    document.getElementById('tenDH').value = item.tenDonHang;
    document.getElementById('maVanDon').value = item.maVanDon;

    // Tạo và hiển thị QR code
    const qrCodeUrl = `https://qr.sepay.vn/img?acc=${item.soTK}&bank=${item.maNH}&amount=${item.giaVanChuyen}&des=Thanh toan don hang ${item.maDonHang}`;
    const qrCodeElement = document.getElementById('qr-code');
    qrCodeElement.innerHTML = `<img src="${qrCodeUrl}" alt="QR Code" />`;
});

// / Xử lý sự kiện khi nhấn nút "Xác nhận thanh toán"
document.getElementById('confirm-payment-btn').addEventListener('click', function () {
    // Lấy thông tin từ các trường trong modal
    const hoTen = document.getElementById('recipient-name').value;
    const diaChi = document.getElementById('address').value;
    const soDienThoai = document.getElementById('sdt').value;
    const soTaiKhoan = document.getElementById('stk').value;
    const nganHang = document.getElementById('NH').value;
    const tenDonHang = document.getElementById('tenDH').value;
    const maVanDon = document.getElementById('maVanDon').value;
    const maDonHang = document.getElementById('maDH').value;
    const ngayGiaoDich = document.getElementById('ngaygd').value;
    const thoiGianGiaoDich = document.getElementById('tggd').value;
    const noiDungGhiChu = document.getElementById('content').value;
    const soTien = document.getElementById('amount').value;

    // Tạo FormData chứa thông tin đơn hàng
    const formData = new FormData();
    formData.append('ho_ten', hoTen);
    formData.append('dia_chi', diaChi);
    formData.append('so_dien_thoai', soDienThoai);
    formData.append('so_tai_khoan', soTaiKhoan);
    formData.append('ngan_hang', nganHang);
    formData.append('ten_don_hang', tenDonHang);
    formData.append('ma_van_don', maVanDon);
    formData.append('ma_don_hang', maDonHang);
    formData.append('ngay_giao_dich', ngayGiaoDich);
    formData.append('thoi_gian_giao_dich', thoiGianGiaoDich);
    formData.append('noi_dung_ghi_chu', noiDungGhiChu);
    formData.append('so_tien', soTien);
    formData.append('Id_TaiKhoan', <?php echo json_encode($Id_TaiKhoan); ?>);

    // Gửi FormData đến API để lưu vào cơ sở dữ liệu
    fetch('../control/c_u_giaodich.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        // Thực hiện các thao tác khác sau khi lưu thành công, nếu cần
    })
    .catch(error => {
        console.error('Lỗi:', error);
    });
});
    window.onload = function() {
        const idTaiKhoan = <?php echo json_encode($Id_TaiKhoan); ?>;
        getDoanhThuFromAPI(idTaiKhoan);
    };
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gyb77GZJ3eURRMOtbxNk6yY8Pn5HbujA4l1F2nGlo5wJWLGpRo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEaH6eEEhvy/TZ0e2eauFpjzEx4x8m" crossorigin="anonymous"></script>

</body>
</html> 
