<?php
    session_start();
    if (!isset($_SESSION['user']) || !isset($_SESSION["nguoidung"]['id_user'])) {
        header("Location: dangNhap.php");
        exit();
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
    <title>Document</title>
    <style>
        .navbar-toggler-icon {
            background-image: none !important;
        }
        .navbar {
        background-color: #0081a4;
        color: white;
        }
        .menu {
            display: flex;
            justify-content: center;
        }
        .navbar a:hover {
        color: rgb(0 2 177);
        }
        .navbar-toggler {
        color: rgb(239 225 255 / 65%);
        }
        .offcanvas {
            --bs-offcanvas-width: 300px !important;
        }
        .offcanvas-header {
        background-color: #284159;
        color: white;
        padding: 9px;
        }
        .navbar-nav .nav-link.active, .navbar-nav .nav-link.show {
            text-decoration: none;
        }
        .offcanvas .nav-link {
        color: black;
        }
        .offcanvas .nav-link:hover {
        color: rgb(0 2 177);
        }
        .offcanvas {
        transition: all 0.5s ease;
        }
        .form-control {
        border-radius: 20px;
        }
        .btn {
        border-radius: 20px;
        }
        .container-fluid::before {
            content: none !important;
        }
        .container-fluid::after {
            content: none !important;
        }
        .bg-body-tertiary {
            background-color: ##333 !important;
        }
        .notification-container {
            position: relative;
        }
        .notification-container .btn {
            margin-right: 10px;
        }
        .modal-backdrop.show {
            display: none !important;
        }
        .modal-backdrop.show {
                opacity: 1;
            }

        .modal-dialog {
            margin-top: 65px !important;
        }
        #order-details {
            position: absolute ; 
            top: 0; 
            right: 0;
            width: 100%; 
            padding-top: 7px;
        }
        #order-table {
            overflow-x: auto; 
        }
        #div {
        background-color: #0000; /* Màu nền của div */
        padding: 10px; /* Khoảng cách giữa chữ và viền của div */
        transition: background-color 0.3s ease, color 0.3s ease; /* Hiệu ứng chuyển động cho màu nền và màu chữ */
        border-radius: 10px; /* Bo tròn góc của div */
        }

        #div:hover {
            color: rgb(0, 2, 177); /* Màu chữ khi hover */
            background-color: #ccc; /* Màu nền của div khi hover */
        }

    </style>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container-fluid">
        <div class="">
            <nav class="navbar fixed-top shadow">
                <div class="container-fluid">
                    <a id="h2-content" style="text-align:center;">Xin chào <u style="text-decoration:none;"><?php echo $_SESSION['name_user']; ?></u>
                        <br><?php $ngay = date('d/m/Y'); echo "$ngay";?>
                    </a>
                    <!-- MODAL Notification -->
                    <button class="btn btn-primary" id="notification-toggle" type="button" data-bs-toggle="modal" data-bs-target="#notification-modal" data-bs-backdrop="false">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-danger"><?php ?></span>
                    </button>

                    <div class="modal fade" id="notification-modal" tabindex="-1" aria-labelledby="notification-modalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header" style="padding:0;">
                                    <h5 class="modal-title" id="notification-modalLabel" style="color: black; text-align: center; padding: 2px; font-size: 17px;">Thông báo mới</h5>
                                    <button style="margin:0;" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Thông báo sẽ được tải động từ AJAX -->
                                </div>
                                    </div>
                                </div>
                            </div>
                    <!-- TÌM KIẾM  -->
                        <form class="d-flex" role="search">
                            <input class="form-control me-2" type="search" id="ma_van_don" placeholder="Tìm kiếm đơn hàng" aria-label="Search">
                        </form>
                    <!-- Form hiển thị thông tin đơn hàng -->
                        <div id="order-details" style="margin-top: 50px;">
                            <form id="order-form" style="display: none;">
                                <!-- Các trường thông tin đơn hàng sẽ được hiển thị ở đây -->
                            </form>
                            <!-- Bảng hiển thị thông tin đơn hàng -->
                            <div id="order-table"></div>
                        </div>
                    <!-- Toggle -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                        <a style="color:#ffff" href="#"><i class="bi bi-list fs-2"></i></a>
                    </button>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">
                                <h6 id="p1-content" style="text-align:center;">Xin chào <br> <u style="font-weight:bold; text-decoration:none;"><?php echo $_SESSION['name_user']; ?></u></h6>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                <div class="nav-item" id="div">
                                    <a id="p1-content" class="nav-link active" aria-current="page" href="u_giaodiennguoidung.php">Trang chủ</a>
                                </div>
                                <div class="nav-item" id="div">
                                    <a id="p1-content" class="nav-link active" aria-current="page" href="?page=aDBO">Tạo đơn hàng</a>
                                </div>
                                <div class="nav-item" id="div">
                                    <a id="p1-content" class="nav-link active" aria-current="page" href="?page=aqldh">Quản lý đơn hàng</a>
                                </div>
                                <div class="nav-item" id="div">
                                    <a id="p1-content" class="nav-link active" aria-current="page" href="?page=aPR">Quản lý tài khoản</a>
                                </div>
                                <div class="nav-item" id="div">
                                    <a id="p1-content" class="nav-link active" aria-current="page" href="?page=att">Thanh toán đơn hàng</a>
                                </div>
                                <div class="nav-item" id="div">
                                    <a id="p1-content" class="nav-link active" aria-current="page" href="?page=qldht">Nhận đơn hoàn trả</a>
                                </div>
                                <div class="nav-item" id="div">
                                    <a id="p1-content" class="nav-link active" aria-current="page" href="#">Báo cáo tài chính</a>
                                </div>
                                <div class="nav-item" id="div">
                                    <a id="p1-content" class="nav-link active" aria-current="page" href="#">Quản lý cửa hàng</a>
                                </div>
                                <div class="nav-item" id="div">
                                    <a  class="nav-link active" id="logout-link" href="#">Đăng xuất</a>
                                </div>
                            </ul>

                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <div class="container-fluid">
            <?php
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
                switch ($page) {
                    case 'aDBO':
                        include('u_taoDonHang.php');
                        break;
                    case 'aDBB':
                        include('dangnhap.php');
                        break;
                    case 'aqldh':
                        include('u_quanlydonhang.php');
                        break;
                    case 'aPR':
                        include('u_profile.php');
                        break;
                    case 'att':
                        include('u_thanhtoan.php');
                        break;
                    case 'qldht':
                        include('u_quanlydonhoantra.php');
                        break;    
                    default:
                        include('u_giaodiennguoidung_main.php');
                }
            } else {
                include('u_giaodiennguoidung_main.php');
            }
            ?>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#ma_van_don').on('input', function() {
            var maVanDon = $(this).val();
            if (maVanDon.length > 0) {
                var idTaiKhoan = <?php echo $_SESSION["nguoidung"]['id_user']; ?>;
                $.ajax({
                    type: 'GET',    
                    url: 'http://localhost:8080/WEBSITE_EXHIBITION/api/API_searchForND.php?Id_TaiKhoan=' + idTaiKhoan + '&maVanDon=' + maVanDon,    
                    success: function(response) {
        // Kiểm tra xem phản hồi có dữ liệu không
        if (response && response.length > 0) {
            var html = '<table class="table">' +
                '<thead>' +
                '<tr>' +
                '<th class="th-style0">Mã vận đơn</th>' +
                '<th class="th-style0">Tên đơn hàng</th>' +
                '<th class="th-style0">Tên người nhận</th>' +
                '<th class="th-style0">Số điện thoại</th>' +
                '<th class="th-style0">Địa chỉ nhận</th>' +
                '<th class="th-style0">Trạng thái</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>';
                
            // Lặp qua mỗi đơn hàng trong phản hồi
            response.forEach(function(order) {
                // Kiểm tra xem mỗi đơn hàng có các thuộc tính cần thiết không
                if (order.maVanDon && order.tenDonHang && order.tenNN && order.sdtNN && order.diaChiNhanGop && order.trangThaiDonHang) {
                    // Thêm dữ liệu của mỗi đơn hàng vào bảng
                    html += '<tr>' +
                        '<td>' + order.maVanDon + '</td>' +
                        '<td>' + order.tenDonHang + '</td>' +
                        '<td>' + order.tenNN + '</td>' +
                        '<td>' + order.sdtNN + '</td>' +
                        '<td>' + order.diaChiNhanGop + '</td>' +
                        '<td>' + order.trangThaiDonHang + '</td>' +
                        '</tr>';
                }
            });

            html += '</tbody></table>';
            $('#order-table').html(html);
            $('#order-form').hide();
        } else {
            $('#order-table').html('<div class="text-primary text-center">Không tìm thấy đơn hàng nào !</div>');
        }
    }
    });
    } else {
    $('#order-table').html('');
    $('#order-form').hide();
    }
    });
    });
    </script>
    
    <!-- Modal xác nhận đăng xuất -->
    <div class="modal fade" id="logout-modal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel"><span id="h2-content">Xác nhận đăng xuất</span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body-1" class="row g-3" style="padding: 25px;">
                    <span id="p1-content">Bạn có muốn đăng xuất không?</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="padding:10px;">Không</button>
                    <a id="logout-confirm-btn" href="dangXuat.php" class="btn btn-danger" style="padding:10px;width: 60px;">Có</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Xử lý sự kiện khi nhấn vào nút "Đăng xuất"
        document.getElementById('logout-link').addEventListener('click', function (event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của liên kết
            var logoutModal = new bootstrap.Modal(document.getElementById('logout-modal'));
            logoutModal.show();
        });
    </script>

    <script>
        $(document).ready(function() {
            // Function to check notifications
            function checkNotifications() {
                $.ajax({
                    url: '../control/check_notifications.php',
                    type: 'get',
                    success: function(response) {
                        var notifications = JSON.parse(response);
                        var html = '';
                        if (notifications.length > 0) {
                            notifications.forEach(function(notification) {
                                html += '<div class="alert alert-success" role="alert" style="font-size:smaller; padding:9px;">' +
                                            notification.message +
                                            '<button type="button" class="close" aria-label="Close" onclick="deleteNotification(' + notification.id + ')">' +
                                            '<span aria-hidden="true">&times;</span>' +
                                            '</button>' +
                                        '</div>';
                            });
                        } else {
                            html = '<div class="text-primary text-center" role="alert">Không có thông báo nào !</div>';
                        }
                        $('.modal-body').html(html);
                    }
                });
            }

            // Initial check after 1 second
            setTimeout(function() {
                checkNotifications();
                // Set up recurring checks every 5 seconds
                setInterval(checkNotifications, 10000);
            }, 1000);
        });
        function deleteNotification(id) {
            $.ajax({
                url: '../control/delete_notification.php',
                type: 'post',
                data: { id: id },
                success: function(response) {
                    // Kiểm tra phản hồi từ server và cập nhật giao diện
                    if (response === 'success') {
                        // Xóa thông báo từ giao diện
                        $('button[onclick="deleteNotification(' + id + ')"]').closest('.alert').remove();
                    } else {
                        console.error('Xóa thông báo thất bại');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Lỗi AJAX:', error);
                }
            });
        }
    </script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>