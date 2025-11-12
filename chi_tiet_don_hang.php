<?php
    // Include configuration and retrieve the order ID from the URL
    require 'config.php';
    $maVanDon = isset($_GET['maVanDon']) ? $_GET['maVanDon'] : null;

    // Build the API URL to fetch order information
    $api_url = isset($maVanDon) ? API_BASE_URL . 'connectAPI.php?maVanDon=' . urlencode($maVanDon) : null;

    if ($maVanDon) {
        // Fetch data from the API
        $response = @file_get_contents($api_url);

        if ($response === false) {
            die('Could not connect to the API.');
        }

        // Convert JSON response to a PHP array
        $data = json_decode($response, true);

        if (is_null($data)) {
            die('Invalid response from the API.');
        }

        if (isset($data[0])) {
            $order_info = $data[0];
        } else {
            die('Order information not found.');
        }
    } else {
        die('Order ID is missing.');
    }

    // Extract order details and apply sanitization
    function safe($value) {
        return htmlspecialchars($value);
    }

    $order_details = [
        'Mã vận đơn' => safe($order_info['maVanDon'] ?? 'Không có thông tin'),
        'Tên người gửi' => safe($order_info['tenng'] ?? 'Không có thông tin'),
        'Tên người nhận' => safe($order_info['tennn'] ?? 'Không có thông tin'),
        'Số điện thoại người nhận' => safe($order_info['sdtng'] ?? 'Không có thông tin'),
        'Giá vận chuyển' => safe($order_info['giaVanChuyen'] ?? 'Không có thông tin'),
        'Trạng thái lưu kho' => safe($order_info['trangThaiLuuKho'] ?? 'Không có thông tin'),
        'Tên bưu cục' => safe($order_info['tenBuuCuc'] ?? 'Không có thông tin'),
        'Ngày bắt đầu giao hàng' => safe($order_info['ngayBDGiaoHang'] ?? 'Không có thông tin'),
        'Tên đơn hàng' => safe($order_info['tenDonHang'] ?? 'Không có thông tin'),
        'Trạng thái đơn hàng' => safe($order_info['trangThaiDonHang'] ?? 'Không có thông tin'),
    ];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết Đơn Hàng</title>
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #333;
            margin: 0;
            padding: 20px;
            animation: fadeIn 1s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .container {
            max-width: 700px;
            margin: 10px auto;
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        h1 {
            text-align: center;
            color: #444;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .order-info {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .order-info li {
            padding: 15px 0;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
        }

        .order-info li:last-child {
            border-bottom: none;
        }

        .order-info li strong {
            color: #555;
            font-weight: 600;
        }

        .back-link {
            text-align: center;
            margin-top: 30px;
        }

        .back-link a {
            text-decoration: none;
            color: #0066cc;
            font-weight: bold;
            padding: 10px 20px;
            border: 1px solid #b9b9b9;
            border-radius: 5px;
            transition: background 0.2s, color 0.2s;
        }

        .back-link a:hover {
            background: #ff971f;
            color: white;
        }
    </style>
    <link rel="stylesheet" href="css/style.css?">
</head>
<body>
    <div class="container">
        <h1 id="h2-content">Chi tiết Đơn Hàng</h1>
        <ul class="order-info">
            <?php foreach ($order_details as $label => $value): ?>
                <li>
                    <strong id="chitietdon" ><?php echo $label; ?>:</strong>
                    <span id="chitietdon1" ><?php echo $value; ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="back-link">
            <a id="chitietdon2" href="index.php">Quay lại trang chủ</a>
        </div>
    </div>
</body>
</html>
