<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Tính toán chi phí dự kiến</title>
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
<script src="https://cdn.jsdelivr.net/npm/@goongmaps/goong-js@1.0.9/dist/goong-js.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/@goongmaps/goong-js@1.0.9/dist/goong-js.css" rel="stylesheet" />
<link rel="stylesheet" href="../css/style.css">
<style>

    body { 
        margin: 0; 
        padding: 0; 
    }
    #map { 
        position: absolute; 
        top: 0; 
        bottom: 0; 
        width: 100%; 
    }
    .controls {
        position: absolute;
        top: 69px;
        left: 10px;
        z-index: 10;
        background: white;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }
    .input-container {
        margin-bottom: 10px;
    }
    .input-container label {
        display: block;
        font-weight: bold;
    }
    .input-container input, .input-container select {
        width: -webkit-fill-available;
        margin-top: 5px;
        box-sizing: border-box;
    }
    #calculate-btn {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: #ff7f00;
        color: white;
        border: none;
        border-radius: 9px;
        cursor: pointer;
    }
    #result, #shipping-cost-display {
        margin-top: 10px;
        font-size: 18px;
        font-weight: bold;
    }
    .suggestions {
        position: absolute;
        background: white;
        border: 1px solid #ccc;
        max-height: 150px;
        overflow-y: auto;
        z-index: 10;
    }
    .suggestion {
        padding: 10px;
        cursor: pointer;
    }
    .suggestion:hover {
        background-color: #f0f0f0;
    }
    label{
        font-family: 'Samsung One 700', Arial, sans-serif;
    input {
        font-family: 'Samsung One 400', Arial, sans-serif;
    }
    select {
        font-family: 'Samsung One 400', Arial, sans-serif;
    }

</style>
</head>
<body>

<div id="map"></div>
<div class="controls">
    <div style="background: turquoise; padding: 8px; border-radius: 7px;  margin-bottom:10px;">
        <t style="font-family: 'Samsung One 400', Arial, sans-serif; color:honeydew;">Lưu ý đây là chi phí dự kiến</t>
    </div>
    <div class="input-container">
        <label for="start">Địa chỉ gửi:</label>
        <input type="text" id=" " placeholder="Nhập địa điểm gửi" />
        <div id="start-suggestions" class="suggestions"></div>
    </div>
    <div class="input-container">
        <label for="end">Địa chỉ nhận:</label>
        <input type="text" id="end" placeholder="Nhập địa điểm nhận" />
        <div id="end-suggestions" class="suggestions"></div>
    </div>
    <div class="input-container">
        <label for="khoiluong_copy">Khối lượng (KG):</label>
        <input type="number" id="khoiluong_copy" ="Nhập khối lượng" />
    </div>
    <div class="input-container">
        <label for="province_code_display">Tỉnh Giao:</label>
        <input type="text" id="province_code_display" readonly />
    </div>
    <div class="input-container">
        <label for="province_code_display1">Tỉnh Nhận:</label>
        <input type="text" id="province_code_display1" readonly />
    </div>
    <div class="input-container" style="display:none;">
        <label for="district_code_display">Quận huyện Giao:</label>
        <input type="text" id="district_code_display" readonly />
    </div>
    <div class="input-container" style="display:none;">
        <label for="district_code_display1">Quận huyện Nhận:</label>
        <input type="text" id="district_code_display1" readonly />
    </div>
    <div class="input-container">
    <label for="selected-shipping-method">Hình thức vận chuyển:</label>
        <select id="selected-shipping-method" class="form-select" style="font-size: 16px;">
            <option value="default" selected disabled>Chọn hình thức vận chuyển</option>
            <option value="GHN">Giao hàng nhanh</option>
            <option value="GHTK">Giao hàng tiết kiệm</option>
        </select>
    </div>
    <button id="calculate-btn"><span style="font-family: 'SamsungSharpSans-Bold_SMCPS', Arial, sans-serif;">TÍNH CƯỚC VẬN CHUYỂN</span></button>
    <div id="result"></div>
    <div id="shipping-cost-display"></div>
</div>

<script>
    goongjs.accessToken = 'muEBaSeZzxFyFVgrl7VBUodebLIXjHgJXPOdTSZb';
    var map = new goongjs.Map({
        container: 'map',
        style: 'https://tiles.goong.io/assets/goong_map_web.json',
        center: [106.68669442400005, 10.822374274000026],
        zoom: 5
    });

    var startMarker = new goongjs.Marker({ color: 'green' });
    var endMarker = new goongjs.Marker({ color: 'red' });

    async function geocode(address) {
        const response = await fetch(`https://rsapi.goong.io/geocode?address=${encodeURIComponent(address)}&api_key=TM6Fhw2ehx9ouP7QF3EfoXUMPB2UGlecFKRyQi12`);
        const data = await response.json();
        if (data.results && data.results.length > 0) {
            return data.results;
        } else {
            throw new Error('Geocoding failed');
        }
    }

    async function getRoute(start, end) {
        const response = await fetch(`https://rsapi.goong.io/Direction?origin=${start[1]},${start[0]}&destination=${end[1]},${end[0]}&vehicle=car&api_key=TM6Fhw2ehx9ouP7QF3EfoXUMPB2UGlecFKRyQi12`);
        const data = await response.json();
        return data.routes[0].legs[0].distance.value; // distance in meters
    }

    function calculatePrice(distance) {
        const pricePerKm = 10000; // Example: 10,000 VND per km
        return (distance / 1000) * pricePerKm; // Convert meters to km
    }

    function tinhGiaVanChuyen(khoiluong, province_code_giao, province_code_nhan, district_code_giao, district_code_nhan, administrative_region_id_giao, administrative_region_id_nhan, shipping_method) {
        const giaBanDau = 5000; 
        const giaPhatSinh = 2500; 
        let tongGia = giaBanDau;

        if (khoiluong > 0.5) {
            tongGia += Math.ceil((khoiluong - 0.5) / 0.5) * giaPhatSinh;
        }

        if (province_code_giao !== province_code_nhan) {
            tongGia += 30000; 
        }

        if (district_code_giao !== district_code_nhan) {
            tongGia += 10000; 
        }

        if (administrative_region_id_giao !== administrative_region_id_nhan) {
            tongGia += 20000; 
        }

        if (shipping_method === "GHN") {
            tongGia += 12000; 
        } else if (shipping_method === "GHTK") {
            tongGia += 4000; 
        }

        return tongGia;
    }

    async function handleAddressInput(event, suggestionsContainerId) {
        const input = event.target.value;
        if (input.length > 2) {
            try {
                const results = await geocode(input);
                const suggestionsContainer = document.getElementById(suggestionsContainerId);
                suggestionsContainer.innerHTML = '';
                results.forEach(result => {
                    const suggestion = document.createElement('div');
                    suggestion.classList.add('suggestion');
                    suggestion.textContent = result.formatted_address;
                    suggestion.addEventListener('click', () => {
                        event.target.value = result.formatted_address;
                        suggestionsContainer.innerHTML = '';
                        updateMarker(event.target.id, result.geometry.location);
                    });
                    suggestionsContainer.appendChild(suggestion);
                });
            } catch (error) {
                console.error('Error fetching geocode:', error);
            }
        }
    }

    async function handleAddressSelection(inputId, provinceInputId, districtInputId) {
        const address = $(inputId).val();
        try {
            const results = await geocode(address);
            if (results.length > 0) {
                const location = results[0];
                const addressComponents = location.formatted_address.split(',');
                const province = addressComponents[addressComponents.length - 1].trim();
                const district = addressComponents[addressComponents.length - 2].trim();

                $(provinceInputId).val(province);
                $(districtInputId).val(district);
            }
        } catch (error) {
            console.error('Error fetching geocode:', error);
        }
    }

    function updateMarker(inputId, location) {
        if (inputId === 'start') {
            startMarker.setLngLat([location.lng, location.lat]).addTo(map);
            map.flyTo({ center: [location.lng, location.lat], zoom: 13 });
        } else if (inputId === 'end') {
            endMarker.setLngLat([location.lng, location.lat]).addTo(map);
            map.flyTo({ center: [location.lng, location.lat], zoom: 13 });
        }
    }

    $('#start').on('input', (event) => handleAddressInput(event, 'start-suggestions'));
    $('#end').on('input', (event) => handleAddressInput(event, 'end-suggestions'));

    $('#calculate-btn').on('click', async () => {
        const startAddress = $('#start').val();
        const endAddress = $('#end').val();

        try {
            await handleAddressSelection('#start', '#province_code_display', '#district_code_display');
            await handleAddressSelection('#end', '#province_code_display1', '#district_code_display1');

            const startResults = await geocode(startAddress);
            const endResults = await geocode(endAddress);

            if (startResults.length === 0 || endResults.length === 0) {
                alert('Failed to find locations for start or end addresses.');
                return;
            }

            const start = startResults[0].geometry.location;
            const end = endResults[0].geometry.location;

            updateMarker('start', start);
            updateMarker('end', end);

            const distance = await getRoute([start.lng, start.lat], [end.lng, end.lat]);
            const price = calculatePrice(distance);

            const khoiluong = parseFloat($("#khoiluong_copy").val());
            const province_code_giao = $("#province_code_display").val();
            const province_code_nhan = $("#province_code_display1").val();
            const district_code_giao = $("#district_code_display").val();
            const district_code_nhan = $("#district_code_display1").val();
            const administrative_region_id_giao = $("#province_comparison_result").val();
            const administrative_region_id_nhan = $("#region_comparison_result").val();
            const shipping_method = $("#selected-shipping-method").val();

            const shippingCost = tinhGiaVanChuyen(khoiluong, province_code_giao, province_code_nhan, district_code_giao, district_code_nhan, administrative_region_id_giao, administrative_region_id_nhan, shipping_method);
            
            //Tính số km
            $("#result").html(`<div style="color: blue; font-family: 'SamsungSharpSans-Bold_SMCPS', Arial, sans-serif; background-color: #cceeff;">Khoảng cách: ${(distance / 1000).toFixed(2)} km</div>`);
            $("#shipping-cost-display").html(`<div style="color: red; font-family: 'SamsungSharpSans-Bold_SMCPS', Arial, sans-serif; background-color: #ffc2b3;">Tổng phí dự kiến: ${shippingCost.toLocaleString('en-GB')} VND</div>`);

        } catch (error) {
            console.error('Error calculating route or shipping cost:', error);
        }
    });
</script>

</body>
</html>
