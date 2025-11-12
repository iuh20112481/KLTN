<?php
    if (!isset($_SESSION['user']) || !isset($_SESSION["nvbc"]['id_user'])) {
        header("Location: dangNhapNhanSu.php");
        exit();
    }
    include_once("../control/cdonhang.php");
    $p = new control_donhang();

    $buuCucInfo = $_SESSION['buu_cuc_info'] ?? [];

    // Chỉ gọi hàm getAllDonHangforNVBC() khi có giá trị cho $maBuuCuc
    $maBuuCuc = $_SESSION['buu_cuc_info']['maBuuCuc'] ?? null;
    $idbuucuc = $_SESSION['buu_cuc_info']['Id_TenBC'] ?? null;
    if ($maBuuCuc !== null) {
        $donHang = $p->getAllDonHangforNVGH($maBuuCuc);
        $nhanVienGiaoHang = $p->getmaNhanVien($idbuucuc); 
    } else {
        $donHang = null; // Hoặc giá trị mặc định khác phù hợp
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['Id_TaoDonHang'], $_POST['maNhanVien']) && is_array($_POST['Id_TaoDonHang']) && is_array($_POST['maNhanVien'])) {
            foreach ($_POST['Id_TaoDonHang'] as $index => $idDonHang) {
                $maNhanVien = $_POST['maNhanVien'][$index] ?? ''; 
                $ngayPhanHangGiao = date('d-m-Y'); 
                $trangThaiDonHangGiao = '';
                if ($idDonHang && $maNhanVien) {
                    $p->updateDonHangforNVGH($idDonHang, $maNhanVien, $ngayPhanHangGiao, $trangThaiDonHangGiao);
                }
            }
            exit();
        } else {
            echo "Bạn chưa chọn nhân viên giao hàng cho đơn hàng nào!";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <input type="hidden" value="<?php echo $_SESSION['buu_cuc_info']['maBuuCuc'] ?>">
    <input type="hidden" value="<?php echo $_SESSION['buu_cuc_info']['Id_TenBC'] ?>">
    <h3 id="h2-content" class="text-center mt-2 p-1" style="color: darkblue;">Phân Đơn</h3>

    <div class="container-fluid">
        <form method="POST" action="" id="form-donhang">
            <table class="nhandonhang">
                <thead>
                    <tr>
                        <th class='th-style'>STT</th>
                        <th class='th-style'>Mã đơn hàng</th>
                        <th class='th-style'>Tên đơn hàng</th>
                        <th class='th-style'>Địa chỉ nhận</th>
                        <th class='th-style'>Mã vận đơn</th>
                        <th class='th-style'>Ngày phân đơn</th>
                        <th class='th-style'>Nhân viên giao hàng</th>
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
                            echo "<td>" . $dh['tenDonHang'] . "</td>";
                            echo "<td>" . $dh['diaChiNhanGop'] . "</td>";
                            echo "<td style='text-align: center;'>" . $dh['maVanDon'] . "</td>";
                            echo "<td style='text-align: center;'>" . date('d/m/Y') . "</td>";
                            
                            echo "<input type='hidden' name='Id_TaoDonHang[]' value='" . $dh['Id_TaoDonHang'] . "'>";

                            echo "<td class='action-select' style='text-align: center;'>";
                            echo "<select name='maNhanVien[]'>";
                            echo "<option value='' selected disabled>Chọn nhân viên giao hàng</option>";
                            if ($nhanVienGiaoHang && mysqli_num_rows($nhanVienGiaoHang) > 0) {
                                mysqli_data_seek($nhanVienGiaoHang, 0);
                                while ($nv = mysqli_fetch_assoc($nhanVienGiaoHang)) {
                                    echo "<option value='" . $nv['maNhanVien'] . "'>Nhân viên " . $nv['maNhanVien'] . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>Không có nhân viên giao hàng</option>";
                            }
                            echo "</select>";
                            echo "</td>";

                            echo "</tr>";
                            $i++;
                        }
                    } else {
                        echo "<tr><td colspan='7' style='text-align: center;'>Chưa có đơn hàng nào !</td></tr>";
                    }
                    ?>
                </tbody>            

            </table>                
                <div style="text-align: center;">
                <button type="submit" name="submit-pldh" class="submit-pldh" >Lưu</button>
                </div>
        </form>
    </div>

    <script>
        document.getElementById('form-donhang').addEventListener('submit', function(event) {
            // Prevent default form submission
            event.preventDefault();

            // Get form data
            var formData = new FormData(this);

            // Send form data using fetch API
            fetch('', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    // Reload the page
                    window.location.reload();
                } else {
                    throw new Error('Có lỗi xảy ra khi cập nhật đơn hàng!');
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
            });
        });
    </script>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['submit-pldh'])) {
    if (isset($_GET['Id_TaoDonHang'], $_GET['maNhanVien']) && is_array($_GET['Id_TaoDonHang']) && is_array($_GET['maNhanVien'])) {
        foreach ($_GET['Id_TaoDonHang'] as $index => $idDonHang) {
            $maNhanVien = $_GET['maNhanVien'][$index] ?? ''; 
            $ngayPhanHangGiao = date('d-m-Y'); 
            $trangThaiDonHangGiao = '';
            if ($idDonHang && $maNhanVien) {
                $p->updateDonHangforNVGH($idDonHang, $maNhanVien, $ngayPhanHangGiao , $trangThaiDonHangGiao);
            }
        }
    } else {
        echo "Bạn chưa chọn nhân viên giao hàng cho đơn hàng nào!";
    }
}
?>
