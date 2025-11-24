<?php
/**
 * Print Waybill / Shipping Label
 * Phiếu gửi hàng - Khổ A6 (105 x 148 mm)
 */

// Database connection
include_once("model/connect1.php");

// Get order ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    die("Không tìm thấy đơn hàng.");
}

// Connect to database
$p = new connect_db();
$conn = $p->open_kn();

if (!$conn) {
    die("Lỗi kết nối database.");
}

// Get order data from taodonhang and donhang tables
$sql = "SELECT
    t.Id_TaoDonHang,
    t.tenDonHang,
    t.loaiDonHang,
    t.soLuong,
    t.khoiLuong,
    t.phiThuHo,
    t.hinhThucVanChuyen,
    t.moTa,
    t.tenNG,
    t.tenNN,
    t.sdtNG,
    t.sdtNN,
    t.diaChiGiao,
    t.diaChiNhan,
    t.quanHuyenGiao,
    t.quanHuyenNhan,
    t.phuongXaGiao,
    t.phuongXaNhan,
    t.tinhGiao,
    t.tinhNhan,
    t.ngayLapDon,
    t.chieuDai,
    t.chieuCao,
    t.chieuRong,
    t.giaVanChuyen,
    d.maVanDon,
    d.trangThaiDonHang
FROM taodonhang t
LEFT JOIN donhang d ON t.Id_TaoDonHang = d.Id_TaoDonHang
WHERE t.Id_TaoDonHang = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $order = mysqli_fetch_assoc($result);
} else {
    die("Không tìm thấy thông tin đơn hàng.");
}

mysqli_stmt_close($stmt);
$p->close_kn($conn);

// Build full addresses
$diaChiGuiDay = $order['diaChiGiao'] . ', ' . $order['phuongXaGiao'] . ', ' . $order['quanHuyenGiao'] . ', ' . $order['tinhGiao'];
$diaChiNhanDay = $order['diaChiNhan'] . ', ' . $order['phuongXaNhan'] . ', ' . $order['quanHuyenNhan'] . ', ' . $order['tinhNhan'];

