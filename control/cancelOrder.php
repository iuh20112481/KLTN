<?php
// Kết nối đến cơ sở dữ liệu
include_once("../model/connect1.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy lý do hủy đơn, mã đơn hàng và tên đơn hàng từ dữ liệu gửi đi
    $reason = isset($_POST['reason']) ? $_POST['reason'] : null;
    $orderId = isset($_POST['Id_TaoDonHang']) ? $_POST['Id_TaoDonHang'] : null;
    $tendonhang = isset($_POST['tenDonHang']) ? $_POST['tenDonHang'] : null;

    // Kiểm tra xem lý do hủy và mã đơn hàng có được gửi đi không
    if (!$reason || !$orderId || !$tendonhang) {
        echo json_encode(array("success" => false, "message" => "Thiếu thông tin lý do hủy đơn hoặc mã đơn hàng"));
        exit();
    }

    // Truy vấn SQL để thêm thông tin hủy đơn vào cơ sở dữ liệu
    $sql = "INSERT INTO donhanghuy (Id_TaoDonHang, tenDonHang, lyDo) VALUES ('$orderId', '$tendonhang', '$reason')";

    // Thực thi truy vấn SQL
    if (mysqli_query($conn, $sql)) {
        echo json_encode(array("success" => true, "message" => "Đã hủy đơn thành công"));
    } else {
        echo json_encode(array("success" => false, "message" => "Lỗi khi hủy đơn: " . mysqli_error($conn)));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Yêu cầu không hợp lệ"));
}
?>
