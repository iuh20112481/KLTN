<?php
    include("../control/cdangky.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $phone = $_POST["phone"];
        $mucdichsudung = $_POST["mucdichsudung"];
        $classification = $_POST["classification"];
        $quymovanchuyen = $_POST["quymovanchuyen"];
        $mail = $_POST["email"];
        $mk = $_POST["psw"];

        if ($quymovanchuyen == "duoi100") {
            $quymovanchuyen = "Dưới 100 đơn/tháng";
        } elseif ($quymovanchuyen == "tren100") {
            $quymovanchuyen = "Trên 100 đơn/tháng";
        } else {
            $quymovanchuyen = "Không thường xuyên";
        }

        $a = new control_dk();
        $kt = $a->getSdt($phone);

        if ($kt && mysqli_num_rows($kt) == 0) {
            $p = new control_dk();
            $kq = $p->addTK($name, $phone, $mk, $mail, $mucdichsudung, $classification, $quymovanchuyen);

            if ($kq == 1) {
                echo "<script>alert('Bạn đã đăng ký thành công')</script>";
                echo "<script>window.location.href='../view/dangNhap.php'</script>";
                exit();
            } else {
                echo "<script>alert('Đăng ký không thành công!')</script>";
            }
        } else {
            echo "<script>alert('Số điện thoại này đã được sử dụng!')</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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

        body {
            font-family: inherit;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-size: cover;
            background-position: center;
            overflow-x: hidden;

        }

        #h1 {
            font-family: 'SamsungSharpSans-Bold_SMCPS', Arial, sans-serif;

        }

        /* Các label sử dụng font Samsung One 700, Arial, và Sans-serif */
        label {
            font-family: 'Samsung One 700', Arial, sans-serif;
        }

        select,
        option,
        input,
        p {
            font-family: 'Samsung One 400', Arial, sans-serif;
        }

        .btn.btn-primary {
            border: none;
            background: #ff6339 !important;
            font-family: 'Samsung One 400', Arial, sans-serif;
        }

        .container {
            background-color: #F4DFC8;
            width: 800px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
        }

        .dropdown,
        .dropdown-quymo,
        .dropdown-nganhhang {
            position: relative;
            display: flex;
        }

        .arrow-container,
        .arrow-container-quymo,
        .arrow-container-nganhhang {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .select {
            padding: 8px;
            font-size: 16px;
            appearance: none;
            padding-right: 24px;
            /* Tăng giá trị padding để giữ khoảng trắng giữa nội dung và mũi tên */
            background: url('../img/arrow1.svg');
            /* Sử dụng ảnh mũi tên làm background */
            -webkit-appearance: none;
            /* Cho trình duyệt webkit (như Chrome, Safari) */
            -moz-appearance: none;
            /* Cho trình duyệt Firefox */
            appearance: none;
            border: none;
        }

        .arrow,
        .arrow-quymo,
        .arrow-nganhhang {
            width: 16px;
            height: 16px;
            transition: transform 0.3s ease;
        }
    </style>
</head>

<body>
    <div class="con text-center">
        <img src="../img/vechungtoi7.jpg" class="img-fluid" alt="..." style="width:630px; height: 500px;">
    </div>
    <div class="container ">

        <div class="row">
            <h1 id="h1">Đăng ký</h1>
            <br>
            <br>
            <div class="col-md-6">
            
                <form method="post" action="#">
                    <div class="mb-3">
                        <label for="option-uses">Mục đích sử dụng</label>
                        <div class="dropdown">
                            <select id="option-uses" name="mucdichsudung" class="form-control">
                                <option value="chon" selected disabled>Chọn</option>
                                <option value="Cá nhân">Cá nhân</option>
                                <option value="Doanh nghiệp">Doanh nghiệp</option>
                            </select>
                            <div class="arrow-container">
                                <img src="../img/arrow1.svg" alt="Arrow" class="arrow">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="name">Tên tài khoản</label>
                        <input type="text" placeholder="Họ và Tên" name="name" id="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="option-quymo">Quy mô vận chuyển</label>
                        <div class="dropdown-quymo">
                            <select id="option-quymo" name="quymovanchuyen" class="form-control">
                                <option value="chon" selected disabled>Chọn</option>
                                <option value="Không thường xuyên">Không thường xuyên</option>
                                <option value="Dưới 100 đơn/tháng">Dưới 100 đơn/tháng</option>
                                <option value="Trên 100 đơn/tháng">Trên 100 đơn/tháng</option>
                            </select>
                            <div class="arrow-container">
                                <img src="../img/arrow1.svg" alt="Arrow" class="arrow-quymo">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="phone">Số điện thoại</label>
                        <input type="tel" placeholder="Số điện thoại" name="phone" id="phone" class="form-control"
                            required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="psw">Mật khẩu</label>
                        <input type="password" placeholder="Mật khẩu" name="psw" id="psw" class="form-control"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="psw-repeat">Nhập lại mật khẩu</label>
                        <input type="password" placeholder="Nhập lại mật khẩu" name="psw-repeat" id="psw-repeat"
                            class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="text" placeholder="Nhập email" name="email" id="mail" class="form-control"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="option-nganhhang">Ngành hàng</label>
                        <div class="dropdown-nganhhang">
                            <select id="option-nganhhang" name="classification" class="form-control">
                                <option value="chon" selected disabled>Chọn</option>
                                <option value="Thời trang">Thời trang</option>
                                <option value="Thể thao & Dã ngoại">Thể thao & Dã ngoại</option>
                                <option value="Trang sức và phụ kiện thời trang">Trang sức và phụ kiện thời trang</option>
                                <option value="Phụ kiện điện thoại, laptop & điện tử ">Phụ kiện điện thoại, laptop & điện tử </option>
                                <option value="Tivi, thiết bị điện gia dụng">Tivi, thiết bị điện gia dụng</option>
                                <option value="Đồ gia dụng">Đồ gia dụng</option>
                                <option value="Hàng hóa dễ vỡ">Hàng hóa dễ vỡ</option>
                                <option value="Thực phẩm, nông sản, hải sản">Thực phẩm, nông sản, hải sản</option>
                                <option value="Sách & Văn phòng phẩm">Sách & Văn phòng phẩm</option>
                                <option value="Mỹ phẩm">Mỹ phẩm</option>
                                <option value="Điện thoại & thiết bị điện tử">Điện thoại & thiết bị điện tử</option>
                                <option value="Xe máy & Phương tiện giao thông">Xe máy & Phương tiện giao thông</option>
                                <option value="Cây cối">Cây cối</option>
                                <option value="Hàng tiêu dùng, tạp hóa">Hàng tiêu dùng, tạp hóa</option>
                                <option value="Khác">Khác</option>
                            </select>
                            <div class="arrow-container">
                                <img src="../img/arrow1.svg" alt="Arrow" class="arrow-nganhhang">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-column align-items-center" style="padding:19px;">
                    <button type="submit" name="btn_submit" class="btn btn-primary"
                        style="width:150px; height:50px;">Đăng ký</button>
            </form>
                <br>
                <p class="signin">Bạn đã có tài khoản chưa? <a href="../view/dangNhap.php">Đăng nhập</a></p>
            </div>
        </div>
    </div>



    <!-- SCRIPT CHO MỦI TÊN  -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dropdownUses = document.querySelector('.dropdown');
            const arrowUses = document.querySelector('.arrow');
            const selectUses = document.getElementById('option-uses');

            dropdownUses.addEventListener('click', function () {
                selectUses.focus();
            });

            selectUses.addEventListener('focus', function () {
                arrowUses.style.transform = 'rotate(180deg)';
            });

            selectUses.addEventListener('blur', function () {
                arrowUses.style.transform = 'rotate(0deg)';
            });

            selectUses.addEventListener('change', function () {
                arrowUses.style.transform = 'rotate(0deg)';
            });

            // Thêm script cho dropdown mới
            const dropdownAnother = document.querySelector('.dropdown-quymo');
            const arrowAnother = document.querySelector('.arrow-quymo');
            const selectAnother = document.getElementById('option-quymo');

            dropdownAnother.addEventListener('click', function () {
                selectAnother.focus();
            });

            selectAnother.addEventListener('focus', function () {
                arrowAnother.style.transform = 'rotate(180deg)';
            });

            selectAnother.addEventListener('blur', function () {
                arrowAnother.style.transform = 'rotate(0deg)';
            });

            selectAnother.addEventListener('change', function () {
                arrowAnother.style.transform = 'rotate(0deg)';
            });

            const dropdownnganhhang = document.querySelector('.dropdown-nganhhang');
            const arrownganhhang = document.querySelector('.arrow-nganhhang');
            const selectnganhhang = document.getElementById('option-nganhhang');

            dropdownnganhhang.addEventListener('click', function () {
                selectnganhhang.focus();
            });

            selectnganhhang.addEventListener('focus', function () {
                arrownganhhang.style.transform = 'rotate(180deg)';
            });

            selectnganhhang.addEventListener('blur', function () {
                arrownganhhang.style.transform = 'rotate(0deg)';
            });

            selectnganhhang.addEventListener('change', function () {
                arrownganhhang.style.transform = 'rotate(0deg)';
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
