<?php
session_start();

// Kiểm tra đăng nhập shipper
if (!isset($_SESSION["nvgh"]['id_user'])) {
    header("Location: dangNhapNhanSu.php");
    exit();
}

$idTaiKhoan = $_SESSION["nvgh"]['id_user'];
include_once("../control/cdonhang.php");
$p = new control_donhang();

// Lấy mã nhân viên giao hàng
$maNhanVienResult = $p->getmaNhanVienbyidTaiKhoan($idTaiKhoan);
if ($maNhanVienResult && mysqli_num_rows($maNhanVienResult) > 0) {
    $maNhanVienAssoc = mysqli_fetch_assoc($maNhanVienResult);
    $maNhanVien = $maNhanVienAssoc['maNhanVien'];
} else {
    echo "<script>alert('Không tìm thấy thông tin nhân viên!');</script>";
    exit();
}

// Lấy danh sách đơn hàng đang giao
include_once("../model/connect1.php");
$db = new connect_db();
$conn = $db->open_kn();

$query = "SELECT
            donhang.Id_DonHang,
            donhang.maVanDon,
            taodonhang.tenNN,
            taodonhang.sdtNN,
            taodonhang.diaChiNhan,
            taodonhang.phuongXaNhan,
            taodonhang.quanHuyenNhan,
            taodonhang.tinhNhan
          FROM donhang
          INNER JOIN taodonhang ON donhang.Id_TaoDonHang = taodonhang.Id_TaoDonHang
          WHERE donhang.maNhanVien = ?
          AND donhang.trangThaiDonHang = 'Đang giao'";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $maNhanVien);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$orders = [];
while ($row = mysqli_fetch_assoc($result)) {
    $full_address = $row['diaChiNhan'] . ', ' . $row['phuongXaNhan'] . ', ' . $row['quanHuyenNhan'] . ', ' . $row['tinhNhan'];
    $orders[] = [
        'maVanDon' => $row['maVanDon'],
        'tenNguoiNhan' => $row['tenNN'],
        'sdtNguoiNhan' => $row['sdtNN'],
        'full_address' => $full_address
    ];
}

mysqli_stmt_close($stmt);
$db->close_kn($conn);

$ordersJson = json_encode($orders, JSON_UNESCAPED_UNICODE);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lộ Trình Giao Hàng - HPSHIP</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Goong Maps -->
    <script src="https://cdn.jsdelivr.net/npm/@goongmaps/goong-js@1.0.9/dist/goong-js.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/@goongmaps/goong-js@1.0.9/dist/goong-js.css" rel="stylesheet" />

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .main-container {
            display: flex;
            height: 100vh;
        }

        /* Phần bản đồ */
        #map {
            flex: 1;
            height: 100%;
        }

        /* Phần danh sách đơn hàng */
        .order-panel {
            width: 400px;
            height: 100%;
            overflow-y: auto;
            background: #f8f9fa;
            border-left: 2px solid #dee2e6;
        }

        .panel-header {
            background: #24d5cf;
            color: white;
            padding: 15px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .panel-header h5 {
            margin: 0;
            font-weight: 600;
        }

        .order-list {
            padding: 10px;
        }

        .order-card {
            background: white;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: all 0.3s ease;
            border-left: 4px solid #24d5cf;
        }

        .order-card:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }

        .order-card.active {
            border-left-color: #ff6200;
            background: #fff5f0;
        }

        .order-number {
            display: inline-block;
            background: #24d5cf;
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            text-align: center;
            line-height: 24px;
            font-size: 12px;
            font-weight: bold;
            margin-right: 8px;
        }

        .order-mavandon {
            font-weight: 600;
            color: #333;
        }

        .order-info {
            margin-top: 8px;
            font-size: 13px;
            color: #666;
        }

        .order-info i {
            width: 20px;
            color: #24d5cf;
        }

        .order-address {
            font-size: 12px;
            color: #888;
            margin-top: 5px;
            line-height: 1.4;
        }

        /* Loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.9);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-overlay.hidden {
            display: none;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #24d5cf;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-text {
            margin-top: 15px;
            color: #666;
            font-size: 14px;
        }

        /* Route info */
        .route-info {
            background: white;
            padding: 10px 15px;
            border-bottom: 1px solid #dee2e6;
        }

        .route-info span {
            font-size: 13px;
            color: #666;
        }

        .route-info strong {
            color: #24d5cf;
        }

        /* Popup styling */
        .goongjs-popup {
            max-width: 250px;
        }

        .goongjs-popup-content {
            padding: 10px;
            font-family: 'Segoe UI', sans-serif;
        }

        .popup-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .popup-info {
            font-size: 12px;
            color: #666;
            margin: 3px 0;
        }

        /* Back button */
        .back-btn {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 1000;
            background: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
            cursor: pointer;
        }

        .back-btn:hover {
            background: #f0f0f0;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #888;
        }

        .empty-state i {
            font-size: 48px;
            color: #ddd;
            margin-bottom: 15px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
            }

            #map {
                height: 60vh;
            }

            .order-panel {
                width: 100%;
                height: 40vh;
            }
        }
    </style>
