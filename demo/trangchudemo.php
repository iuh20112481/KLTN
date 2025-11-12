<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRANG CHỦ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="menubar">

    <!-- MENU -->
    <header class="menuex fixed-top">

        <div class="container-fluid ">

                <div class="d-flex align-items-end bg-body-tertiary" style="background-color: #fff !important;">

                        <div class="col d-flex justify-content-center">                
                            <div class="col-md-2">
                                <div class="logo-sn ms-d-block-lg">
                                    <a class="ml-0 text-left" href="index.php">
                                        <img src="./img/logo.png" alt="logo" style="max-width: 75px;">
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col menu-translate">
                            
                            <nav class="main-nav-menu">
                                    <div class=" menu-collapse" id="navbarNav">
                                        <ul class="menu-nav">
                                            <li class="menu-item"><a class="menu-link" href="#">Trang chủ</a></li>
                                            <li class="menu-item">
                                                <a class="menu-link" href="#">Dịch vụ</a>
                                                <ul>
                                                    <li><a href="?aTao">Giao hàng nhanh</a></li>
                                                    <li><a href="#">Báo giá</a></li>
                                                    <li><a href="#">Tầm nhìn</a></li>
                                                </ul>
                                            </li>
                                            <li class="menu-item">
                                                <a class="menu-link" href="#">Giới thiệu</a>
                                                <ul>
                                                    <li><a href="#">Điện thoại thông minh</a></li>
                                                    <li><a href="#">Máy tính xách tay</a></li>
                                                    <li><a href="#">Tivi</a></li>
                                                    <li><a href="#">Thiết bị gia dụng</a></li>
                                                </ul>
                                            </li>
                                            <li class="menu-item"><a class="menu-link" href="#">Liên hệ</a></li>
                                        </ul>
                                    </div>
                                                
                            </nav>

                            
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                            <form>
                                <div class="input-group">
                                    <input type="search" class="form-control rounded" oninput="showResult(this.value)" onblur="hideLiveSearch()" placeholder="Nhập mã vận đơn..." aria-label="Search" aria-describedby="search-addon" />
                                    <div id="livesearch" style="border-radius: 0 0 15px 15px;"></div>
                                </div>
                            </form>
                            </div>

                            <div class="col-md-6">
                                <div class="login cus-tippy">
                                        <!-- <a class="btn-login" href="#">LOGIN</a> -->
                                        <div id="avt-tippy" class="img-avt">
                                            <img src="./img/avatar.png" alt="avt">
                                        </div>
                                    <div id="usr-body">
                                        <div class="head-usr">
                                            <div class="avt-more">
                                                <img src="./img/avatar1.png" alt="avatar">
                                            </div>
                                            <p>USER</p>
                                        </div>
                                        <div class="sub-usr">
                                            <span class="ti-map-alt"></span>
                                            <p>Quản lý địa chỉ</p>
                                        </div>
                                        <div class="sub-usr">
                                            <span class="ti-settings"></span>
                                            <p>Cài đặt và hồ sơ cá nhân</p>
                                        </div>
                                        <div class="sub-usr">
                                            <span class="ti-help"></span>
                                            <p>Trợ giúp và hỗ trợ</p>
                                        </div>
                                        <div class="sub-usr">
                                            <span class="ti-comments"></span>
                                            <p>Đóng góp ý kiến</p>
                                        </div>
                                        <div class="sub-usr">
                                            <span class="ti-arrow-circle-right"></span>
                                            <p>Đăng xuất</p>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                </div>
                
        </div>

    </header>
    
    <div class="normalform mx-auto ">
                        <main class="themain" style="">

                            <section>
                                <article id="article">
                                    <img class="img-fluid" src="./img/vechungtoi7.jpg" alt="Ảnh mô tả" >
                                    <br>
                                    <br>
                                    <div class="s-title text-center">
                                        <h2>GIAO NHANH HƠN 6 TIẾNG</h2>
                                        <p id="p1">Nội dung bài viết</p>
                                    </div>
                                </article>
                            </section>

                            <section class="section section-slide-app">
                                <div class="container">
                                    <div class="row">
                                    <div class="col-md-5 col-sm-12 col-xs-12 d-flex align-items-justify">
                                            <p id="p1">Những năm gần đây, công nghệ được xem là yếu tố tạo sự bứt phá giúp các doanh nghiệp phát triển, cùng với sự hài lòng của người tiêu dùng sẽ là "đích đến" cho cuộc đua về dịch vụ giao nhận thời 4.0 này. Cùng với sự phát triển trong thời đại chuyển đổi số, thị trường thương mại điện tử trong nước phát triển thần tốc do các yếu tố như dân số trẻ, tỷ lệ sử dụng internet cao và tỷ lệ sử dụng điện thoại thông minh tăng, cuộc đua của các công ty giao hàng cũng ngày càng sôi nổi, chiến lược dịch vụ chăm khóc khách hàng và phát triển hệ sinh thái. 
                                                Các công ty giao hàng mang lại sự tiện lợi, linh hoạt và tiết kiệm thời gian khi người dùng có thể dễ dàng mua sắm trực tuyến và được giao nhận hàng tận nơi, không mất công di chuyển . Chúng hỗ trợ mạnh mẽ cho thương mại điện tử bằng cách tạo ra một hệ thống vận chuyển linh hoạt, giúp hàng hóa được vận chuyển an toàn đến tay khách hàng.
                                                Khả năng vận chuyển của các công ty giao hàng đáp ứng các nhu cầu đa dạng và phong phú của khách hàng gồm hàng tiêu dùng hàng ngày, hàng điện tử, thực phẩm,… 
                                            </p>
                                        </div>

                                        <div class="col-md-7 col-sm-12 col-xs-12">
                                            <div class="text-center">
                                                <img src="./img/vechungtoi4.webp" alt="" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>


                            <aside>
                                <article id="article">
                                    <h3>Tiêu đề nội dung bên cạnh 2</h3>
                                    <p id="p3">Nội dung bên cạnh 2</p>
                                </article>
                            </aside>
                    </main>
            </div>
    </div>  


    <!-- footer -->
    <footer class="footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-3">
                                <h4>GIỚI THIỆU</h4>
                                <ul>
                                    <li><a href="#">Về chúng tôi</a></li>
                                    <li><a href="#">Điều khoản sử dụng</a></li>
                                    <li><a href="#">Quy định vận chuyển</a></li>
                                    <li><a href="#">Bưu cục</a></li>

                                </ul>
                            </div>
                            <div class="col-md-3">
                                <h4>HỖ TRỢ</h4>
                                <ul>
                                    <li><a href="#">Hướng dẫn đặt hàng</a></li>
                                    <li><a href="./view/xemdonhang.php">Tra cứu đơn hàng</a></li>
                                    <li><a href="#">Chính sách bảo mật</a></li>
                                    <li><a href="#">Chính sách hoàn trả</a></li>

                                </ul>
                            </div>
                            <div class="col-md-3">
                                <h4>LIÊN HỆ</h4>
                                <ul>
                                    <li><a href="#">Trụ sở chính</a></li>
                                    <li><a href="#">Chi nhánh</a></li>
                                    <li><a href="#">Liên hệ với chúng tôi</a></li>
                                    <li><a href="#">Câu hỏi thường gặp</a></li>


                                </ul>
                            </div>
                            <div class="col-md-3">
                                <h4>KẾT NỐI CHÚNG TÔI</h4>
                                <ul class="social-icons">
                                    <li><a href="#"><i class="fab fa-facebook-f fa-2x"></i></a></li>
                                    
                                    <li><a href="#"><i class="fab fa-twitter fa-2x"></i></a></li>
                                    
                                    <li><a href="#"><i class="fab fa-instagram fa-2x"></i></a></li>
                                 
                                    <li><a href="#"><i class="fab fa-youtube fa-2x"></i></a></li>
                                </ul>
                            </div>  
                        </div>
                            <div class="col-md-12">
                                <h6 style="text-align: center; font-style: italic; color:blue; bottom: 10px;">Sinh viên thực hiện: Nguyễn Hồng Phong & Hồ Tất Đức Phú</h6>
                            </div>
                    </div>
                    
    </footer>

                    
            <!-- /footer -->
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
    


    <!-- SCRIPT TÌM KIẾM -->
    <script>
    function showResult(str) {
        if (str.length == 0) {
            document.getElementById("livesearch").innerHTML = "";
            document.getElementById("livesearch").style.border = "0px";
            return;
        }
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("livesearch").innerHTML = this.responseText;
                document.getElementById("livesearch").style.border = "1px solid #A5ACB2";
            }
        }
        xmlhttp.open("GET", "livesearch.php?q=" + str, true);
        xmlhttp.send();
    }

    function hideLiveSearch() {
        var livesearch = document.getElementById("livesearch");

        // Ẩn thanh livesearch khi người dùng rời khỏi ô nhập liệu
        livesearch.style.display = "none";
    }

    document.addEventListener("DOMContentLoaded", function () {
        var searchInput = document.querySelector('input[type="search"]');
        var livesearch = document.getElementById("livesearch");

        // Sự kiện xóa nội dung tìm kiếm và hiển thị livesearch khi nhập liệu
        searchInput.addEventListener("input", function () {
            var inputValue = searchInput.value.trim();

            if (inputValue.length > 0) {
                // Nếu có nội dung, hiển thị livesearch và cập nhật nội dung
                livesearch.style.display = "block";
                showResult(inputValue);
            } else {
                // Nếu không có nội dung, ẩn thanh livesearch
                livesearch.style.display = "none";
            }
        });
    });
