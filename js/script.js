$(document).ready(function() {
    let isProcessing = false; // Biến cờ để kiểm soát xử lý đồng thời

    // Đăng ký sự kiện cho các Selectpicker
    $('#lvl1, #lvl2, #lvl3, #lvl1_1, #lvl2_1, #lvl3_1').selectpicker();

    let oldLvl2Id = null;
    let oldLvl2_1Id = null;
    
    // Hàm để xử lý sự kiện thay đổi cấp 2
    function handleLevel2Change() {
        if (isProcessing) {
            return; // Nếu đang xử lý, không thực hiện thêm hành động
        }

        isProcessing = true; // Đánh dấu đang xử lý

        const lvl2_id = $("#lvl2").val();
        const lvl2_1_id = $("#lvl2_1").val();

        $("#district_code_display").val(lvl2_id);
        $("#district_code_display1").val(lvl2_1_id);

        const promises = [checkRegionComparison()]; // Kiểm tra so sánh vùng hành chính

    // Nếu giá trị mới khác với giá trị cũ, tải lại dữ liệu
    if (lvl2_id !== oldLvl2Id) {
        promises.push(loadLevel3Data(lvl2_id));
        oldLvl2Id = lvl2_id;
    }

    if (lvl2_1_id !== oldLvl2_1Id) {
        promises.push(loadLevel3Data1(lvl2_1_id));
        oldLvl2_1Id = lvl2_1_id;
    }

    Promise.all(promises)
    .then(() => {
        checkProvinceSimilarity(); // Gọi hàm checkProvinceSimilarity sau khi dữ liệu mới được tải
    })
    .finally(() => {
        isProcessing = false; // Hoàn thành xử lý
    });
    }   

    // Đăng ký sự kiện thay đổi cấp 2
    $(document).on("change", "#lvl2", handleLevel2Change);
    $(document).on("change", "#lvl2_1", handleLevel2Change);

    // Cập nhật giá trị khi người dùng nhập khối lượng
    $("#khoiluong").on("input", function() {
        var khoiluong = $(this).val();
        $("#khoiluong_copy").val(khoiluong); 
    });
    
    // Cập nhật giá trị khi tỉnh gửi thay đổi lvl1
    $(document).on("change", "#lvl1", function(e) {
        e.preventDefault();
        var lvl1_id = $(this).val();
        $("#province_code_display").val(lvl1_id);

        // Cập nhật các giá trị và kiểm tra tương đồng
        checkProvinceSimilarity(); 
        checkRegionComparison();

        $.ajax({
            url: "../control/c_quanhuyenxaphuong.php",
            type: "post",
            dataType: "json",
            data: { lvl1_id: lvl1_id },
            success: function(data) {
                var lvl2_body = "<option value='select'>Chọn quận/huyện</option>";
                for (var key in data) {
                    lvl2_body += "<option value=" + data[key]['code'] + ">" + data[key]['full_name'] + "</option>";
                }
                $("#lvl2").html(lvl2_body);
                $('#lvl2').selectpicker('refresh'); // Cập nhật Bootstrap Select
            }
        });
    });

    // Cập nhật giá trị khi tỉnh nhận thay đổi lvl1_1
    $(document).on("change", "#lvl1_1", function(e) {
        e.preventDefault();
        var lvl1_1_id = $(this).val();
        $("#province_code_display1").val(lvl1_1_id);

        // Cập nhật các giá trị và kiểm tra tương đồng
        checkProvinceSimilarity(); 
        checkRegionComparison();

        $.ajax({
            url: "../control/c_quanhuyenxaphuong.php",
            type: "post",
            dataType: "json",
            data: { lvl1_1_id: lvl1_1_id },
            success: function(data) {
                var lvl2_1_body = "<option value='select'>Chọn quận/huyện</option>";
                for (var key in data) {
                    lvl2_1_body += "<option value=" + data[key]['code'] + ">" + data[key]['full_name'] + "</option>";
                }
                $("#lvl2_1").html(lvl2_1_body); 
                $('#lvl2_1').selectpicker('refresh'); 
            }
        });
    });
    // Định nghĩa hàm `formatNumber`
        function formatNumber() {
            var input = document.getElementById("phithuho").value;

            if (input == null) {
                return ''; // Trả về chuỗi rỗng nếu không có giá trị
            }

            // Loại bỏ ký tự không phải số
            var formattedInput = input.replace(/[^\d]/g, '');

            // Định dạng với dấu chấm phân cách hàng nghìn
            formattedInput = formattedInput.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

            // Cập nhật lại vào `textarea`
            document.getElementById("phithuho").value = formattedInput;
        }

        // Đăng ký sự kiện `change` cho `#phithuho`
        $('#phithuho').change(formatNumber);

        // Sự kiện `change` cho `select` để cập nhật vào `input`
        $("#giaohang").on("change", function() {
            var selectedValue = $(this).val(); // Lấy giá trị đã chọn từ `select`
            $("#selected-shipping-method").val(selectedValue); // Cập nhật vào thẻ `input`
        });
    
        // Cập nhật giá trị khi người dùng nhập khối lượng
        $("#khoiluong").on("input", function() {
            var khoiluong = $(this).val();
            $("#khoiluong_copy").val(khoiluong); 
        });
});

