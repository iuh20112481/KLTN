<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer">
        <!-- Thông báo sẽ được thêm vào đây -->
    </div>
    <table class="giaohang mt-3">
        <thead>
            <tr>
                <th class="th-style2">STT</th>
                <th class="th-style2">Mã đơn hàng</th>
                <th class="th-style2">Tên đơn hàng</th>
                <th class="th-style2">Địa chỉ nhận</th>
                <th class="th-style2">Mã vận đơn</th>
                <th class="th-style2">SĐT người gửi</th>
                <th class="th-style2">SĐT người nhận</th>
                <th class="th-style2">Ngày giao hàng</th>
                <th class="th-style2">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $donHang = $p->getALLDonHangofNVGH($maNhanVien);
            if ($donHang && mysqli_num_rows($donHang)> 0) {
                $i = 1;
                while ($dh = mysqli_fetch_assoc($donHang)) {
                    echo "<tr>";
                    echo "<td class='text-center'>{$i}</td>";
                    echo "<td class='text-center'>{$dh['Id_DonHang']}</td>";
                    echo "<td>{$dh['tenDonHang']}</td>";
                    echo "<td>{$dh['diaChiNhanGop']}</td>";
                    echo "<td class='text-center'>{$dh['maVanDon']}</td>";
                    echo "<td class='text-center'>{$dh['sdtNG']}</td>";
                    echo "<td class='text-center'>{$dh['sdtNN']}</td>";
                    echo "<td class='text-center'>" . date('d/m/Y') . "</td>";
                    echo "<td class='action-buttons'>";
                    echo "<button class='btn btn-accept update-status' data-id='{$dh['Id_DonHang']}' data-status='Đã giao'>Đã giao</button>";
                    echo "<button class='btn btn-shipping update-status' data-id='{$dh['Id_DonHang']}' data-status='Đang giao'>Đang giao</button>";
                    echo "<button class='btn btn-cancel update-status' data-id='{$dh['Id_DonHang']}' data-status='Đã hủy'>Đã hủy</button>";
                    echo "</td>";
                    echo "</tr>";
                    $i++;
                }
            } else {
                echo "<tr><td class='text-center' colspan='9'>Chưa có đơn hàng nào hôm nay !</td></tr>";
            }
            ?>
        </tbody>
    </table>
    
    <!-- SCRIPT THỰC HIỆN TRẠNG THÁI  -->
    <script>
        $(document).ready(function() {
            $(".update-status").click(function() {
                var idDonHang = $(this).data("id");
                var trangThaiDonHang = $(this).data("status");
                var maNhanVien = "<?php echo $maNhanVien; ?>";
                var ngayHTGiaoHang = "<?php echo date('d-m-Y'); ?>";

                if (idDonHang) {
                    $.ajax({
                        url: "../control/cdonhang.php",
                        method: "POST",
                        data: {
                            action: "updateDonHangofNVGH",
                            idDonHang: idDonHang,
                            trangThaiDonHang: trangThaiDonHang,
                            maNhanVien: maNhanVien,
                            ngayHTGiaoHang: ngayHTGiaoHang
                        },
                        success: function(response) {
                            try {
                                var data = JSON.parse(response);
                                if (data.success) {
                                    showToast("Cập nhật trạng thái thành công.");
                                    setTimeout(function() {
                                        location.reload();
                                    }, 2000);
                                } else {
                                    showToast("Cập nhật trạng thái thất bại: " + data.message);
                                }
                            } catch (error) {
                                showToast("Phản hồi không hợp lệ từ máy chủ.");
                                console.error('Error parsing JSON:', error, response);
                            }
                        },
                        error: function() {
                            showToast("Có lỗi khi thực hiện yêu cầu. Hãy thử lại.");
                        }
                    });
                } else {
                    showToast("Không tìm thấy ID đơn hàng.");
                }
            });

            function showToast(message) {
                var toastContainer = document.getElementById("toastContainer");
                if (!toastContainer) {
                    toastContainer = document.createElement("div");
                    toastContainer.id = "toastContainer";
                    toastContainer.style.position = "fixed";
                    toastContainer.style.top = "10px";
                    toastContainer.style.right = "10px";
                    toastContainer.style.zIndex = "9999";
                    document.body.appendChild(toastContainer);
                }

                var toastElement = document.createElement("div");
                toastElement.className = "toast show";
                toastElement.setAttribute("role", "alert");
                toastElement.setAttribute("aria-live", "assertive");
                toastElement.setAttribute("aria-atomic", "true");

                toastElement.style.maxWidth = "230px";
                toastElement.style.backgroundColor = "#ffe5f4";
                toastElement.style.color = "#000000";
                toastElement.style.borderRadius = "7px";

                toastElement.innerHTML = `
                    <div class="toast-header" style="background-color: #ff6200; color: white;">
                        <strong class="me-auto">Thông báo</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">${message}</div>
                `;
                toastContainer.appendChild(toastElement);
                setTimeout(function() {
                    toastElement.classList.remove("show");
                    setTimeout(function() {
                        toastContainer.removeChild(toastElement);
                    }, 150);
                }, 5000);
            }
        });
    </script>
</body>
</html>
