<!-- <script>
    function checkDiscountCode() {
        // Thực hiện truy vấn AJAX để lấy phần trăm giảm giá từ bảng khuyenmai
        const discountCode = discountCodeInput.value;

        fetch('../API/API_KM.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ discountCode: discountCode })
        })
        .then(response => response.json())
        .then(data => {
            if (data.valid) {
                discountError.style.display = "none";
                discountSuccess.style.display = "block";
                // Thay thế phần trăm giảm giá từ kết quả truy vấn AJAX
                discountSuccess.textContent = `Mã giảm giá hợp lệ. Giảm giá ${data.discountPercent}%`;

                // Lưu giá trị phần trăm giảm giá vào input hidden
                document.getElementById("discountPercent").value = data.discountPercent;
                calculateShippingCost(); // Tính lại chi phí vận chuyển
            } else {
                discountError.style.display = "block";
                discountSuccess.style.display = "none";
                discountError.textContent = "Mã giảm giá không hợp lệ.";

                // Xóa giá trị phần trăm giảm giá
                document.getElementById("discountPercent").value = 0;
                calculateShippingCost(); // Tính lại chi phí vận chuyển
            }
        })
        .catch(error => {
            console.error('Error:', error);
            discountError.style.display = "block";
            discountSuccess.style.display = "none";
            discountError.textContent = "Có lỗi xảy ra. Vui lòng thử lại.";
        });
    }

</script> -->