// Format COD amount
$codAmount = number_format((float)$order['phiThuHo'], 0, ',', '.') . ' VND';
$shippingFee = number_format((float)$order['giaVanChuyen'], 0, ',', '.') . ' VND';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phiếu Gửi Hàng - <?php echo htmlspecialchars($order['maVanDon']); ?></title>

    <!-- JsBarcode Library -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            line-height: 1.3;
        }

        /* Page size A6 */
        .waybill {
            width: 105mm;
            height: 148mm;
            padding: 5mm;
            margin: 0 auto;
            border: 1px solid #000;
            background: #fff;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 3mm;
            margin-bottom: 3mm;
        }

        .logo {
            font-size: 18px;
            font-weight: bold;
            color: #2e7d32;
        }

        .hotline {
            font-size: 10px;
            color: #666;
        }

        .tracking-number {
            font-size: 14px;
            font-weight: bold;
            text-align: right;
        }

        /* Barcode */
        .barcode-section {
            text-align: center;
            margin-bottom: 3mm;
            padding-bottom: 3mm;
            border-bottom: 1px dashed #ccc;
        }

        .barcode-section svg {
            max-width: 100%;
            height: 35px;
        }

        /* Content sections */
        .content {
            display: flex;
            gap: 3mm;
        }

        .left-section {
            flex: 1.5;
        }

        .right-section {
            flex: 1;
            border-left: 1px solid #ccc;
            padding-left: 3mm;
        }

        .section {
            margin-bottom: 3mm;
        }

        .section-title {
            font-weight: bold;
            font-size: 10px;
            color: #333;
            margin-bottom: 1mm;
            text-transform: uppercase;
            background: #f0f0f0;
            padding: 1mm;
        }

        .info-row {
            margin-bottom: 1mm;
        }

        .label {
            font-weight: bold;
            font-size: 9px;
            color: #666;
        }

        .value {
            font-size: 10px;
        }

        .name {
            font-weight: bold;
            font-size: 12px;
        }

        .phone {
            font-size: 11px;
            font-weight: bold;
        }

        .address {
            font-size: 9px;
            color: #333;
        }

        /* COD Section - Important */
        .cod-section {
            background: #fff3cd;
            border: 2px solid #ffc107;
            padding: 2mm;
            text-align: center;
            margin-bottom: 3mm;
        }

        .cod-label {
            font-size: 10px;
            font-weight: bold;
        }

        .cod-amount {
            font-size: 16px;
            font-weight: bold;
            color: #dc3545;
        }

        /* Order details */
        .order-details {
            font-size: 9px;
        }

        .order-details .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1mm;
        }

        /* Footer */
        .footer {
            border-top: 1px solid #000;
            padding-top: 3mm;
            margin-top: 3mm;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            text-align: center;
            width: 45%;
        }

        .signature-line {
            border-top: 1px solid #000;
            margin-top: 12mm;
            padding-top: 1mm;
            font-size: 8px;
        }

        /* Print button */
        .no-print {
            text-align: center;
            margin: 10px auto;
            max-width: 105mm;
        }

        .btn-print {
            padding: 10px 20px;
            font-size: 14px;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-print:hover {
            background: #0056b3;
        }

        /* Print styles */
        @media print {
            @page {
                size: 105mm 148mm;
                margin: 0;
            }

            body {
                margin: 0;
            }

            .no-print {
                display: none !important;
            }

            .waybill {
                border: none;
                margin: 0;
                padding: 3mm;
            }
        }
    </style>
</head>
<body>

<!-- Print Button -->
<div class="no-print">
    <button class="btn-print" onclick="window.print()">
        In Phiếu Gửi Hàng
    </button>
</div>

<!-- Waybill -->
<div class="waybill">
    <!-- Header -->
    <div class="header">
        <div>
            <div class="logo">HPSHIP</div>
            <div class="hotline">Hotline: 1900 xxxx</div>
        </div>
        <div class="tracking-number">
            <?php echo htmlspecialchars($order['maVanDon']); ?>
        </div>
    </div>

    <!-- Barcode -->
    <div class="barcode-section">
        <svg id="barcode"></svg>
    </div>

    <!-- Content -->
    <div class="content">
        <!-- Left Section - Sender & Receiver -->
        <div class="left-section">
            <!-- Sender -->
            <div class="section">
                <div class="section-title">Nguoi Gui (From)</div>
                <div class="info-row">
                    <div class="name"><?php echo htmlspecialchars($order['tenNG']); ?></div>
                </div>
                <div class="info-row">
                    <div class="phone"><?php echo htmlspecialchars($order['sdtNG']); ?></div>
                </div>
                <div class="info-row">
                    <div class="address"><?php echo htmlspecialchars($diaChiGuiDay); ?></div>
                </div>
            </div>

            <!-- Receiver -->
            <div class="section">
                <div class="section-title">Nguoi Nhan (To)</div>
                <div class="info-row">
                    <div class="name"><?php echo htmlspecialchars($order['tenNN']); ?></div>
                </div>
                <div class="info-row">
                    <div class="phone"><?php echo htmlspecialchars($order['sdtNN']); ?></div>
                </div>
                <div class="info-row">
                    <div class="address"><?php echo htmlspecialchars($diaChiNhanDay); ?></div>
                </div>
            </div>
        </div>

        <!-- Right Section - COD & Details -->
        <div class="right-section">
            <!-- COD -->
            <div class="cod-section">
                <div class="cod-label">TIEN THU HO (COD)</div>
                <div class="cod-amount"><?php echo $codAmount; ?></div>
            </div>

            <!-- Order Details -->
            <div class="section">
                <div class="section-title">Chi Tiet Don</div>
                <div class="order-details">
                    <div class="row">
                        <span>Ten hang:</span>
                        <span><?php echo htmlspecialchars($order['tenDonHang']); ?></span>
                    </div>
                    <div class="row">
                        <span>So luong:</span>
                        <span><?php echo $order['soLuong']; ?></span>
                    </div>
                    <div class="row">
                        <span>Khoi luong:</span>
                        <span><?php echo $order['khoiLuong']; ?> kg</span>
                    </div>
                    <div class="row">
                        <span>Kich thuoc:</span>
                        <span><?php echo $order['chieuDai'] . 'x' . $order['chieuRong'] . 'x' . $order['chieuCao']; ?> cm</span>
                    </div>
                    <div class="row">
                        <span>Phi ship:</span>
                        <span><?php echo $shippingFee; ?></span>
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <?php if (!empty($order['moTa'])): ?>
            <div class="section">
                <div class="section-title">Ghi Chu</div>
                <div style="font-size: 9px;"><?php echo htmlspecialchars($order['moTa']); ?></div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer - Signatures -->
    <div class="footer">
        <div class="signatures">
            <div class="signature-box">
                <div class="signature-line">Ky nhan cua khach hang</div>
            </div>
            <div class="signature-box">
                <div class="signature-line">Chu ky nhan vien</div>
            </div>
        </div>
    </div>
</div>

<script>
    // Generate barcode
    JsBarcode("#barcode", "<?php echo htmlspecialchars($order['maVanDon']); ?>", {
        format: "CODE128",
        width: 1.5,
        height: 35,
        displayValue: false,
        margin: 0
    });

    // Auto print when page loads
    window.onload = function() {
        setTimeout(function() {
            window.print();
        }, 500);
    };
</script>

</body>
</html>
