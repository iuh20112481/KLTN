<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách đơn hàng</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../css/style.css?be">
</head>
<body>
<h1 class="mt-4 text-center" id="h2-content">Danh sách đơn hàng</h1>

    <!-- SORT -->
    <div class="container-fluid mt-3">
        <div class="row d-flex mb-2">
            <div class="col-12 d-flex justify-content-end">
                <!-- THANH TÌM KIẾM -->
                <div class="d-flex mr-3">
                    <span class="" id="p1-content">Tìm kiếm:</span>
                    <input type="text" class="form-control" id="search" placeholder="Nhập Mã Vận Đơn...">
                </div>
                
                <!-- LỌC THEO NGÀY -->
                <div class="d-flex mr-3">
                    <span class="" id="p1-content">Ngày đã giao:</span>
                    <input type="date" id="date" class="form-control ml-2">
                    <!-- Thẻ input để hiển thị giá trị ngày tháng -->
                    <input type="hidden" id="displayDate" class="form-control" readonly>
                </div>

                <!-- LỌC THEO TRẠNG THÁI ĐƠN HÀNG -->
                <div class="d-flex mr-3">
                    <span class="" id="p1-content">Trạng thái:</span>
                    <select id="select" class="form-select ml-2" aria-label="Default select example">
                        <option value="0" selected>Tất cả</option>
                        <option value="Đã Giao">Đã Giao</option>
                        <option value="Đang Giao">Đang Giao</option>
                        <option value="Đã hủy">Đã hủy</option>
                        <option value="Đang chờ phân đơn">Đang chờ phân đơn</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <!-- TABLE -->
    <div class="">
        <table class="table-responsive mt-3 nhandonhang">
            <thead>
                <tr>
                    <th class="th-style">Mã ĐH</th>
                    <th class="th-style">Mã Vận Đơn</th>
                    <th class="th-style">Tên Đơn Hàng</th>
                    <th class="th-style">Tên Người Nhận</th>
                    <th class="th-style">SĐT Người Nhận</th>
                    <th class="th-style">Tên Người Gửi</th>
                    <th class="th-style">SĐT Người Gửi</th>
                    <th class="th-style">Địa Chỉ Nhận</th>
                    <th class="th-style">Ngày Đã Giao </th>
                    <th class="th-style">Ngày Phân Hàng</th>
                    <th class="th-style">Trạng Thái ĐH</th>
                </tr>
            </thead>
            <tbody id="tablest">
                <!-- Các dòng sẽ được thêm vào đây từ JavaScript -->
            </tbody>
        </table>
    </div>

    <script>
        // Biến global chứa mã nhân viên
        var maNhanVien = <?php echo json_encode($maNhanVien); ?>;

        // Hàm để fetch dữ liệu từ API và hiển thị lên HTML
        function fetchData(trangThai, ngayPhanHangGiao, maVanDon) {
            if (maNhanVien !== '') {
                let url = "http://localhost:8080/WEBSITE_EXHIBITION/API/API_xemlaidongiao.php?maNhanVien=" + encodeURIComponent(maNhanVien);
                
                // Thêm các điều kiện tìm kiếm nếu có
                if (maVanDon !== null && maVanDon !== "") {
                    url += "&maVanDon=" + encodeURIComponent(maVanDon);
                } else {
                    if (trangThai !== null && trangThai !== "0") {
                        url += "&trangThai=" + encodeURIComponent(trangThai);
                    }
                    if (ngayPhanHangGiao !== null && ngayPhanHangGiao !== "") {
                        url += "&ngayPhanHangGiao=" + encodeURIComponent(ngayPhanHangGiao);
                    }
                }
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        let html = '';
                        if (data.length > 0) {
                            data.forEach(donHang => {
                                html += `
                                    <tr>
                                        <td>${donHang.Id_DonHang}</td>
                                        <td>${donHang.maVanDon}</td>
                                        <td>${donHang.tenDonHang}</td>
                                        <td>${donHang.tenNN}</td>
                                        <td>${donHang.sdtNN}</td>
                                        <td>${donHang.tenNG}</td>
                                        <td>${donHang.sdtNG}</td>
                                        <td>${donHang.diaChiNhanGop}</td>
                                        <td>${donHang.ngayHTGiaoHang}</td>
                                        <td>${donHang.ngayPhanHangGiao}</td>
                                        <td>${donHang.trangThaiDonHang}</td>
                                    </tr>
                                `;
                            });
                        } else {
                            html = `
                                <tr>
                                    <td colspan="11" class="text-center">Không có dữ liệu</td>
                                </tr>
                            `;
                        }
                        document.getElementById('tablest').innerHTML = html;
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        // Gọi hàm fetchData khi trang web được load
        window.onload = function() {
            fetchData(null, null, null);
        };

        // Chuyển đổi chuỗi ngày từ YYYY-mm-dd sang dd-mm-YYYY
        function convertDateToDDMMYYYY(dateString) {
            const date = new Date(dateString);
            const day = ("0" + date.getDate()).slice(-2);
            const month = ("0" + (date.getMonth() + 1)).slice(-2);
            const year = date.getFullYear();
            if (isNaN(day) || isNaN(month) || isNaN(year)) {
                return '';
            }
            return `${day}-${month}-${year}`;

        }

// Sự kiện khi người dùng thay đổi giá trị của input date
document.getElementById('date').addEventListener('change', function() {
    var ngayHTGiaoHang = convertDateToDDMMYYYY(this.value);
    if (ngayHTGiaoHang !== document.getElementById('displayDate').value) {
        document.getElementById('displayDate').value = ngayHTGiaoHang;
        var trangThai = document.getElementById('select').value;
        var maVanDon = document.getElementById('search').value;
        fetchData(trangThai, ngayHTGiaoHang, maVanDon);
    }
});

// Sự kiện khi người dùng thay đổi giá trị của select trạng thái
document.getElementById('select').addEventListener('change', function() {
    var trangThai = this.value;
    var ngayHTGiaoHang = document.getElementById('displayDate').value;
    var maVanDon = document.getElementById('search').value;
    fetchData(trangThai, ngayHTGiaoHang, maVanDon);
});

// Sự kiện khi người dùng thay đổi giá trị của input search
document.getElementById('search').addEventListener('input', function() {
    var maVanDon = this.value;
    var trangThai = document.getElementById('select').value;
    var ngayHTGiaoHang = document.getElementById('displayDate').value;
    fetchData(trangThai, ngayHTGiaoHang, maVanDon);
});


    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
