<?php
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: dangNhapNhanSu.php");
            exit();
        }
        $idUser = $_SESSION["admin"]['id_user'];
        $nameUser = $_SESSION['name_user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Trang Admin - HPship</title>
  <!-- Iconic Fonts -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="../css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <!-- Bootstrap core CSS -->
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery UI -->
  <link href="../css/jquery-ui.min.css" rel="stylesheet">
  <!-- Page Specific CSS (Slick Slider.css) -->

  <link href="../css/slick.css" rel="stylesheet">
  <link href="../css/style1.css?=v21" rel="stylesheet">
  <!-- Favicon -->
  <link rel="icon" href="img/logo.png" type="image/x-icon" sizes="16x16" type="image/png">
  <style>
    a{
      text-decoration: none !important;
      color: #ffff !important;
    }
    /* Custom FONT */
    @font-face {
      font-family: 'Samsung One 400';
      src: url('../WEBSITE_EXHIBITION/font/SamsungOne-400.ttf') format('woff2'),
          url('../WEBSITE_EXHIBITION/font/SamsungOne-400.ttf') format('truetype');
      font-weight: 400;
      font-style: normal;
      }

      @font-face {
          font-family: 'Samsung One 700';
          src: url('../font/SamsungOne-700.ttf') format('truetype');
          font-weight: 700;
          font-style: normal;
      }

      @font-face {
          font-family: 'Samsung Sharp Sans Bold';
          src: url('../font/SamsungSharpSans-Bold.ttf') format('truetype');
          font-weight: bold;
          font-style: normal;
      }

      @font-face {
          font-family: 'SamsungSharpSans-Bold_SMCPS';
          src: url('../font/iCiel-SamsungSharpSans-Bold_SMCPS.ttf') format('truetype');
          font-weight: bold;
          font-style: normal;
      }
      body{
        font-family: 'Samsung One 700', sans-serif !important;
        line-height: 1.2 !important;
      }
      .thongtin{
        font-family: 'Samsung One 400', sans-serif;
      }
      .admin-badge {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        display: inline-block;
        margin-left: 10px;
      }
  </style>
</head>

<body class="ms-body ms-aside-left-close ms-primary-theme ">


  <!-- Preloader -->

  <!-- Overlays -->
  <div class="ms-aside-overlay ms-overlay-left ms-toggler" data-target="#ms-side-nav" data-toggle="slideLeft"></div>
  <div class="ms-aside-overlay ms-overlay-right ms-toggler" data-target="#ms-recent-activity" data-toggle="slideRight"></div>

  <!-- Sidebar Navigation Left -->
  <aside id="ms-side-nav" class="side-nav fixed ms-aside-scrollable ms-aside-left">

    <!-- Logo -->
    <div class="logo-sn ms-d-block-lg">
        <a class="pl-0 ml-0 text-center" href="admin_giaodiennguoidung.php">
            <img src="../img/logo.png" alt="logo" style="width: 80px; height: auto;">
        </a>
        <div class="text-center mt-2">
            <span class="admin-badge"><i class="fas fa-crown"></i> ADMIN</span>
        </div>
    </div>

    <!-- Navigation -->
<ul class="accordion ms-main-aside fs-14" id="side-nav-accordion">

  <!---Quản lý Bưu cục -->
  <li class="menu-item">
    <a href="#" class="has-chevron" data-toggle="collapse" data-target="#buucuc" aria-expanded="false" aria-controls="buucuc">
      <span><i class="fa-solid fa-house"></i>Quản lý Bưu cục</span>
    </a>
    <ul id="buucuc" class="collapse" aria-labelledby="buucuc" data-parent="#side-nav-accordion">
      <li> <a href="?page=tkdt">Thống kê doanh thu</a> </li>
    </ul>
  </li>
  <!-- /Quản lý Bưu cục -->

  <!-- Quản lý nhân sự -->
  <li class="menu-item">
    <a href="#" class="has-chevron" data-toggle="collapse" data-target="#nhansu" aria-expanded="false" aria-controls="nhansu">
      <span><i class="fa-solid fa-users"></i>Quản lý nhân sự</span>
    </a>
    <ul id="nhansu" class="collapse" aria-labelledby="nhansu" data-parent="#side-nav-accordion">
      <li> <a href="?page=qlnvbc">Nhân viên bưu cục</a> </li>
      <li> <a href="?page=adsnvgh">Nhân viên giao hàng</a> </li>
      <li> <a href="?page=addnvbc">Thêm nhân viên bưu cục</a> </li>
      <li> <a href="?page=addnvgh">Thêm nhân viên giao hàng</a> </li>
      <li> <a href="?page=qlhoahong">Quản lý hoa hồng</a> </li>
    </ul>
  </li>
  <!-- /Quản lý nhân sự -->

  <!-- Phân quyền -->
  <li class="menu-item">
    <a href="?page=phanquyen">
      <span><i class="fa-solid fa-user-shield"></i>Phân quyền</span>
    </a>
  </li>
  <!-- /Phân quyền -->

  <!-- Phân đơn -->
  <li class="menu-item">
    <a href="?page=vphanloaidonhang">
      <span><i class="fa-regular fa-calendar-days"></i>Phân đơn</span>
    </a>
  </li>
  <!-- /Phân đơn -->

  <!-- Quản lý đơn hàng -->
  <li class="menu-item">
    <a href="?page=qldh">
      <span><i class="fa-regular fa-comments"></i>Quản lý đơn hàng</span>
    </a>
  </li>
  <!-- /Quản lý đơn hàng -->

  <!-- Tạo đơn hàng vãng lai -->
  <li class="menu-item">
    <a href="?page=taoDonHangVangLai">
      <span><i class="fa-solid fa-plus-circle"></i>Tạo đơn hàng vãng lai</span>
    </a>
  </li>
  <!-- /Tạo đơn hàng vãng lai -->

</ul>
  </aside>


  <!-- Main Content -->
  <main class="body-content">

    <!-- Navigation Bar -->
    <nav class="navbar ms-navbar">

      <div class="ms-aside-toggler ms-toggler" data-target="#ms-side-nav" data-toggle="slideLeft">
        <span class="ms-toggler-bar bg-white"></span>
        <span class="ms-toggler-bar bg-white"></span>
        <span class="ms-toggler-bar bg-white"></span>
      </div>

      <ul class="ms-nav-list mb-0 text-white">
          <div style="display: flex; align-items: center;">
            <i class="fas fa-crown" style="color: #ffd700; margin-right: 10px; font-size: 20px;"></i>
            <div>
              <strong style="font-size: 16px;">QUẢN TRỊ VIÊN</strong><br>
              <span class="thongtin">Xin chào, <?php echo $nameUser; ?></span>
            </div>
          </div>
      </ul>

      <ul class="ms-nav-list ms-inline mb-0" id="ms-nav-options">

        <!-- Thông báo -->
        <li class="ms-nav-item dropdown">
          <a href="#" class="text-disabled ms-has-notification" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-regular fa-bell fa-beat"></i></a>
          <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown">
            <li class="dropdown-menu-header">
              <h6 class="dropdown-header ms-inline m-0"><span class="text-disabled">THÔNG BÁO</span></h6>
            </li>
            <li class="ms-scrollable ms-dropdown-list">
              <a class="media p-2" href="#">
                <div class="media-body">
                  <span>Chào mừng quản trị viên đến với HPship!</span>
                  <p class="fs-10 my-1 text-disabled"><i class="material-icons">access_time</i> Vừa xong</p>
                </div>
              </a>
            </li>

            </li>
          </ul>
        </li>

        <li class="ms-nav-item ms-nav-user dropdown">
          <a href="#" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa-regular fa-circle-user fa-2xl"></i> </a>
          <ul class="dropdown-menu dropdown-menu-right user-dropdown" aria-labelledby="userDropdown" style="border-radius:12px; box-shadow: 5px 5px 10px 0px rgba(0, 0, 0, 0.60);">

            <li class="dropdown-menu-footer" style="min-width: 270px;">
            <p style="text-align:center;";>Xin chào <br> <u style=" font-weight:bold; text-decoration:none";><?php echo $_SESSION['name_user']; ?></u></p>
            <p style="text-align:center; color: #667eea; font-weight: bold;">Quản trị viên</p>
            <hr>
              <a class="media fs-14 p-2" href="?page=adx" id="logout-link">
                  <span><i class="fas fa-sign-out-alt"></i>Đăng xuất</span>
              </a>
            </li>
          </ul>
        </li>

      </ul>

      <div class="ms-toggler ms-d-block-sm pr-0 ms-nav-toggler" data-toggle="slideDown" data-target="#ms-nav-options">
        <span class="ms-toggler-bar bg-primary"></span>
        <span class="ms-toggler-bar bg-primary"></span>
        <span class="ms-toggler-bar bg-primary"></span>
      </div>

    </nav>

    <!-- Body Content Wrapper -->

    <div class="ms-content-wrapper" style="padding:0;">
      <?php
        if (isset($_GET['page'])) {
          $page = $_GET['page'];
          switch ($page) {
              case 'vphanloaidonhang':
                  include_once("m_phanloaidonhang.php");
                  break;
              case 'qlnvbc':
                  include_once("admin_quanlyNVBC.php");
                  break;
              case 'adsnvgh':
                  include_once("m_quanlyNVGH.php");
                  break;
              case 'adx':
                  include_once("dangxuat.php");
                  break;
              case 'addnvbc':
                  echo '<div class="container mt-5"><h3><i class="fas fa-user-plus"></i> Thêm nhân viên bưu cục</h3><p class="text-muted">Chức năng đang được phát triển...</p></div>';
                  break;
              case 'addnvgh':
                  include_once("m_themNVGH.php");
                  break;
              case 'qlhoahong':
                  include_once("m_quanlyhoahong.php");
                  break;
              case 'phanquyen':
                  echo '<div class="container mt-5"><h3><i class="fas fa-user-shield"></i> Phân quyền người dùng</h3><p class="text-muted">Chức năng đang được phát triển...</p></div>';
                  break;
              case 'tkdt':
                  include_once("m_thongkedoanhthu.php");
                  break;
              case 'qldh':
                  include_once("m_quanlydonhang.php");
                  break;
              case 'taoDonHangVangLai':
                  $_SESSION['staff_creating_order'] = true;
                  include_once("m_taoDonHangVangLai.php");
                  break;
              default:
                  // Dashboard mặc định
                  echo '
                  <div class="container-fluid mt-5 p-4">
                      <div class="row">
                          <div class="col-12">
                              <h2><i class="fas fa-tachometer-alt"></i> Dashboard Quản trị viên</h2>
                              <hr>
                          </div>
                      </div>
                      <div class="row mt-4">
                          <div class="col-md-4 mb-3">
                              <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                  <div class="card-body">
                                      <h5><i class="fas fa-users"></i> Quản lý Nhân sự</h5>
                                      <p>Quản lý toàn bộ nhân viên bưu cục và giao hàng</p>
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-4 mb-3">
                              <div class="card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                                  <div class="card-body">
                                      <h5><i class="fas fa-user-shield"></i> Phân Quyền</h5>
                                      <p>Thiết lập quyền truy cập cho người dùng</p>
                                  </div>
                              </div>
                          </div>
                          <div class="col-md-4 mb-3">
                              <div class="card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                                  <div class="card-body">
                                      <h5><i class="fas fa-box"></i> Quản lý Đơn hàng</h5>
                                      <p>Theo dõi và quản lý tất cả đơn hàng</p>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="row mt-4">
                          <div class="col-12">
                              <div class="alert alert-info">
                                  <h5><i class="fas fa-info-circle"></i> Hướng dẫn sử dụng</h5>
                                  <ul>
                                      <li>Sử dụng menu bên trái để điều hướng giữa các chức năng</li>
                                      <li>Quản lý nhân sự: Xem, thêm, sửa thông tin nhân viên</li>
                                      <li>Phân quyền: Thiết lập quyền truy cập cho từng vai trò</li>
                                      <li>Quản lý đơn hàng: Theo dõi trạng thái và xử lý đơn hàng</li>
                                  </ul>
                              </div>
                          </div>
                      </div>
                  </div>
                  ';
        }
        }else{
          // Dashboard mặc định
          echo '
          <div class="container-fluid mt-5 p-4">
              <div class="row">
                  <div class="col-12">
                      <h2><i class="fas fa-tachometer-alt"></i> Dashboard Quản trị viên</h2>
                      <hr>
                  </div>
              </div>
              <div class="row mt-4">
                  <div class="col-md-4 mb-3">
                      <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                          <div class="card-body">
                              <h5><i class="fas fa-users"></i> Quản lý Nhân sự</h5>
                              <p>Quản lý toàn bộ nhân viên bưu cục và giao hàng</p>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-4 mb-3">
                      <div class="card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                          <div class="card-body">
                              <h5><i class="fas fa-user-shield"></i> Phân Quyền</h5>
                              <p>Thiết lập quyền truy cập cho người dùng</p>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-4 mb-3">
                      <div class="card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                          <div class="card-body">
                              <h5><i class="fas fa-box"></i> Quản lý Đơn hàng</h5>
                              <p>Theo dõi và quản lý tất cả đơn hàng</p>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="row mt-4">
                  <div class="col-12">
                      <div class="alert alert-info">
                          <h5><i class="fas fa-info-circle"></i> Hướng dẫn sử dụng</h5>
                          <ul>
                              <li>Sử dụng menu bên trái để điều hướng giữa các chức năng</li>
                              <li>Quản lý nhân sự: Xem, thêm, sửa thông tin nhân viên</li>
                              <li>Phân quyền: Thiết lập quyền truy cập cho từng vai trò</li>
                              <li>Quản lý đơn hàng: Theo dõi trạng thái và xử lý đơn hàng</li>
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
          ';
        }
      ?>
    </div>

  </main>
  <br>
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
  <!-- SCRIPTS -->
    <!-- Global Required Scripts Start -->
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/perfect-scrollbar.js"> </script>
    <script src="../js/jquery-ui.min.js"> </script>
    <!-- Global Required Scripts End -->

    <!-- Weedo core JavaScript -->
    <script src="../js/framework.js"></script>

    <!-- Settings -->
    <script src="../js/settings.js"></script>

</body>

</html>