<!--JS4-->
<!-- <script>
    $(document).ready(function() {
        // Hàm tính chi phí vận chuyển
        function tinhGiaVanChuyen(khoiluong, province_code_giao, province_code_nhan, district_code_giao, district_code_nhan, administrative_region_id_giao, administrative_region_id_nhan, shipping_method) {
            const giaBanDau = 5000; 
            const giaPhatSinh = 2500; 

            let tongGia = giaBanDau;

            // Tính phí phát sinh dựa trên khối lượng
            if (khoiluong > 0.5) {
                tongGia += Math.ceil((khoiluong - 0.5) / 0.5) * giaPhatSinh;
            }

            // Kiểm tra mã tỉnh
            if (province_code_giao !== province_code_nhan) {
                tongGia += 30000; 
            }

            // Kiểm tra quận/huyện
            if (district_code_giao !== district_code_nhan) {
                tongGia += 10000; 
            }

            // Kiểm tra vùng hành chính
            if (administrative_region_id_giao !== administrative_region_id_nhan) {
                tongGia += 20000; 
            }

            // Kiểm tra hình thức vận chuyển
            if (shipping_method === "GHN") {
                tongGia += 12000; 
            } else if (shipping_method === "GHTK") {
                tongGia += 4000; 
            }

            return tongGia;
        }

        // Hàm định dạng số với dấu phân cách hàng nghìn
        function formatWithThousandSeparator(number) {
            return new Intl.NumberFormat('en-GB', {
                style: 'decimal',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(number);
        }

        // Kiểm tra xem tất cả các giá trị cần thiết đã được nhập hay chưa
        function isReadyToCalculate() {
            const khoiluong = parseFloat($("#khoiluong_copy").val());
            const province_code_giao = $("#province_code_display").val();
            const province_code_nhan = $("#province_code_display1").val();
            const district_code_giao = $("#district_code_display").val();
            const district_code_nhan = $("#district_code_display1").val();
            const administrative_region_id_giao = $("#province_comparison_result").val();
            const administrative_region_id_nhan = $("#region_comparison_result").val();
            const shipping_method = $("#selected-shipping-method").val();
            const promotion_type = $("#promotion-type").val();

            // Kiểm tra tất cả các giá trị quan trọng đã có hay chưa
            return khoiluong > 0 && province_code_giao && province_code_nhan && district_code_giao && district_code_nhan && administrative_region_id_giao && administrative_region_id_nhan && shipping_method && promotion_type;
        }

        // Hàm kiểm tra xem ngày hiện tại có phải là ngày 15 của tháng hay không
        function isFifteenthDay() {
            const today = new Date();
            return today.getDate() === 18; //đổi ngày
        }
        function isOnethDay() {
            const today = new Date();
            return today.getDate() === 1;
        }

        // Hàm để lưu trạng thái đã sử dụng mã giảm giá trong session
        function setDiscountUsedToday() {
            const today = new Date();
            sessionStorage.setItem("discountUsedDate", today.getDate());
        }

        // Hàm để kiểm tra xem mã giảm giá đã được sử dụng trong ngày chưa
        function isDiscountUsedToday() {
            const today = new Date();
            const discountUsedDate = sessionStorage.getItem("discountUsedDate");
            return discountUsedDate && parseInt(discountUsedDate) === today.getDate();
        }

        // Hàm để tính giảm giá 10% nếu ngày là 15 và mã giảm giá chưa được sử dụng
        function applyDiscount(giaVanChuyen, promotionType) {
            if (promotionType === "khuyenmai" && isFifteenthDay() && !isDiscountUsedToday()) {
                setDiscountUsedToday();
            return giaVanChuyen * 0.9; // Giảm giá 10%
            }
            else if (promotionType === "khuyenmai2" && isOnethDay() && !isDiscountUsedToday()) {
                setDiscountUsedToday();
                return giaVanChuyen * 0.95; // Giảm giá 5%
            }
            else if (promotionType === "khuyenmai3" ) {
                alert("Mã chưa sử dụng được"); //Chưa đến hạn
                return giaVanChuyen;
            }
            else if (promotionType === "khuyenmai4" ) {
                alert("Mã chưa sử dụng được"); //Chưa đến hạn
                return giaVanChuyen;
            }
            else {
                return giaVanChuyen; // Không giảm giá
            }
        }

        // Hàm để tính chi phí vận chuyển và hiển thị
        function calculateShippingCost() {
            if (!isReadyToCalculate()) {
                $("#shipping-cost-hidden").val(""); 
                $("#shipping-cost-display").text(""); 
                return; 
            }

            const khoiluong = parseFloat($("#khoiluong_copy").val());
            const province_code_giao = $("#province_code_display").val();
            const province_code_nhan = $("#province_code_display1").val();
            const district_code_giao = $("#district_code_display").val();
            const district_code_nhan = $("#district_code_display1").val();
            const administrative_region_id_giao = $("#province_comparison_result").val();
            const administrative_region_id_nhan = $("#region_comparison_result").val();
            const shipping_method = $("#selected-shipping-method").val();
            const promotion_type = $("#promotion-type").val();

            const giaVanChuyen = tinhGiaVanChuyen(
                khoiluong,
                province_code_giao,
                province_code_nhan,
                district_code_giao,
                district_code_nhan,
                administrative_region_id_giao,
                administrative_region_id_nhan,
                shipping_method
            );

            const giaSauGiamGia = applyDiscount(giaVanChuyen, promotion_type);

            $("#shipping-cost-hidden").val(giaSauGiamGia); 
            const formattedShippingCost = formatWithThousandSeparator(giaSauGiamGia);
            $("#shipping-cost-display").html("<div style='font-size: 20px; color: blue;'>Tổng Thanh Toán :</div>" + formattedShippingCost + " VNĐ");
        }

        // Đăng ký sự kiện khi giá trị quan trọng thay đổi
        $("#khoiluong, #lvl1, #lvl1_1, #lvl2, #lvl2_1, #giaohang, #promotion-type").on("change", calculateShippingCost);

        // Đảm bảo tính chi phí trước khi gửi form
        $("#form-id").on("submit", function() {
            calculateShippingCost(); 
            return true; 
        });
    });
</script> -->

<!-- <script>
    $(document).ready(function() {
    // Hàm tính chi phí vận chuyển
    function tinhGiaVanChuyen(khoiluong, province_code_giao, province_code_nhan, district_code_giao, district_code_nhan, administrative_region_id_giao, administrative_region_id_nhan, shipping_method) {
        const giaBanDau = 5000; 
        const giaPhatSinh = 2500; 

        let tongGia = giaBanDau;

        // Tính phí phát sinh dựa trên khối lượng
        if (khoiluong > 0.5) {
            tongGia += Math.ceil((khoiluong - 0.5) / 0.5) * giaPhatSinh;
        }

        // Kiểm tra mã tỉnh
        if (province_code_giao !== province_code_nhan) {
            tongGia += 30000; 
        }

        // Kiểm tra quận/huyện
        if (district_code_giao !== district_code_nhan) {
            tongGia += 10000; 
        }

        // Kiểm tra vùng hành chính
        if (administrative_region_id_giao !== administrative_region_id_nhan) {
            tongGia += 20000; 
        }

        // Kiểm tra hình thức vận chuyển
        if (shipping_method === "GHN") {
            tongGia += 12000; 
        } else if (shipping_method === "GHTK") {
            tongGia += 4000; 
        }

        return tongGia;
    }

    // Hàm định dạng số với dấu phân cách hàng nghìn
    function formatWithThousandSeparator(number) {
        return new Intl.NumberFormat('en-GB', {
            style: 'decimal',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(number);
    }

    // Kiểm tra xem tất cả các giá trị cần thiết đã được nhập hay chưa
    function isReadyToCalculate() {
        const khoiluong = parseFloat($("#khoiluong_copy").val());
        const province_code_giao = $("#province_code_display").val();
        const province_code_nhan = $("#province_code_display1").val();
        const district_code_giao = $("#district_code_display").val();
        const district_code_nhan = $("#district_code_display1").val();
        const administrative_region_id_giao = $("#province_comparison_result").val();
        const administrative_region_id_nhan = $("#region_comparison_result").val();
        const shipping_method = $("#selected-shipping-method").val();
        const promotion_type = $("#promotion-type").val();

        // Kiểm tra tất cả các giá trị quan trọng đã có hay chưa
        return khoiluong > 0 && province_code_giao && province_code_nhan && district_code_giao && district_code_nhan && administrative_region_id_giao && administrative_region_id_nhan && shipping_method && promotion_type;
    }

    // Hàm kiểm tra xem ngày hiện tại có phải là ngày 15 của tháng hay không
    function isFifteenthDay() {
        const today = new Date();
        return today.getDate() === 18; // Đổi ngày
    }
    function isOnethDay() {
        const today = new Date();
        return today.getDate() === 1;
    }

    // Hàm để lưu trạng thái đã sử dụng mã giảm giá trong session
    function setDiscountUsedToday() {
        const today = new Date();
        sessionStorage.setItem("discountUsedDate", today.getDate());
    }

    // Hàm để kiểm tra xem mã giảm giá đã được sử dụng trong ngày chưa
    function isDiscountUsedToday() {
        const today = new Date();
        const discountUsedDate = sessionStorage.getItem("discountUsedDate");
        return discountUsedDate && parseInt(discountUsedDate) === today.getDate();
    }

    // Hàm để tính giảm giá 10% nếu ngày là 15 và mã giảm giá chưa được sử dụng
    function applyDiscount(giaVanChuyen, promotionType) {
        if (promotionType === "khuyenmai" && isFifteenthDay() && !isDiscountUsedToday()) {
            setDiscountUsedToday();
            return giaVanChuyen * 0.9; // Giảm giá 10%
        }
        else if (promotionType === "khuyenmai2" && isOnethDay() && !isDiscountUsedToday()) {
            setDiscountUsedToday();
            return giaVanChuyen * 0.95; // Giảm giá 5%
        }
        else if (promotionType === "khuyenmai3" ) {
            alert("Mã chưa sử dụng được"); //Chưa đến hạn
            return giaVanChuyen;
        }
        else if (promotionType === "khuyenmai4" ) {
            alert("Mã chưa sử dụng được"); //Chưa đến hạn
            return giaVanChuyen;
        }
        else {
            return giaVanChuyen; // Không giảm giá
        }
    }

    // Hàm để tính chi phí vận chuyển và hiển thị
    function calculateShippingCost() {
        if (!isReadyToCalculate()) {
            $("#shipping-cost-hidden").val(""); 
            $("#shipping-cost-display").text(""); 
            return; 
        }

        const khoiluong = parseFloat($("#khoiluong_copy").val());
        const province_code_giao = $("#province_code_display").val();
        const province_code_nhan = $("#province_code_display1").val();
        const district_code_giao = $("#district_code_display").val();
        const district_code_nhan = $("#district_code_display1").val();
        const administrative_region_id_giao = $("#province_comparison_result").val();
        const administrative_region_id_nhan = $("#region_comparison_result").val();
        const shipping_method = $("#selected-shipping-method").val();
        const promotion_type = $("#promotion-type").val();

        const giaVanChuyen = tinhGiaVanChuyen(
            khoiluong,
            province_code_giao,
            province_code_nhan,
            district_code_giao,
            district_code_nhan,
            administrative_region_id_giao,
            administrative_region_id_nhan,
            shipping_method
        );

        const giaSauGiamGia = applyDiscount(giaVanChuyen, promotion_type);

        $("#shipping-cost-hidden").val(giaSauGiamGia); 
        const formattedShippingCost = formatWithThousandSeparator(giaSauGiamGia);
        $("#shipping-cost-display").html("<div style ='font-size: 20px; color: blue;'>Tổng Thanh Toán :</div>" + formattedShippingCost + " VNĐ");
    }

    // Đăng ký sự kiện khi giá trị quan trọng thay đổi
    $("#khoiluong, #lvl1, #lvl1_1, #lvl2, #lvl2_1, #giaohang, #promotion-type").on("change", calculateShippingCost);

    // Đảm bảo tính chi phí trước khi gửi form và lưu session
    $("#form-id").on("submit", function() {
        sessionStorage.removeItem("promotion-type");
        calculateShippingCost(); 

        return true; 
    });
    });
</script>  -->

<!-- SCRIPT PHÂN CÁCH ĐỊA CHỈ -->
<script>
     document.addEventListener('DOMContentLoaded', (event) => {
        // Lấy giá trị của input
        let inputElement = document.getElementById('dcng');
        let fullAddress = inputElement.value;

        // Tách chuỗi tại dấu phẩy và lấy phần đầu tiên
        let firstPart = fullAddress.split(',')[0];

        // Gán giá trị mới vào input
        inputElement.value = firstPart;
    });
</script>