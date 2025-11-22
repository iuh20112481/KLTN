<?php
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: dangNhapNhanSu.php");
            exit();
        }
        $idUser = $_SESSION["nvbc"]['id_user'];
        $nameUser = $_SESSION['name_user'];
        $buuCucInfo = $_SESSION['buu_cuc_info'];
        if(isset($buuCucInfo["Id_PhanLoaiNguoiDung"])) {
            $_SESSION["nvbc"]["Id_PhanLoaiNguoiDung"] = $buuCucInfo["Id_PhanLoaiNguoiDung"];
        }
        include_once ("../control/cdonhang.php");
        $p = new control_donhang();

        if(isset($_GET['q']) && $_GET['q'] == 'chapnhan') {
            $IdTaoDonHang = $_GET['id'];
            $trangThaiDonHang = 'Đang chờ phân đơn';
            $p->insertDonHang($_SESSION["nvbc"]["Id_PhanLoaiNguoiDung"], $IdTaoDonHang, $buuCucInfo['maBuuCuc'] , $trangThaiDonHang);
        }
        if(isset($_GET['q']) && $_GET['q'] == 'huy') {
            $IdTaoDonHang = $_GET['id'];
            $trangthaidonhuy='Hủy đơn';
            $p->rejectDonHang($_SESSION["nvbc"]["Id_PhanLoaiNguoiDung"], $IdTaoDonHang , $buuCucInfo['maBuuCuc'], $trangthaidonhuy);
        }
      
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Trang chủ</title>
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
        <a class="pl-0 ml-0 text-center" href="m_giaodiennguoidung.php">
            <img src="../img/logo.png" alt="logo" style="width: 80px; height: auto;">
        </a>
    </div>

    <!-- Navigation -->
