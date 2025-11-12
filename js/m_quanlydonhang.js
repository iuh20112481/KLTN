function fetchData(trangThai, ngayLapDon, maVanDon) {
    if (maBuuCuc !== '') {
        let url = "http://localhost:8080/WEBSITE_EXHIBITION/API/testAPIxemDonHangforBC.php?maBuuCuc=" + encodeURIComponent(maBuuCuc);
        
        if (maVanDon !== null && maVanDon !== "") {
            url += "&maVanDon=" + encodeURIComponent(maVanDon);
        } else {
            if (trangThai !== null && trangThai !== "0") {
                url += "&trangThai=" + encodeURIComponent(trangThai);
            }
            if (ngayLapDon !== null && ngayLapDon !== "") {
                url += "&ngayLapDon=" + encodeURIComponent(ngayLapDon);
            }
        }
        
        fetch(url)
            .then(response => response.json())
            .then(data => {
                let html = '';
                if (data.length > 0) {
                    data.forEach(item => {
                        html += '<tr style="font-size: small;">';
                        html += '<td>' + item.maBuuCuc + '</td>';
                        html += '<td class="text-center">' + item.Id_TaoDonHang + '</td>';
                        html += '<td class="text-center">' + item.Id_TaiKhoan + '</td>';
                        html += '<td>' + item.tenNG + '</td>';
                        html += '<td>' + item.tenNN + '</td>';
                        html += '<td>' + item.tenDonHang + '</td>';
                        html += '<td>' + item.maVanDon + '</td>';
                        html += '<td class="text-center">' + item.ngayLapDon + '</td>';
                        html += '<td>' + item.diaChiNhanGop + '</td>';
                        html += '<td class="text-center">' + getBadge(item.trangThaiDonHang) + '</td>';
                        html += '</tr>';
                    });
                } else {
                    html = '<tr><td colspan="10" class="text-center">Không có đơn hàng nào</td></tr>';
                }
                document.getElementById("apiTableBody").innerHTML = html;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                document.getElementById("apiTableBody").innerHTML = '<tr><td colspan="10" class="text-center">Lỗi khi tải dữ liệu</td></tr>';
            });
    }
}

function getBadge(trangThaiDonHang) {
    switch (trangThaiDonHang) {
        case 'Đã giao':
            return "<span class='badge badge-fixed-width rounded-pill text-bg-success'>Đã giao</span>";
        case 'Đang giao':
            return "<span class='badge badge-fixed-width rounded-pill text-bg-primary'>Đang giao</span>";
        case 'Hoàn trả':
            return "<span class='badge badge-fixed-width rounded-pill text-bg-danger'>Hoàn trả</span>";
        default:
            return "<span class='badge badge-fixed-width rounded-pill text-bg-warning'>Chưa duyệt đơn</span>";
    }
}

document.getElementById('select').addEventListener('change', function() {
    var trangThai = this.value;
    var ngayLapDon = document.getElementById('date').value;
    var maVanDon = document.getElementById('search').value;
    document.getElementById('displayDate').value = ngayLapDon; // Hiển thị giá trị ngày tháng
    fetchData(trangThai, ngayLapDon, maVanDon);
});

document.getElementById('date').addEventListener('change', function() {
    var ngayLapDon = this.value;
    document.getElementById('displayDate').value = ngayLapDon; // Hiển thị giá trị ngày tháng
    var trangThai = document.getElementById('select').value;
    var maVanDon = document.getElementById('search').value;
    fetchData(trangThai, ngayLapDon, maVanDon);
});

document.getElementById('search').addEventListener('input', function() {
    var maVanDon = this.value;
    fetchData(null, null, maVanDon);
});

// Load data with default state when page loads
fetchData(null, null, null);
