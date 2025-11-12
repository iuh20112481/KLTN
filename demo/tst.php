<?php
session_start(); // Bắt đầu phiên để truy cập dữ liệu session

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user'])) {
    // Nếu không, chuyển hướng đến trang đăng nhập
    header("Location: dangNhap.php");
    exit();
}

// In giá trị các biến đã đăng nhập
echo "Thông tin người dùng:<br>";
echo "ID người dùng: " .  $_SESSION['nguoidung']['id_user'] . "<br>";
echo "Tên người dùng: " . $_SESSION['name_user'] . "<br>";

if (isset($_SESSION["buu_cuc_info"])) {
    // In thông tin bưu cục nếu tồn tại
    echo "Thông tin bưu cục:<br>";
    echo "Tên bưu cục: " . $_SESSION["buu_cuc_info"]['tenBuuCuc'] . "<br>";
    echo "Mã bưu cục: " . $_SESSION["buu_cuc_info"]['maBuuCuc'] . "<br>";
    echo "Mã tên BC: " . $_SESSION["buu_cuc_info"]['Id_TenBC'] . "<br>";
    echo "Địa chỉ bưu cục: " . $_SESSION["buu_cuc_info"]['diaChiBC'] . "<br>";

}

if (isset($_SESSION["nvbc"]['id_user'])) {
  echo "Vai trò: Nhân viên bưu cục<br>";
} elseif (isset($_SESSION["nvgh"]['id_user'])) {
  echo "Vai trò: Nhân viên giao hàng<br>";
  echo "ID nhân viên giao hàng: " . $_SESSION["nvgh"]['id_user'] . "<br>";
} else {
  echo "Vai trò: Người dùng<br>";
}
