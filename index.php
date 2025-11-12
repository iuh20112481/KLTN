<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ </title>
    <link rel="icon" href="img/logo.png" type="image/x-icon" sizes="16x16" type="image/png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/headers/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet"> 
    <script src="../assets/js/color-modes.js"></script>
    <style>
        .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
        }

        @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
        }

        .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
        }

        .bi {
        vertical-align: -.125em;
        fill: currentColor;
        }

        .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
        }

        .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
        --bd-violet-bg: #712cf9;
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;
        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet-bg);
        --bs-btn-border-color: var(--bd-violet-bg);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: #6528e0;
        --bs-btn-hover-border-color: #6528e0;
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: #5a23c8;
        --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
        z-index: 1500;
        }

        .bd-mode-toggle .dropdown-menu .active .bi {
        display: block !important;
        }
        .nav-link-black {
          color: black !important;
        }
        .relative-position {
          position: relative;
        }
        #result {
          position: absolute;
          top: 100%;
          left: 0;
          width: 100%;
          background: white;
          max-height: 200px;
          overflow-y: auto; 
          display: none; 
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
            .nav-link {
                font-family: 'SamsungSharpSans-Bold_SMCPS', Arial, sans-serif;
            }
            .link-hover:hover {
              color: #a2adff !important;
            }
            .form-control {
                font-family: 'Samsung One 400', Arial, sans-serif;
            }
            .dropdown-item {
                font-family: 'Samsung One 700', Arial, sans-serif;
            }
            .list-group-item {
                font-family: 'Samsung One 400', Arial, sans-serif;
            }
            a.nav-link.nav-link-black {
                padding: 10px 30px;
            }
        </style>
    <link href="../css/headers.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body class="index">
 <!-- header -->
  <main>
      <header class=" bg-white border-bottom fixed-top shadow p-2 mb-2 bg-body-tertiary rounded-bottom-4 ">
        <div class="container-fluid">

          <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="index.php" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
              <img src="img/logo.png" alt="logo" style="max-width: 75px;">

            </a>
            <ul class="nav col-lg-auto mx-auto justify-content-center mb-md-0">
              <li><a href="?page=aDBO" class="nav-link nav-link-black link-hover">TRANG CHỦ</a></li>

              <li><a href="?page=atkbc" class="nav-link nav-link-black link-hover">TÌM KIẾM BƯU CỤC</a></li>

              <li><a href="./view/u_baogia.php" class="nav-link nav-link-black link-hover" target="_blank">BÁO GIÁ</a></li>

              <li><a href="?page=atcg" class="nav-link nav-link-black link-hover">TRA CỨU GIÁ</a></li>

              <li><a href="#" class="nav-link nav-link-black link-hover">LIÊN HỆ</a></li>
            </ul>

            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3 relative-position" method="get" role="search">
              <input type="text" name="search" id="search" placeholder="Nhập mã vận đơn" class="form-control" />
              <ul class="list-group" id="result"></ul>
            </form>

            <div class="dropdown text-end">
              <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="img/avatar1.png" alt="mdo" width="32" height="32" class="rounded-circle">
              </a>
              <ul class="dropdown-menu text-small">
                <li><a class="dropdown-item" href="#" target="_blank">Tài khoản</a></li>
                <li><a class="dropdown-item" href="view/dangnhap.php" target="_blank">Đăng nhập</a></li>
                <li><a class="dropdown-item" href="view/dangky.php" target="_blank">Đăng ký</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="view/dangxuat.php">Đăng xuất</a></li>
              </ul>
            </div>
          </div>
        </div>
      </header>
  </main>

  <!-- content  -->
  <div class="contaner-fluid" style="margin-top:79px;">
        
        <?php 
          if (isset($_GET['page'])) {
            $page = $_GET['page'];
            switch ($page) {
                case 'atkbc':
                    include_once('view/u_timkiembuucuc.php');
                    break;
                case 'aDBB':
                    include_once('view/m_kiemTraDon.php');
                    break;
                case 'aBG':
                    include_once('view/baogia.php');
                    break;
                case 'atcg':
                    include_once('view/u_tracuugia.php');
                    break;

                default:
                    include('view/home.php');
            }
          }
          else{
            include('view/home.php');
          }
            ?>
    </div>

  <!-- footer -->
    <div class="">
        <?php
          include('view/footer.php');
        ?>
    </div>
    
<!-- SCRIPT BOOTSTRAP  -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- SCRIPT TÌM KIẾM  -->
<script>
  $(document).ready(function () {
      var searchTimeout;
      var delay = 300;

      $('#result').hide();
      $('#search').keyup(function () {
          clearTimeout(searchTimeout);

          var searchField = $(this).val().trim();
          $('#result').html('');

          if (searchField.length > 0) {
              searchTimeout = setTimeout(function () {
                  $('#result').show();

                  var expression = new RegExp(searchField, 'i');
                  $.getJSON('./API/connectAPI.php', { maVanDon: searchField }, function (data) {
                      $.each(data, function (key, value) {
                          if (value.maVanDon.search(expression) !== -1 || value.tenDonHang.search(expression) !== -1) {
                              $('#result').append('<li class="list-group-item text-center" data-mavandon="' + value.maVanDon + '">' + value.maVanDon + '</li>');
                          }
                      });
                  });
              }, delay);
          } else {
              $('#result').hide();
          }
      });

      // Lắng nghe sự kiện click và chuyển hướng dựa trên maVanDon
      $('#result').on('click', 'li', function () {
          var maVanDon = $(this).data('mavandon'); // Trích xuất maVanDon từ thuộc tính data
          window.location.href = 'chi_tiet_don_hang.php?maVanDon=' + maVanDon; // Chuyển hướng đến trang chi tiết đơn hàng
      });
  });
</script>


</body>
</html>