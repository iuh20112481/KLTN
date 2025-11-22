// ✅ ĐỢI Bootstrap Select load xong mới chạy
function initializeSelectPicker() {
    // Kiểm tra jQuery có tồn tại không
    if (typeof jQuery === 'undefined') {
        console.error('jQuery chưa load!');
        setTimeout(initializeSelectPicker, 100);
        return;
    }

    // Kiểm tra Bootstrap Select có tồn tại không
    if (typeof $.fn.selectpicker === 'undefined') {
        console.log('Đang đợi Bootstrap Select load...');
        setTimeout(initializeSelectPicker, 100);
        return;
    }

    // ✅ Tất cả thư viện đã sẵn sàng! Chạy code ngay lập tức
    console.log('✅ Tất cả thư viện đã sẵn sàng! Khởi tạo event handlers...');

    // === BẮT ĐẦU CODE THỰC THI ===
    // NOTE: Không init selectpicker ở đây - mỗi page tự init trong inline script
    let isProcessing = false;

    let oldLvl2Id = null;
    let oldLvl2_1Id = null;
    
    // Hàm xử lý sự kiện thay đổi cấp 2
    function handleLevel2Change() {
        if (isProcessing) {
            return;
        }

        isProcessing = true;

        const lvl2_id = $("#lvl2").val();
        const lvl2_1_id = $("#lvl2_1").val();

        $("#district_code_display").val(lvl2_id);
        $("#district_code_display1").val(lvl2_1_id);

        const promises = [checkRegionComparison()];

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
            checkProvinceSimilarity();
        })
        .finally(() => {
            isProcessing = false;
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
                $('#lvl2').selectpicker('refresh'); // <- Đã có, rất tốt!
                
                // Reset lvl3
                $("#lvl3").html("<option value='select'>Chọn xã/phường</option>");
                $('#lvl3').selectpicker('refresh');
            }
        });
    });

    // Cập nhật giá trị khi tỉnh nhận thay đổi lvl1_1
    $(document).on("change", "#lvl1_1", function(e) {
        e.preventDefault();
        var lvl1_1_id = $(this).val();
        $("#province_code_display1").val(lvl1_1_id);

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
                $('#lvl2_1').selectpicker('refresh'); // <- Đã có, rất tốt!

                // Reset lvl3_1
                $("#lvl3_1").html("<option value='select'>Chọn xã/phường</option>");
                $('#lvl3_1').selectpicker('refresh');
            }
        });
    });

    // Định nghĩa hàm formatNumber (Lưu ý: phithuho là checkbox, code này có thể không dùng)
    function formatNumber() {
        var input = document.getElementById("phithuho").value;

        if (input == null) {
            return '';
        }

        var formattedInput = input.replace(/[^\d]/g, '');
        formattedInput = formattedInput.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        document.getElementById("phithuho").value = formattedInput;
    }

    $('#phithuho').change(formatNumber);

    // Lưu ý: ID "giaohang" có thể không tồn tại, file PHP dùng "selected-shipping-method"
    $("#giaohang").on("change", function() {
        var selectedValue = $(this).val();
        $("#selected-shipping-method").val(selectedValue);
    });
    
    // === KẾT THÚC CODE THỰC THI ===
}

// Hàm tải dữ liệu cấp 3 (phường/xã)
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
                $("#lvl3").html(lvl3_body);
                $('#lvl3').selectpicker('refresh'); // <- Đã có
                resolve();
            },
            error: function(xhr, status, error) {
                reject(error);
            }
        });
    });
}

// Hàm tải dữ liệu cấp 3 (phường/xã) cho cấp 2_1
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
                $('#lvl3_1').selectpicker('refresh'); // <- Đã có
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

// ✅ Bắt đầu khởi tạo khi DOM ready
$(document).ready(function() {
    initializeSelectPicker();
});