</script>
    <!-- ACCOUNT -->
        <script>
            const $ = document.querySelector.bind(document);
            const $$ = document.querySelectorAll.bind(document);

            // show accoun information
            tippy('#avt-tippy', {
                content: $("#usr-body"),
                allowHTML: true,
                interactive: true,
                trigger: 'click', 
                placement: 'bottom',
            });
        </script>

</body>
</html>           



<!-- SCRIPT CỦA SELECT TỈNH THÀNH  -->
<!-- <script>
    $(document).ready(function() {
    $('#lvl1').selectpicker();
    $('#lvl2').selectpicker();
    $('#lvl3').selectpicker();
    $('#lvl1_1').selectpicker();
    $('#lvl2_1').selectpicker();
    $('#lvl3_1').selectpicker();
    
    function checkProvinceSimilarity() {
        var provinceCodeGiao = $("#province_code_display").val();
        var provinceCodeNhan = $("#province_code_display1").val();
        var districtCodeGiao = $("#district_code_display").val();
        var districtCodeNhan = $("#district_code_display1").val();
        
        // So sánh mã tỉnh
        if (provinceCodeGiao === provinceCodeNhan) {
            $("#province_comparison_result").val("True");
        } else {
            $("#province_comparison_result").val("False");
        }

        // So sánh mã quận/huyện
        if (districtCodeGiao === districtCodeNhan) {
            $("#district_comparison_result").val("True");
        } else {
            $("#district_comparison_result").val("False");
        }
    }

    // Cập nhật giá trị khi tỉnh gửi thay đổi
    $(document).on("change", "#lvl1", function(e) {
        e.preventDefault();
        var lvl1_id = $(this).val();
        $("#province_code_display").val(lvl1_id);

        checkProvinceSimilarity(); // Kiểm tra sự giống nhau khi giá trị thay đổi

        $.ajax({
            url: "quanhuyenxaphuong.php",
            type: "post",
            dataType: "json",
            data: { lvl1_id: lvl1_id },
            success: function(data) {
                var lvl2_body = "<option value='select'>Chọn quận</option>";
                for (var key in data) {
                    lvl2_body += "<option value=" + data[key]['code'] + ">" + data[key]['full_name'] + "</option>";
                }
                $("#lvl2").html(lvl2_body);
                $('#lvl2').selectpicker('refresh'); // Cập nhật Bootstrap Select
            }
        });
    });

    // Cập nhật giá trị khi tỉnh nhận thay đổi
    $(document).on("change", "#lvl1_1", function(e) {
        e.preventDefault();
        var lvl1_1_id = $(this).val();
        $("#province_code_display1").val(lvl1_1_id);

        checkProvinceSimilarity(); // Kiểm tra sự giống nhau khi giá trị thay đổi
        
        $.ajax({
            url: "quanhuyenxaphuong.php",
            type: "post",
            dataType: "json",
            data: { lvl1_1_id: lvl1_1_id },
            success: function(data) {
                var lvl2_1_body = "<option value='select'>Chọn quận</option>";
                for (var key in data) {
                    lvl2_1_body += "<option value=" + data[key]['code'] + ">" + data[key]['full_name'] + "</option>";
                }
                $("#lvl2_1").html(lvl2_1_body);
                $('#lvl2_1').selectpicker('refresh'); 
            }
        });
    });

    // Cập nhật giá trị khi quận/huyện gửi thay đổi
    $(document).on("change", "#lvl2", function(e) {
        e.preventDefault();
        var lvl2_id = $(this).val();
        $("#district_code_display").val(lvl2_id);

        checkProvinceSimilarity(); // Kiểm tra sự giống nhau khi giá trị thay đổi
    });

    // Cập nhật giá trị khi quận/huyện nhận thay đổi
    $(document).on("change", "#lvl2_1", function(e) {
        e.preventDefault();
        var lvl2_1_id = $(this).val();
        $("#district_code_display1").val(lvl2_1_id);

        checkProvinceSimilarity(); // Kiểm tra sự giống nhau khi giá trị thay đổi
    });

    // Cập nhật giá trị khi người dùng nhập khối lượng
    $("#khoiluong").on("input", function() {
        var khoiluong = $(this).val();
        $("#khoiluong_copy").val(khoiluong); 
    });
});
</script> -->

<!-- SCRIPT PHÂN CÁCH 3 SỐ  -->
<!-- <script>
        function formatNumber() {
            let input = document.getElementById("phithuho").value;
            let formattedInput = input.replace(/\D/g, '');
            formattedInput = formattedInput.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            document.getElementById("phithuho").value = formattedInput;
        }
</script> -->