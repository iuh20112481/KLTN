    <?php
        if (!isset($_SESSION['user']) || !isset($_SESSION["nvbc"]['id_user'])) {
            header("Location: dangNhapNhanSu.php");
            exit();
        }

        $buuCucInfo = $_SESSION['buu_cuc_info'] ?? [];
        if (isset($buuCucInfo["Id_PhanLoaiNguoiDung"])) {
            $_SESSION["nvbc"]["Id_PhanLoaiNguoiDung"] = $buuCucInfo["Id_PhanLoaiNguoiDung"];
        }

        include_once ("../control/cdonhang.php");
        $p = new control_donhang();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if (isset($_GET['q'], $_GET['id'])) {
                $action = $_GET['q'];
                $idTaoDonHang = $_GET['id'];
                if ($action === 'chapnhan' && $idTaoDonHang) {
                    // Kiểm tra xem đơn hàng đã được chấp nhận chưa
                    if (!$p->checkIfAccepted($idTaoDonHang)) {
                        $trangThaiDonHang = 'Đang chờ phân đơn';
                        $p->insertDonHang($_SESSION["nvbc"]["Id_PhanLoaiNguoiDung"], $idTaoDonHang, $buuCucInfo['maBuuCuc'], $trangThaiDonHang);
                    }
                } elseif ($action === 'huy' && $idTaoDonHang) {
                    // Hủy đơn hàng
                    $trangthaidonhuy = 'Hủy đơn';
                    $p->rejectDonHang($_SESSION["nvbc"]["Id_PhanLoaiNguoiDung"], $idTaoDonHang, $buuCucInfo['maBuuCuc'], $trangthaidonhuy);
                }
            }
        }

        // Chỉ gọi hàm getAllDonHangforNVBC() khi có giá trị cho $tenbuucuc
        $tenbuucuc = $_SESSION['buu_cuc_info']['diaChiBC'] ?? null;
        if ($tenbuucuc !== null) {
            $donHang = $p->getAllDonHangforNVBC($tenbuucuc);
        } else {
            $donHang = null; // Hoặc giá trị mặc định khác phù hợp
        }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Danh sách đơn hàng</title>
    <link rel="stylesheet" href="../css/style.css?v2323">
    <script> var userId = <?php echo $_SESSION["nvbc"]["id_user"]; ?>;</script>
</head>
<body>
    <h2 id="h2-content" class="text-center mt-2 p-1">Nhận Đơn Hàng</h2>
    <input type="hidden" class="tenbuucuc" id="tenbuucuc" value="<?php echo $_SESSION['buu_cuc_info']['diaChiBC']; ?>">
<div class="container-fluid">
    <table class="nhandonhang">
        <thead>
            <tr>
                <th class='th-style0'>STT</th>
                <th class='th-style0'>ID đơn hàng</th>
                <th class='th-style0'>Mã đơn hàng</th>
                <th class='th-style0'>Tên đơn hàng</th>
                <th class='th-style0'>Tên người gửi</th>
                <th class='th-style0'>Tên người nhận</th>
                <th class='th-style0'>Địa chỉ nhận</th>
                <th class='th-style0'>Ngày lập đơn</th>
                <th class='th-style0'>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            if ($donHang && mysqli_num_rows($donHang) > 0) {
                while ($dh = mysqli_fetch_assoc($donHang)) {
                    echo "<tr>";
                    echo "<td style='text-align: center;'>" . $i . "</td>";
                    echo "<td style='text-align: center;'>" . $dh['Id_TaoDonHang'] . "</td>";
                    echo "<td>" . $dh['maDonHang'] . "</td>";
                    echo "<td>" . $dh['tenDonHang'] . "</td>";
                    echo "<td>" . $dh['tenNG'] . "</td>";
                    echo "<td>" . $dh['tenNN'] . "</td>";
                    echo "<td>" . $dh['diaChiNhanGop'] . "</td>";
                    echo "<td style='text-align: center;'>" . $dh['ngayLapDon'] . "</td>";

                    echo "<td class='action-buttons'>";
                    echo "<button class='btn btn-accept' data-id='" . $dh['Id_TaoDonHang'] . "' onclick=\"window.location.href='m_giaodiennguoidung.php?q=chapnhan&id=" . $dh['Id_TaoDonHang'] . "'\">Chấp nhận</button>";
                    echo "<button class='btn btn-cancel' onclick=\"window.location.href='m_giaodiennguoidung.php?q=huy&id=" . $dh['Id_TaoDonHang'] . "'\">Hủy đơn</button>";
                    echo "</td>";

                    echo "</tr>";
                    $i++;
                }
            } else {
                echo "<tr><td colspan='8' style='text-align: center;'>Chưa có đơn hàng nào!</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<!-- SCRIPTS THÔNG BÁO THÔNG TIN  -->
<script>
    $(document).ready(function() {
        $('.btn-accept').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            console.log('ID:', id); 

            $.ajax({
                url: 'save_notification.php',
                type: 'POST',
                data: { id: id, user_id: userId },
                success: function(response) {
                    console.log(response); // Kiểm tra phản hồi từ server
                    // Xử lý sau khi lưu thông báo thành công, có thể thêm thông báo cho người dùng
                    alert("Thông báo đã được lưu thành công");
                },
                fail: function(xhr, status, error) {
                    console.error("Lỗi AJAX:", error); // Bắt lỗi nếu gọi AJAX thất bại
                }
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