// Hàm tải dữ liệu cấp 2 (quận/huyện)
function loadLevel3Data(lvl2_id) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "../control/c_quanhuyenxaphuong.php",
            type: "post",
            dataType: "json",
            data: { lvl2_id: lvl2_id },
            success: function(data) {
                var lvl3_body = "<option value='select'>Chọn xã/phường</option>";
                for (var key in data) {
                    lvl3_body += "<option value=" + data[key]['code'] + ">" + data[key]['full_name'] + "</option>";
                }
                $("#lvl3").html(lvl3_body); // Cập nhật danh sách xã/phường
                $('#lvl3').selectpicker('refresh'); 
                resolve(); // Hoàn thành xử lý
            },
            error: function(xhr, status, error) {
                reject(error);
            }
        });
    });
}

// Hàm tải dữ liệu cấp 2 (quận/huyện) cho cấp 2_1
function loadLevel3Data1(lvl2_1_id) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "../control/c_quanhuyenxaphuong.php",
            type: "post",
            dataType: "json",
            data: { lvl2_1_id: lvl2_1_id },
            success: function(data) {
                var lvl3_body = "<option value='select'>Chọn xã/phường</option>";
                for (var key in data) {
                    lvl3_body += "<option value=" + data[key]['code'] + ">" + data[key]['full_name'] + "</option>";
                }
                $("#lvl3_1").html(lvl3_body); 
                $('#lvl3_1').selectpicker('refresh'); 
                resolve(); 
            },
            error: function(xhr, status, error) {
                reject(error);
            }
        });
    });
}

// Hàm kiểm tra sự tương đồng về mã tỉnh và mã quận/huyện
function checkProvinceSimilarity() {
    var provinceCodeGiao = $("#province_code_display").val();
    var provinceCodeNhan = $("#province_code_display1").val();
    var districtCodeGiao = $("#district_code_display").val();
    var districtCodeNhan = $("#district_code_display1").val();

    if (provinceCodeGiao === provinceCodeNhan) {
        $("#province_comparison_result").val("True");
    } else {
        $("#province_comparison_result").val("False");
    }

    if (districtCodeGiao === districtCodeNhan) {
        $("#district_comparison_result").val("True");
    } else {
        $("#district_comparison_result").val("False"); 
    }
}

// Hàm kiểm tra sự tương đồng về mã vùng hành chính
function checkRegionComparison() {
    var provinceCodeGiao = $("#province_code_display").val();
    var provinceCodeNhan = $("#province_code_display1").val();

    if (!provinceCodeGiao || !provinceCodeNhan) {
        $("#region_comparison_result").val("Error");
        return;
    }

    Promise.all([
        getRegionIdByProvinceCode(provinceCodeGiao),
        getRegionIdByProvinceCode(provinceCodeNhan)
    ])
    .then(([regionIdGiao, regionIdNhan]) => {
        if (regionIdGiao === regionIdNhan) {
            $("#region_comparison_result").val("True");
        } else {
            $("#region_comparison_result").val("False");
        }
    })
    .catch((error) => {
        console.error("Lỗi trong checkRegionComparison:", error);
        $("#region_comparison_result").val("Error");
    });
}

// Hàm lấy mã vùng hành chính dựa trên mã tỉnh
function getRegionIdByProvinceCode(provinceCode) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "../control/cdiachi.php",
            type: "post",
            data: { code: provinceCode },
            dataType: "json",
            success: function(response) {
                if (response && response.administrative_region_id) {
                    resolve(response.administrative_region_id);
                } else {
                    reject("Không tìm thấy ID vùng hành chính");
                }
            },
            error: function(xhr, status, error) {
                console.error("Lỗi khi lấy mã vùng hành chính:", `Status: ${status}, Error: ${error}, Response: ${xhr.responseText}`);
                reject(error);
            }
        });
    });
}
