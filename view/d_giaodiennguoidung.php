<?php
    session_start();

    if (!isset($_SESSION["nvgh"]['id_user'])) {
        header("Location: dangNhapNhanSu.php");
        exit();
    }
    $idTaiKhoan = $_SESSION["nvgh"]['id_user'];
    include_once("../control/cdonhang.php");
    $p = new control_donhang();
    $maNhanVienResult = $p->getmaNhanVienbyidTaiKhoan($idTaiKhoan);

    $diaChiBC = $p->getmaNhanVienbyidTaiKhoan($idTaiKhoan);

    $donHang = $p->getmaNhanVienbyidTaiKhoan($idTaiKhoan);
    if ($diaChiBC && mysqli_num_rows($diaChiBC) > 0) {
        $diaChiBCAssoc = mysqli_fetch_assoc($diaChiBC);
        $diaChiBC = $diaChiBCAssoc['diaChiBC'];
    } else {
        echo "Chưa cập nhật địa chỉ bưu cục !";
        exit();
    }
    $maBuuCuc = $p->getmaNhanVienbyidTaiKhoan($idTaiKhoan);
    if ($maBuuCuc && mysqli_num_rows($maBuuCuc) > 0) {
        $maBuuCucAssoc = mysqli_fetch_assoc($maBuuCuc);
        $maBuuCuc = $maBuuCucAssoc['maBuuCuc'];
    } else {
        echo "Chưa cập nhật mã bưu cục !";
        exit();
    }

    if ($maNhanVienResult && mysqli_num_rows($maNhanVienResult) > 0) {
        $maNhanVienAssoc = mysqli_fetch_assoc($maNhanVienResult);
        $maNhanVien = $maNhanVienAssoc['maNhanVien'];
    } else {
        echo "Hôm nay bạn không có đơn hàng nào !";
        exit();
    }
    include_once("../control/cdonhang.php");
    $p = new control_donhang();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['action'] === 'updateDonHangofNVGH') {
            $idDonHang = $_POST['idDonHang'];
            $trangThaiDonHang = $_POST['trangThaiDonHang'];
            $maNhanVien = $_POST['maNhanVien'];
            $ngayHTGiaoHang = date('d-m-Y');
            $p = new control_donhang();
            $result = $p->updateDonHangofNVGH($idDonHang, $maNhanVien, $trangThaiDonHang, $ngayHTGiaoHang);
            if ($result) {
                echo json_encode(array('success' => true));
            } else {
                echo json_encode(array('success' => false, 'message' => 'Cập nhật đơn hàng thất bại'));
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giao Hàng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="../css/style.css?v=3">
    <style>
        .bg-body-tertiary {
            --bs-bg-opacity: 1;
            background-color: rgb(36 213 207) !important;
        }
        .offcanvas{
            background-color: #ecf4fd;
        }

        .offcanvas-header {
        background-color: #284159;
        color: white;
        padding: 13px;
        }
        .navbar-toggler {
            border: var(--bs-border-width) solid rgb(3 0 133 / 97%);
        }
    </style>
</head>

<body>
    <!-- MODAL TÌM KIẾM  -->
    <div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailModalLabel">Chi tiết đơn hàng</h5>
                </div>
                <div class="modal-body-1">
                    <table class="table-bordered">
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
                                <th class="th-style">Ngày HT Giao Hàng</th>
                                <th class="th-style">Ngày Phân Hàng Giao</th>
                                <th class="th-style">Trạng Thái Đơn Hàng</th>
                            </tr>
                        </thead>
                        <tbody id="orderDetailTableBody">
                            <!-- Data will be inserted here -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- TRANG CHỦ -->
    <div class="container-fluid">
        <div class="">
            <nav class="navbar bg-body-tertiary fixed-top">
                <div class="container-fluid">
                    <span id="h2-content" style="text-decoration:none;color: cornsilk;">Xin chào <?php echo $_SESSION['name_user']; ?></span>
                    <span style="color: cornsilk;">Mã nhân viên: <?php echo $maNhanVien ; ?></span>
                    <span style="color: cornsilk;">Bưu cục: <?php echo $maBuuCuc; ?></span>
                    <span style="color: cornsilk;"><?php echo 'Bưu cục: ' . $diaChiBC; ?></span>
                    <button class="navbar-toggler" style="border: 1px solid #02006b1a;" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                        <a style="color:#ffff;" href="#"><i class="bi bi-list fs-2"></i></a>
                    </button>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header" id="h2-content">
                            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Xin chào <?php echo $_SESSION['name_user']; ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3" id="p2-content">

                                <li class="nav-item dropdown" >
                                    <a class="nav-link" href="?page=main" style="text-decoration:none;">Quản lý đơn giao trong ngày</a>
                                    <a class="nav-link" href="" style="text-decoration:none;">Quản lý dòng tiền</a>
                                    <a class="nav-link" href="?page=axemdhdg" style="text-decoration:none;">Xem lại đơn hàng đã giao</a>
                                    <a class="nav-link" href="?page=aqltk" style="text-decoration:none;">Quản lý thông tin cá nhân</a>
                                    <a class="nav-link" href="" style="text-decoration:none;">Quản lý Báo cáo</a>
                                    <a class="nav-link" href="dangXuat.php" style="text-decoration:none;">Đăng xuất</a>
                                </li>
                            </ul>
                            <form class="d-flex mt-3" role="search">
                            <input class="form-control me-2" type="search" placeholder="Tìm đơn" id="maVanDonInput" aria-label="Search">
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <div class="container-fluid pt-5">
            <?php
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                switch ($page) {
                    case 'aqltk':
                        include('d_profile.php');
                        break;
                    case 'main':
                        include('d_giaohangmain.php');
                        break;
                    case 'axemdhdg':
                        include('d_xemlaidonhanggiao.php');
                        break;
                    case 'aPR':
                        include('u_profile.php');
                        break;
                    case 'actb':
                        include('check_notifications.php');
                        break;
                    default:
                        include('d_giaohangmain.php');
                }
            } else {
                include('d_giaohangmain.php');
            }
            ?>
        </div>
    </div>

    <!-- <script>
    // Hàm debounce
    function debounce(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this,
                args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    // Hàm fetchData với debounce
    var fetchDataDebounced = debounce(fetchData, 500); 

    // Sự kiện change của ô tìm kiếm
    document.getElementById('maVanDonInput').addEventListener('change', function() {
        var maVanDon = this.value;
        if (maVanDon !== '') {
            fetchDataDebounced(null, null, maVanDon); // Gọi hàm debounce
            $('#orderDetailModal').modal('show');
        }
    });

    function fetchData(param1, param2, maVanDon) {
        // Get the PHP variable
        var maNhanVien = <?php echo json_encode($maNhanVien); ?>;
        var apiEndpoint = '../API/API_xemlaidongiao.php?maNhanVien=' + encodeURIComponent(maNhanVien) + '&maVanDon=' + encodeURIComponent(maVanDon);
        // Fetch data from the API
        fetch(apiEndpoint, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.length === 0) {
                document.getElementById('orderDetailTableBody').innerHTML = '<tr><td colspan="11" style="text-align:center;">Không có đơn hàng.</td></tr>';
            } else {
                let html = '';
                data.forEach(item => {
                    html += `
                        <tr>
                            <td>${item.Id_DonHang}</td>
                            <td>${item.maVanDon}</td>
                            <td>${item.tenDonHang}</td>
                            <td>${item.tenNN}</td>
                            <td>${item.sdtNN}</td>
                            <td>${item.tenNG}</td>
                            <td>${item.sdtNG}</td>
                            <td>${item.diaChiNhanGop}</td>
                            <td>${item.ngayHTGiaoHang}</td>
                            <td>${item.ngayPhanHangGiao}</td>
                            <td>${item.trangThaiDonHang}</td>
                        </tr>
                    `;
                });
                document.getElementById('orderDetailTableBody').innerHTML = html;
                $('#orderDetailModal').modal('show');
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }   
</script> -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

</body>
</html>