</head>
<body>
    <!-- Loading overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
        <div class="loading-text">Đang tải lộ trình giao hàng...</div>
    </div>

    <div class="main-container">
        <!-- Bản đồ -->
        <div id="map">
            <button class="back-btn" onclick="window.history.back()">
                <i class="bi bi-arrow-left"></i> Quay lại
            </button>
        </div>

        <!-- Danh sách đơn hàng -->
        <div class="order-panel">
            <div class="panel-header">
                <h5><i class="bi bi-geo-alt-fill"></i> Lộ Trình Giao Hàng</h5>
            </div>

            <div class="route-info" id="routeInfo">
                <span>Tổng: <strong id="totalOrders">0</strong> đơn hàng</span>
                <span class="ms-3">Khoảng cách: <strong id="totalDistance">--</strong></span>
                <span class="ms-3">Thời gian: <strong id="totalDuration">--</strong></span>
            </div>

            <div class="order-list" id="orderList">
                <?php if (empty($orders)): ?>
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <p>Không có đơn hàng đang giao</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($orders as $index => $order): ?>
                        <div class="order-card" data-index="<?php echo $index; ?>" onclick="focusOnMarker(<?php echo $index; ?>)">
                            <div>
                                <span class="order-number"><?php echo $index + 1; ?></span>
                                <span class="order-mavandon"><?php echo htmlspecialchars($order['maVanDon']); ?></span>
                            </div>
                            <div class="order-info">
                                <div><i class="bi bi-person"></i> <?php echo htmlspecialchars($order['tenNguoiNhan']); ?></div>
                                <div><i class="bi bi-telephone"></i> <?php echo htmlspecialchars($order['sdtNguoiNhan']); ?></div>
                            </div>
                            <div class="order-address">
                                <i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($order['full_address']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // API Keys
        const GOONG_MAP_KEY = 'muEBaSeZzxFyFVgrl7VBUodebLIXjHgJXPOdTSZb';
        const GOONG_API_KEY = 'TM6Fhw2ehx9ouP7QF3EfoXUMPB2UGlecFKRyQi12';

        // Dữ liệu đơn hàng từ PHP
        const orders = <?php echo $ordersJson; ?>;

        // Biến global
        let map;
        let markers = [];
        let shipperLocation = null;
        let routeLayer = null;

        // Khởi tạo bản đồ
        goongjs.accessToken = GOONG_MAP_KEY;
        map = new goongjs.Map({
            container: 'map',
            style: 'https://tiles.goong.io/assets/goong_map_web.json',
            center: [106.6297, 10.8231], // Mặc định HCM
            zoom: 12
        });

        // Khi bản đồ load xong
        map.on('load', async function() {
            if (orders.length === 0) {
                hideLoading();
                return;
            }

            // Bước 1: Lấy vị trí shipper
            await getShipperLocation();

            // Bước 2: Geocoding các địa chỉ
            await geocodeAllAddresses();

            // Bước 3: Tạo markers cho tất cả đơn hàng
            createAllMarkers();

            // Cập nhật UI
            document.getElementById('totalOrders').textContent = orders.length;

            hideLoading();
        });

        // Tạo tất cả markers (không vẽ route)
        function createAllMarkers() {
            const bounds = new goongjs.LngLatBounds();
            if (shipperLocation) bounds.extend(shipperLocation);

            for (let i = 0; i < orders.length; i++) {
                const order = orders[i];
                if (!order.coordinates) continue;

                bounds.extend(order.coordinates);

                // Tạo marker
                const el = document.createElement('div');
                el.className = 'marker';
                el.style.cssText = `
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    color: white;
                    width: 38px;
                    height: 38px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-weight: bold;
                    font-size: 16px;
                    border: 4px solid white;
                    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.5);
                    cursor: pointer;
                `;
                el.textContent = i + 1;

                const popupContent = `
                    <div class="goongjs-popup-content">
                        <div class="popup-title">${order.tenNguoiNhan}</div>
                        <div class="popup-info"><strong>MVĐ:</strong> ${order.maVanDon}</div>
                        <div class="popup-info"><strong>SĐT:</strong> ${order.sdtNguoiNhan}</div>
                        <div class="popup-info"><strong>Địa chỉ:</strong> ${order.full_address}</div>
                    </div>
                `;

                const marker = new goongjs.Marker({ element: el })
                    .setLngLat(order.coordinates)
                    .setPopup(new goongjs.Popup({ offset: 25 }).setHTML(popupContent))
                    .addTo(map);

                markers.push(marker);
            }

            if (!bounds.isEmpty()) {
                map.fitBounds(bounds, { padding: 50 });
            }
        }

        // Tính khoảng cách giữa 2 điểm (Haversine formula)
        function calculateDistance(coord1, coord2) {
            const R = 6371; // Bán kính Trái Đất (km)
            const dLat = (coord2[1] - coord1[1]) * Math.PI / 180;
            const dLon = (coord2[0] - coord1[0]) * Math.PI / 180;
            const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                      Math.cos(coord1[1] * Math.PI / 180) * Math.cos(coord2[1] * Math.PI / 180) *
                      Math.sin(dLon/2) * Math.sin(dLon/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            return R * c;
        }

        // Thuật toán Nearest Neighbor để tối ưu thứ tự
        function optimizeDeliveryOrder() {
            const validOrders = orders.filter(o => o.coordinates);
            if (validOrders.length <= 1 || !shipperLocation) return;

            const optimizedOrder = [];
            const remaining = [...validOrders];
            let currentPos = shipperLocation;

            console.log('Bắt đầu tối ưu lộ trình...');
            console.log('Thứ tự ban đầu:', orders.map(o => o.maVanDon));

            while (remaining.length > 0) {
                let nearestIndex = 0;
                let nearestDistance = Infinity;

                // Tìm điểm gần nhất
                for (let i = 0; i < remaining.length; i++) {
                    const dist = calculateDistance(currentPos, remaining[i].coordinates);
                    if (dist < nearestDistance) {
                        nearestDistance = dist;
                        nearestIndex = i;
                    }
                }

                // Thêm điểm gần nhất vào danh sách tối ưu
                const nearest = remaining.splice(nearestIndex, 1)[0];
                optimizedOrder.push(nearest);
                currentPos = nearest.coordinates;
            }

            // Cập nhật lại mảng orders với thứ tự tối ưu
            // Giữ lại các order không có tọa độ ở cuối
            const invalidOrders = orders.filter(o => !o.coordinates);
            orders.length = 0;
            orders.push(...optimizedOrder, ...invalidOrders);

            console.log('Thứ tự sau tối ưu:', orders.map(o => o.maVanDon));
        }

        // Cập nhật lại markers theo thứ tự mới
        function updateMarkersOrder() {
            // Xóa tất cả markers cũ
            markers.forEach(m => m.remove());
            markers = [];

            const bounds = new goongjs.LngLatBounds();
            if (shipperLocation) bounds.extend(shipperLocation);

            for (let i = 0; i < orders.length; i++) {
                const order = orders[i];
                if (!order.coordinates) continue;

                bounds.extend(order.coordinates);

                // Tạo marker mới với số thứ tự đã tối ưu
                const el = document.createElement('div');
                el.className = 'marker';
                el.style.cssText = `
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    color: white;
                    width: 38px;
                    height: 38px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-weight: bold;
                    font-size: 16px;
                    border: 4px solid white;
                    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.5);
                    cursor: pointer;
                `;
                el.textContent = i + 1;

                const popupContent = `
                    <div class="goongjs-popup-content">
                        <div class="popup-title">${order.tenNguoiNhan}</div>
                        <div class="popup-info"><strong>Thứ tự:</strong> ${i + 1}</div>
                        <div class="popup-info"><strong>MVĐ:</strong> ${order.maVanDon}</div>
                        <div class="popup-info"><strong>SĐT:</strong> ${order.sdtNguoiNhan}</div>
                        <div class="popup-info"><strong>Địa chỉ:</strong> ${order.full_address}</div>
                    </div>
                `;

                const marker = new goongjs.Marker({ element: el })
                    .setLngLat(order.coordinates)
                    .setPopup(new goongjs.Popup({ offset: 25 }).setHTML(popupContent))
                    .addTo(map);

                markers.push(marker);
            }

            if (!bounds.isEmpty()) {
                map.fitBounds(bounds, { padding: 50 });
            }
        }

        // Cập nhật danh sách đơn hàng bên phải
        function updateOrderList() {
            const orderListEl = document.getElementById('orderList');
            if (!orderListEl || orders.length === 0) return;

            let html = '';
            orders.forEach((order, index) => {
                html += `
                    <div class="order-card" data-index="${index}" onclick="focusOnMarker(${index})">
                        <div>
                            <span class="order-number">${index + 1}</span>
                            <span class="order-mavandon">${order.maVanDon}</span>
                        </div>
                        <div class="order-info">
                            <div><i class="bi bi-person"></i> ${order.tenNguoiNhan}</div>
                            <div><i class="bi bi-telephone"></i> ${order.sdtNguoiNhan}</div>
                        </div>
                        <div class="order-address">
                            <i class="bi bi-geo-alt"></i> ${order.full_address}
                        </div>
                    </div>
                `;
            });

            orderListEl.innerHTML = html;
        }

        // Lấy vị trí hiện tại của shipper
        function getShipperLocation() {
            return new Promise((resolve) => {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            shipperLocation = [position.coords.longitude, position.coords.latitude];
                            console.log('Vị trí shipper:', shipperLocation);

                            // Thêm marker cho shipper - nổi bật hơn
                            const shipperEl = document.createElement('div');
                            shipperEl.innerHTML = '<i class="bi bi-geo-alt-fill"></i>';
                            shipperEl.style.cssText = `
                                font-size: 36px;
                                color: #e74c3c;
                                filter: drop-shadow(0 3px 6px rgba(0,0,0,0.4));
                            `;
                            const shipperMarker = new goongjs.Marker({ element: shipperEl })
                                .setLngLat(shipperLocation)
                                .setPopup(new goongjs.Popup().setHTML('<div class="popup-title"><strong>📍 Vị trí của bạn</strong></div>'))
                                .addTo(map);

                            resolve();
                        },
                        (error) => {
                            console.warn('Không thể lấy vị trí:', error);
                            alert('Không thể lấy vị trí của bạn. Vui lòng cho phép truy cập vị trí và tải lại trang.');
                            // Dùng vị trí mặc định (HCM)
                            shipperLocation = [106.6297, 10.8231];

                            // Vẫn thêm marker mặc định
                            const shipperEl = document.createElement('div');
                            shipperEl.innerHTML = '<i class="bi bi-geo-alt-fill"></i>';
                            shipperEl.style.cssText = `
                                font-size: 36px;
                                color: #e74c3c;
                                filter: drop-shadow(0 3px 6px rgba(0,0,0,0.4));
                            `;
                            const shipperMarker = new goongjs.Marker({ element: shipperEl })
                                .setLngLat(shipperLocation)
                                .setPopup(new goongjs.Popup().setHTML('<div class="popup-title"><strong>📍 Vị trí mặc định</strong></div>'))
                                .addTo(map);

                            resolve();
                        },
                        { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
                    );
                } else {
                    alert('Trình duyệt không hỗ trợ Geolocation');
                    shipperLocation = [106.6297, 10.8231];
                    resolve();
                }
            });
        }

        // Geocoding địa chỉ
        async function geocodeAddress(address) {
            try {
                const response = await fetch(
                    `https://rsapi.goong.io/Geocode?address=${encodeURIComponent(address)}&api_key=${GOONG_API_KEY}`
                );
                const data = await response.json();

                if (data.results && data.results.length > 0) {
                    const location = data.results[0].geometry.location;
                    return [location.lng, location.lat];
                }
                return null;
            } catch (error) {
                console.error('Geocoding error:', error);
                return null;
            }
        }

        // Geocoding tất cả địa chỉ (chỉ lấy tọa độ, không tạo marker)
        async function geocodeAllAddresses() {
            for (let i = 0; i < orders.length; i++) {
                const order = orders[i];
                const coords = await geocodeAddress(order.full_address);

                if (coords) {
                    order.coordinates = coords;
                }

                // Delay nhỏ để tránh rate limit
                await new Promise(r => setTimeout(r, 200));
            }
        }

        // Vẽ lộ trình
        async function drawRoute() {
            const validOrders = orders.filter(o => o.coordinates);

            if (validOrders.length === 0) {
                console.log('Không có đơn hàng có tọa độ');
                return;
            }

            if (!shipperLocation) {
                console.log('Không có vị trí shipper');
                return;
            }

            // Tạo waypoints string - Goong API dùng format: lat,lng
            let origin = `${shipperLocation[1]},${shipperLocation[0]}`;
            let destination = '';
            let waypoints = [];

            console.log('Origin (vị trí shipper):', origin);

            if (validOrders.length === 1) {
                destination = `${validOrders[0].coordinates[1]},${validOrders[0].coordinates[0]}`;
                console.log('Destination:', destination);
            } else {
                // Điểm cuối là đơn hàng cuối cùng
                const lastOrder = validOrders[validOrders.length - 1];
                destination = `${lastOrder.coordinates[1]},${lastOrder.coordinates[0]}`;

                // Các điểm giữa (tất cả đơn hàng trừ đơn cuối)
                for (let i = 0; i < validOrders.length - 1; i++) {
                    const coord = validOrders[i].coordinates;
                    waypoints.push(`${coord[1]},${coord[0]}`);
                }
                console.log('Waypoints:', waypoints);
                console.log('Destination:', destination);
            }

            try {
                let url = `https://rsapi.goong.io/Direction?origin=${origin}&destination=${destination}&vehicle=bike&api_key=${GOONG_API_KEY}`;

                if (waypoints.length > 0) {
                    url += `&waypoints=${waypoints.join(';')}`;
                }

                console.log('Direction API URL:', url);

                const response = await fetch(url);
                const data = await response.json();
                console.log('Direction API response:', data);

                if (data.routes && data.routes.length > 0) {
                    const route = data.routes[0];

                    // Cập nhật thông tin
                    const leg = route.legs[0];
                    let totalDistance = 0;
                    let totalDuration = 0;

                    route.legs.forEach(l => {
                        totalDistance += l.distance.value;
                        totalDuration += l.duration.value;
                    });

                    document.getElementById('totalDistance').textContent =
                        (totalDistance / 1000).toFixed(1) + ' km';
                    document.getElementById('totalDuration').textContent =
                        Math.round(totalDuration / 60) + ' phút';

                    // Decode polyline và vẽ đường
                    const coordinates = decodePolyline(route.overview_polyline.points);

                    // Xóa route cũ nếu có
                    if (map.getSource('route')) {
                        if (map.getLayer('route-outline')) map.removeLayer('route-outline');
                        if (map.getLayer('route')) map.removeLayer('route');
                        map.removeSource('route');
                    }

                    // Thêm route mới
                    map.addSource('route', {
                        type: 'geojson',
                        data: {
                            type: 'Feature',
                            properties: {},
                            geometry: {
                                type: 'LineString',
                                coordinates: coordinates
                            }
                        }
                    });

                    // Thêm viền đường đi (outline)
                    map.addLayer({
                        id: 'route-outline',
                        type: 'line',
                        source: 'route',
                        layout: {
                            'line-join': 'round',
                            'line-cap': 'round'
                        },
                        paint: {
                            'line-color': '#1a5276',
                            'line-width': 10,
                            'line-opacity': 1
                        }
                    });

                    // Đường đi chính
                    map.addLayer({
                        id: 'route',
                        type: 'line',
                        source: 'route',
                        layout: {
                            'line-join': 'round',
                            'line-cap': 'round'
                        },
                        paint: {
                            'line-color': '#3498db',
                            'line-width': 6,
                            'line-opacity': 1
                        }
                    });
                }
            } catch (error) {
                console.error('Routing error:', error);
            }
        }

        // Decode Google Polyline
        function decodePolyline(encoded) {
            let points = [];
            let index = 0, len = encoded.length;
            let lat = 0, lng = 0;

            while (index < len) {
                let b, shift = 0, result = 0;
                do {
                    b = encoded.charCodeAt(index++) - 63;
                    result |= (b & 0x1f) << shift;
                    shift += 5;
                } while (b >= 0x20);
                let dlat = ((result & 1) ? ~(result >> 1) : (result >> 1));
                lat += dlat;

                shift = 0;
                result = 0;
                do {
                    b = encoded.charCodeAt(index++) - 63;
                    result |= (b & 0x1f) << shift;
                    shift += 5;
                } while (b >= 0x20);
                let dlng = ((result & 1) ? ~(result >> 1) : (result >> 1));
                lng += dlng;

                points.push([lng * 1e-5, lat * 1e-5]);
            }

            return points;
        }

        // Focus vào marker khi click vào đơn hàng
        // Vẽ đường đến 1 đơn hàng cụ thể
        async function drawRouteToOrder(index) {
            const order = orders[index];

            if (!order || !order.coordinates || !shipperLocation) return;

            const origin = `${shipperLocation[1]},${shipperLocation[0]}`;
            const destination = `${order.coordinates[1]},${order.coordinates[0]}`;

            try {
                const url = `https://rsapi.goong.io/Direction?origin=${origin}&destination=${destination}&vehicle=bike&api_key=${GOONG_API_KEY}`;
                const response = await fetch(url);
                const data = await response.json();

                if (data.routes && data.routes.length > 0) {
                    const route = data.routes[0];

                    // Cập nhật thông tin khoảng cách và thời gian
                    const leg = route.legs[0];
                    document.getElementById('totalDistance').textContent =
                        (leg.distance.value / 1000).toFixed(1) + ' km';
                    document.getElementById('totalDuration').textContent =
                        Math.round(leg.duration.value / 60) + ' phút';

                    // Decode polyline
                    const coordinates = decodePolyline(route.overview_polyline.points);

                    // Xóa route cũ nếu có
                    if (map.getSource('route')) {
                        if (map.getLayer('route-outline')) map.removeLayer('route-outline');
                        if (map.getLayer('route')) map.removeLayer('route');
                        map.removeSource('route');
                    }

                    // Thêm route mới
                    map.addSource('route', {
                        type: 'geojson',
                        data: {
                            type: 'Feature',
                            properties: {},
                            geometry: {
                                type: 'LineString',
                                coordinates: coordinates
                            }
                        }
                    });

                    // Viền đường đi
                    map.addLayer({
                        id: 'route-outline',
                        type: 'line',
                        source: 'route',
                        layout: { 'line-join': 'round', 'line-cap': 'round' },
                        paint: { 'line-color': '#1a5276', 'line-width': 10, 'line-opacity': 1 }
                    });

                    // Đường đi chính
                    map.addLayer({
                        id: 'route',
                        type: 'line',
                        source: 'route',
                        layout: { 'line-join': 'round', 'line-cap': 'round' },
                        paint: { 'line-color': '#3498db', 'line-width': 6, 'line-opacity': 1 }
                    });

                    // Fit bounds để hiển thị cả shipper và điểm đến
                    const bounds = new goongjs.LngLatBounds();
                    bounds.extend(shipperLocation);
                    bounds.extend(order.coordinates);
                    map.fitBounds(bounds, { padding: 80 });
                }
            } catch (error) {
                console.error('Routing error:', error);
            }
        }

        function focusOnMarker(index) {
            const order = orders[index];

            if (order && order.coordinates) {
                // Vẽ đường đến đơn hàng này
                drawRouteToOrder(index);

                // Mở popup
                if (markers[index]) {
                    markers[index].togglePopup();
                }

                // Highlight card
                document.querySelectorAll('.order-card').forEach(card => {
                    card.classList.remove('active');
                });
                document.querySelector(`.order-card[data-index="${index}"]`).classList.add('active');
            }
        }

        // Ẩn loading
        function hideLoading() {
            document.getElementById('loadingOverlay').classList.add('hidden');
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
