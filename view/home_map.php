<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Bưu Cục HPship</title>
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
<script src="https://cdn.jsdelivr.net/npm/@goongmaps/goong-js@1.0.9/dist/goong-js.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@goongmaps/goong-js@1.0.9/dist/goong-js.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../ccc/style.css">
<style>
    #map {
        width: 690px; /* Thiết lập chiều rộng của thẻ bản đồ */
        height: 500px; /* Thiết lập chiều cao của thẻ bản đồ */
        position: block; /* Đảm bảo thẻ bản đồ được hiển thị tương đối với phần tử cha */
    }    
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 400px;
        height: 100%;
        overflow-y : auto;
        padding-top: 5px;

    }
    .modal-content {
        position: absolute;
        background-color: #fefefe;
        margin: 76% auto;
        padding: 20px;
        width: 98%;
    }
    .close {
        color: #aaa;
        float: left;
        font-size: 28px;
        font-weight: bold;
    }
    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
    #address, #name, #time{
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        box-sizing: border-box;
        border: 2px solid #ccc;
        border-radius: 4px;
    }
    .goongjs-popup {
        max-width: 400px;
        font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
        
    }
</style>
</head>
<body>
     <card class="card" id="map"></card>
<!-- The Modal -->
    <div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form id="addressForm">
        <label for="address" id="p1-content">Tên Bưu Cục</label><br>
        <input type="text" id="name" name="name" readonly><br><br>
        <label for="address" id="p1-content">Địa chỉ</label><br>
        <input type="text" id="address" name="address" readonly><br><br>
        <label for="address" id="p1-content">Thời gian hoạt động</label><br>
        <input type="text" id="time" name="time" value="08h00 - 18h00 (Thứ Hai - Chủ Nhật)" readonly><br><br>
        </form>
    </div>
    </div>