<ul class="accordion ms-main-aside fs-14" id="side-nav-accordion">
  
  <!---Quản lý Bưu cục -->
  <li class="menu-item">
    <a href="#" class="has-chevron" data-toggle="collapse" data-target="#user" aria-expanded="false" aria-controls="user">
      <span><i class="fa-solid fa-house"></i>Quản lý Bưu cục</span>
    </a>
    <ul id="user" class="collapse" aria-labelledby="user" data-parent="#side-nav-accordion">
      <li> <a href="?page=tkdt">Thống kê doanh thu</a> </li>
    </ul>
  </li>
  <!-- /Quản lý Bưu cục -->

  <!-- Quản lý nhân sự -->
  <li class="menu-item">
    <a href="#" class="has-chevron" data-toggle="collapse" data-target="#muctieu" aria-expanded="false" aria-controls="muctieu">
      <span><i class="fa-solid fa-users"></i>Quản lý nhân sự</span>
    </a>
    <ul id="muctieu" class="collapse" aria-labelledby="muctieu" data-parent="#side-nav-accordion">
      <li> <a href="?page=adsnvgh">Nhân viên giao hàng</a> </li>
      <li> <a href="?page=addnvgh">Thêm nhân viên</a> </li>
    </ul>
  </li>
  <!-- /Quản lý nhân sự -->

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

  <!-- ✅ TẠOO ĐƠN HÀNG VÃNG LAI - THÊM VÀO MENU -->
  <li class="menu-item">
    <a href="?page=taoDonHangVangLai">
      <span><i class="fa-solid fa-plus-circle"></i>Tạo đơn hàng vãng lai</span>
    </a>
  </li>
  <!-- /TẠOO ĐƠN HÀNG VÃNG LAI -->

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
          <?php 
            echo "Tên bưu cục: <a class='thongtin'>" . $buuCucInfo['tenBuuCuc'] . "</a><br>"; 
            echo "Mã bưu cục: <a class='thongtin'>" . $buuCucInfo['maBuuCuc'] . "</a><br>";
            echo "Nhân viên: <a class='thongtin'> ".$nameUser." </a><br>";
          ?>
      </ul>

      <ul class="ms-nav-list ms-inline mb-0" id="ms-nav-options">
        
        <!-- Thông báo -->
        <li class="ms-nav-item dropdown">
          <a href="#" class="text-disabled ms-has-notification" id="notificationDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa-regular fa-bell fa-beat"></i></a>
          <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown">
            <li class="dropdown-menu-header">
              <h6 class="dropdown-header ms-inline m-0"><span class="text-disabled">THÔNG BÁO</span></h6><span class="badge badge-pill badge-info">4 New</span>
            </li>
            <!-- <li class="dropdown-divider"></li> -->
            <li class="ms-scrollable ms-dropdown-list">
                <?php 
                    if (date("H:i") == "21:00") {
                        $ngay = date("d/m/Y");
                        $gio = date("H:i:s");
                        
                        echo" <a class='media p-2' href='#'>";
                        echo"<span>Đã đến thời gian đánh giá mỗi ngày</span>";
                        echo"<p class='fs-10 my-1 text-disabled'><i class='material-icons'>access_time</i>$ngay/ $gio </p>";
                        echo"</a>";
                        // Các xử lý khác nếu cần
                    }
                ?>
              <a class="media p-2" href="#">
                <div class="media-body">
                  <span>Mục tiêu của bạn đã đến hạn rồi vào đánh giá ngay thôi nào !</span>
                  <p class="fs-10 my-1 text-disabled"><i class="material-icons"></i> 30 seconds ago</p>
                </div>
              </a>
              <a class="media p-2" href="#">
                <div class="media-body">
                  <span>Cảm xúc hôm nay của bạn thế nào?</span>
                  <p class="fs-10 my-1 text-disabled"><i class="material-icons">access_time</i> 45 minutes ago</p>
                </div>
              </a>
              <a class="media p-2" href="#">
                <div class="media-body">
                  <span>Nhìn lại một tháng vừa qua của bạn ?</span>
                  <p class="fs-10 my-1 text-disabled"><i class="material-icons">access_time</i> 2 hours ago</p>
                </div>
              </a>
              <a class="media p-2" href="#">
                <div class="media-body">
                  <span>Bạn có hoàn thành việc quan trọng của bạn chưa?</span>
                  <p class="fs-10 my-1 text-disabled"><i class="material-icons">access_time</i> 1 day ago</p>
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
              case 'aDBO':
                  include_once('view/vdieubieton.php');
                  break;
              case 'vphanloaidonhang':
                  include_once("m_phanloaidonhang.php");
                  break;
              case 'adsnvgh':
                  include_once("m_quanlyNVGH.php");
                  break;
              case 'adx':
                  include_once("dangxuat.php");
                  break;
              case 'addnvgh':
                  include_once("m_themNVGH.php");
                  break;
              case 'tkdt':
                  include_once("m_thongkedoanhthu.php");
                  break;
              case 'qldh':
                  include_once("m_quanlydonhang.php");
                  break;
              case 'dangky_ho_khach':
                  include_once("m_dangkyhokhach.php");
                  break;
              // ✅ TẠOO ĐƠN HÀNG VÃNG LAI
              case 'taoDonHangVangLai':
                  $_SESSION['staff_creating_order'] = true;
                  include_once("m_taoDonHangVangLai.php");
                  break;
              // /TẠOO ĐƠN HÀNG VÃNG LAI
              default:
                  // Mặc định, có thể hiển thị trang chủ hoặc thông báo lỗi
                  include('m_nhandonhang.php');
                  // echo 'Trang không tồn tại';
                  
        }
        }else{
          include('m_nhandonhang.php');
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

    <!-- Page Specific Scripts Start -->
    <!-- <script src="../js/moment.js"> </script>
    <script src="../js/jquery.webticker.min.js"> </script>
    <script src="../js/Chart.bundle.min.js"> </script>
    <script src="../js/Chart.Financial.js"> </script>
    <script src="../js/table-line.js"> </script>
    <script src="../js/index-chart.js"> </script> -->

    <!-- <script src="../js/d3.v3.min.js"> </script>
    <script src="../js/topojson.v1.min.js"> </script>
    <script src="../js/datamaps.all.min.js"> </script>
    <script src="../js/index-map.js"> </script>

    <script src="../js/chart.js"></script> -->

    <!-- Page Specific Scripts End -->

    <!-- Weedo core JavaScript -->
    <script src="../js/framework.js"></script>

    <!-- Settings -->
    <script src="../js/settings.js"></script>

</body>

</html>