<script>
    goongjs.accessToken = 'muEBaSeZzxFyFVgrl7VBUodebLIXjHgJXPOdTSZb';
    var map = new goongjs.Map({
        container: 'map',
        style: 'https://tiles.goong.io/assets/goong_map_web.json',
        center: [108.2021667, 16.047079],  // Center of Vietnam
        zoom: 4.5
    });

    map.on('load', function () {
        map.loadImage(
            'https://docs.goong.io/assets/custom_marker.png',
            function (error, image) {
                if (error) throw error;
                map.addImage('custom-marker', image);

                map.addSource('places', {
                    'type': 'geojson',
                    'data': {
                        'type': 'FeatureCollection',
                        'features': [
                            {
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Hà Nội'
                                    ,'address':'33 P. Hồ Đắc Di, Nam Đồng, Đống Đa, Hà Nội'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [105.8300735, 21.0116593]
                                }
                            },
                            {
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Đà Nẵng'
                                    ,'address':'18 An Dương Vương, Mỹ An, Ngũ Hành Sơn, Đà Nẵng'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [108.23531671300009, 16.049613693000026]
                                }
                            },
                            {
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Trường Sa Hồ Chí Minh'
                                    ,'address':'1046 Trường Sa, Phường 12, Quận 3, Hồ Chí Minh'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [106.67295982700006, 10.78752957000006]
                                }
                            },
                            {
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Nguyễn Kiệm Hồ Chí Minh'
                                    ,'address':'971 Nguyễn Kiệm, Phường 3, Gò Vấp, Hồ Chí Minh'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [106.67880763400007, 10.82262279300005]
                                }
                            },
                            {
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Nhất Chi Mai Hồ Chí Minh'
                                    ,'address':'4 Nhất Chi Mai, Phường 13, Tân Bình, Hồ Chí Minh'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [106.63991424000005, 10.802939988000048]
                                }
                            },
                            {
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Tam Phú Thủ Đức Hồ Chí Minh'
                                    ,'address':'38E Cây Keo, Tam Phú, Thủ Đức, Hồ Chí Minh'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [106.73932825500003, 10.86073224100005]
                                }
                            },
                            {
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Cố Giang Quận 1 Hồ Chí Minh'
                                    ,'address':'7 Hồ Hảo Hớn, Cô Giang, Quận 1, Hồ Chí Minh'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [106.69376031300004, 10.759978003000072]
                                }
                            },
                            // Add all other provinces and cities here
                            {
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục An Giang'
                                    ,'address':'16 Đỗ Nhuận, Mỹ Quý, Long Xuyên, An Giang'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [105.4465086, 10.3642975]
                                }
                            },
                            {
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Bà Rịa - Vũng Tàu'
                                    ,'address':'39 Tôn Đức Thắng, Phước Hiệp, Bà Rịa, Bà Rịa-Vũng Tàu'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [107.17505847600006, 10.494766198000036]
                                }
                            },
                            {
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Bắc Giang'
                                    ,'address':'100 Giáp Hải, Dĩnh Kế, Bắc Giang, Bắc Giang'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [106.21788253900007, 21.286791437000034]
                                }
                            },
                            {
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Bắc Kạn'
                                    ,'address':'59 Nguyễn Văn Thoát, Đức Xuân, Bắc Kạn, Bắc Kạn'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [105.83513569700006, 22.142392786000073]
                                }
                            },
                            {
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Bạc Liêu'
                                    ,'address':'17 Phùng Ngọc Liêm, Phường 2, Bạc Liêu'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [105.7244453, 9.2824272]
                                }
                            },
                            {
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Bắc Ninh'
                                    ,'address':'Đình Cả, Nội Duệ, Tiên Du, Bắc Ninh'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [106.00305957900008, 21.13550953300006]
                                }
                            },
                            {
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Quảng Trị'
                                    ,'address':'345 Lê Duẩn, Đông Lễ, Đông Hà, Quảng Trị'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [107.11261510700007, 16.813292661000048]
                                }
                            },
                            {
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Huế'
                                    ,'address':'74 Nguyễn Tất Thành, An Đông, Thành phố Huế, Thừa Thiên Huế'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [107.6048336, 16.4505621]
                                }
                            },
                            {
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Quảng Bình'
                                    ,'address':'129 Võ Nguyên Giáp, Quy Đạt, Minh Hóa, Quảng Bình'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [105.96750000000009, 17.81516700000003]
                                }
                            },
                            {
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Nghệ An'
                                    ,'address':'190 Nguyễn Sỹ Sách, Hưng Dũng, Vinh, Nghệ An'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [105.69701824600008, 18.68647647000006]
                                }
                            },
                            {
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Hà Tĩnh'
                                    ,'address':'193 Lý Tự Trọng, Thạch Hà, Thạch Hà, Hà Tĩnh'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [105.85769000000005, 18.372370000000046]
                                }
                            },
                            {
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Thanh Hóa'
                                    ,'address':'638 Phố Cống, Ngọc Lặc, Ngọc Lặc, Thanh Hóa'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [105.37841209100009, 20.082894244000045]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Quảng Nam'
                                    ,'address':'52 Phạm Văn Đồng, Khâm Đức, Phước Sơn, Quảng Nam'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [107.7933692, 15.4405906]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Quảng Ngãi'
                                    ,'address':'342 Nguyễn Công Phương, Nghĩa Lộ, Quảng Ngãi'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [108.7930599, 15.1121077]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Bình Định'
                                    ,'address':'206 Đống Đa, Thị Nại, Quy Nhơn, Bình Định'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [109.22584250000006, 13.78348333300005]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Phú Yên'
                                    ,'address':'96 Lê Lợi, Phường 3, Tuy Hòa, Phú Yên'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [109.30345742200006, 13.087885675000052]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Khánh Hòa'
                                    ,'address':'21 Lý Tự Trọng, Lộc Thọ, Nha Trang, Khánh Hòa'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [109.19172024300008, 12.247626841000056]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Ninh Thuận'
                                    ,'address':'1 Lương Văn Can, Phước Mỹ, Phan Rang-Tháp Chàm, Ninh Thuận'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [108.968606, 11.5862252]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Bình Thuận'
                                    ,'address':'158 Quốc Lộ 55, Đức Bình, Tánh Linh, Bình Thuận'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [107.73061480000007, 11.106944400000032]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Gia Lai'
                                    ,'address':'38 Phan Đình Phùng, Tây Sơn, Pleiku, Gia Lai'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [108.00361388900006, 13.984992500000033]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Đắk Lắk'
                                    ,'address':'27 Mười Tháng Ba, Cư Ê Bur, Thành phố Buôn Ma Thuột, Dak-Lak'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [108.0185756, 12.6867648]
                                    
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Đắk Nông'
                                    ,'address':'43 Thôn Đức Tân, Đắk Lao, Đắk Mil, Đắk Nông'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [107.6341816, 12.4561542]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Lâm Đồng'
                                    ,'address':'12 Tản Đà, Đam Bri, Bảo Lộc, Lâm Đồng'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [107.8063959, 11.5835822]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Bình Phước'
                                    ,'address':'893 Quốc Lộ 14, Tân Bình, Đồng Xoài, Bình Phước'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [106.87721661200004, 11.530129239000075]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Bến Tre'
                                    ,'address':'Quốc Lộ 60, Đa Phước Hội, Mỏ Cày Nam, Bến Tre'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [106.32628748095352, 10.114092594080915]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Cà Mau'
                                    ,'address':'67 Hải Thượng Lãn Ông, Phường 7, Cà Mau, Cà Mau'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [105.15439972200005, 9.170955556000024]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Cần Thơ'
                                    ,'address':'49 Đ.Lê Đức Thọ, Đông Hiệp, Cờ Đỏ, Cần Thơ'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [105.4982787, 10.0794294]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Đồng Tháp'
                                    ,'address':'157 Đường Nguyễn Văn Phát, Sa Đéc, Đồng Tháp'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [105.7600818, 10.3000018]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Hậu Giang'
                                    ,'address':'2C Châu Văn Liêm, Ngã Bảy, Ngã Bảy, Hậu Giang'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [105.82053800000006 ,9.815230529000075]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Kiên Giang'
                                    ,'address':'4 Trần Quang Khải, P. An Hoà, Rạch Giá, Kiên Giang'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [105.0974012, 9.9806976]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Long An'
                                    ,'address':'275a Đ. Phan Văn Mảng, TT. Bến Lức, Bến Lức, Long An'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [106.4855837, 10.6392824]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Sóc Trăng'
                                    ,'address':'33 Lê Duẩn, Phường 3, Sóc Trăng, Sóc Trăng'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [105.97146923200006, 9.594799082000065]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Mỹ Tho Tiền Giang'
                                    ,'address':'206A Đoàn Thị Nghiệp, Phường 5, Mỹ Tho, Tiền Giang'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [106.34265522800007, 10.36343683900003]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Trà Vinh'
                                    ,'address':'Bưu Cục Lò Hột TP Trà Vinh, Số 139 Lò Hột, Phường 5, Trà Vinh'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [106.3475017, 9.9376776]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Vĩnh Long'
                                    ,'address':'Phó Cơ Điều, Phường 3, Tp. Vĩnh Long, Vĩnh Long'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [105.9704519, 10.2339446]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Kon Tum'
                                    ,'address':'4 Đường Tuệ Tĩnh, Kon Tum, Kon Tum'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [107.993451, 14.3674843]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Bình Dương'
                                    ,'address':'8 30 Tháng 4, Phú Hòa, Thủ Dầu Một, Bình Dương'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [106.67192201800003, 10.98120553800004]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Đồng Nai'
                                    ,'address':'114 Nguyễn Huệ, TT. Tràng Bỏm, Trảng Bom, Đồng Nai'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [107.0062305, 10.9544318]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Tây Ninh'
                                    ,'address':'48 Đường 30 tháng 4, Phường 3, Tây Ninh'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [106.1043763, 11.2984845]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Hòa Bình'
                                    ,'address':'224 Phùng Hưng, Tân Hòa, Hòa Bình'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [105.3350215, 20.8419548]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Sơn La'
                                    ,'address':'286 Trần Đăng Ninh, Sơn La, Sơn La'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [103.927762, 21.3102041]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Điện Biên'
                                    ,'address':'bản Bó, Mường Phăng, Điện Biên Phủ, Điện Biên'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [103.0940375, 21.4126497]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Lai Châu'
                                    ,'address':'167 19 Tháng 8, Đoàn Kết, Lai Châu, Lai Châu'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [103.45465108800005, 22.39564271100005]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Phú Thọ'
                                    ,'address':'3499 ĐL Hùng Vương, Vân Phú, Thành phố Việt Trì, Phú Thọ'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [105.3563355, 21.3535664]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Hà Giang'
                                    ,'address':'102a Nguyễn Du, Nguyễn Trãi, Hà Giang'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [104.9833625, 22.8163208]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Tuyên Quang'
                                    ,'address':'54 Hồng Thái, P. Phan Thiết, Tuyên Quang'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [105.2025836, 21.8228393]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Cao Bằng'
                                    ,'address':'158 Quốc lộ 3 Cũ, Đề Thám, Cao Bằng'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [22.6831351, 106.2258091]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Thái Nguyên'
                                    ,'address':'430 Bắc Kạn, Hàng Văn Thụ, Thành phố Thái Nguyên, Thái Nguyên'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [105.8249535, 21.6012886]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Lạng Sơn'
                                    ,'address':'97 Đường 13 Tháng 10, Khu 1, Văn Lãng, Lạng Sơn'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [106.6119475, 22.0544711]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Quảng Ninh'
                                    ,'address':'Đường lên Mỏ, Mạo Khê, tx. Đông Triều, Quảng Ninh'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [106.6047185, 21.0804108]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Hà Nam'
                                    ,'address':'101 Lý Thái Tổ, Hoàng Hạnh, Lê Hồng Phong, Phủ Lý, Hà Nam'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [105.9047701, 20.5324839]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Hải Dương'
                                    ,'address':'120 An Định, Bình Hàn, Hải Dương, Hải Dương'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [106.32936866600005, 20.950968181000064]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Hải Phòng'
                                    ,'address':'130 Trần Văn Lan, Cát Bi, Hải An, Hải Phòng'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [106.70794990300004, 20.82742828800008]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Hưng Yên'
                                    ,'address':'11 Chu Mạnh Trinh, Hưng Yên, Hưng Yên'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [106.0623773, 20.657956]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Nam Định'
                                    ,'address':'23 Bùi Đình Hòe, Xóm 3, Tân An, Nam Định'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [106.1516724, 20.430464]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Thái Bình'
                                    ,'address':'2 Lý Thái Tổ, Kỳ Bá, Thái Bình'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [106.3488343, 20.4499601]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Vĩnh Phúc'
                                    ,'address':'168 Nguyễn Tất Thành, Liên Bảo, Vĩnh Yên, Vĩnh Phúc'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [105.60547722600006, 21.32353197900005]
                                }
                            },{
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Ninh Bình'
                                    ,'address':'111 Xuân Thành, Tân Thành, Ninh Bình, Ninh Bình'
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [105.96591311200007, 20.26047942100007]
                                }
                            },
                            {
                                'type': 'Feature',
                                'properties': {
                                    'description': 'Bưu cục Yên Bái'
                                    ,'address':'137 Tuệ Tĩnh, Mậu A, Văn Yên, Yên Bái'
                                    
                                },
                                'geometry': {
                                    'type': 'Point',
                                    'coordinates': [104.68414871900006, 21.880088278000073]
                                }
                            }
                        ]
                    }
                });

                map.addLayer({
                    'id': 'places',
                    'type': 'symbol',
                    'source': 'places',
                    'layout': {
                        'icon-image': 'custom-marker',
                        'icon-allow-overlap': true,
        
                        'icon-size': 0.6 // Adjust this value to control sizes
                    }
                });
            }
        );

        var popup = new goongjs.Popup({
            closeButton: false,
            closeOnClick: false
        });
        
        map.on('mouseenter', 'places', function (e) {
            map.getCanvas().style.cursor = 'pointer';

            var coordinates = e.features[0].geometry.coordinates.slice();
            var description = e.features[0].properties.description;

            while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
            }

            popup.setLngLat(coordinates).setHTML(description).addTo(map);
        });

        map.on('mouseleave', 'places', function () {
            map.getCanvas().style.cursor = '';
            popup.remove();
        });
        //Khi click thì hiện modal
        var modal = document.getElementById("myModal");
        var span = document.getElementsByClassName("close")[0];

        map.on('click', 'places', function (e) {
            var address = e.features[0].properties.address;
            var name = e.features[0].properties.description;
            document.getElementById("address").value = address;
            document.getElementById("name").value = name;
            modal.style.display = "block";
        });

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    
    });
</script>

</body>
</html>
