<?php
session_start();

// Ensure the user is logged in as either 'nguoidung' or 'nvgh'
if (!isset($_SESSION['user']) || (!isset($_SESSION["nguoidung"]['id_user']) && !isset($_SESSION["nvgh"]['id_user']))) {
    header("Location: dangNhap.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "HPship";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
    }
    $update_success = false; // Biến này để kiểm tra xem đã cập nhật thành công hay chưa

    $tenND = $_POST['tenND'];
    $sdtND = $_POST['sdtND'];
    $emailND = $_POST['emailND'];
    $mucDichSuDung = $_POST['mucDichSuDung'];
    $nganhHang = $_POST['nganhHang'];
    $quyMoVanChuyen = $_POST['quyMoVanChuyen'];
    $diaChigop = $_POST['diaChigop'];
    $mkND = $_POST['mkND'];
    $maNH = $_POST['output-maNH'];
    $soTK = $_POST['output-soTK'];
    
    // Determine the user ID based on the session type
    if (isset($_SESSION['nguoidung']['id_user'])) {
        $user_id = $_SESSION['nguoidung']['id_user'];
    } elseif (isset($_SESSION['nvgh']['id_user'])) {
        $user_id = $_SESSION['nvgh']['id_user'];
    } else {
        echo "Không tìm thấy thông tin tài khoản";
        exit();
    }

    $sql = "UPDATE taikhoan 
            SET tenND='$tenND', sdtND='$sdtND', emailND='$emailND', mucDichSuDung='$mucDichSuDung', nganhHang='$nganhHang', 
                quyMoVanChuyen='$quyMoVanChuyen', diaChi='$diaChigop', mkND='$mkND', maNH='$maNH', soTK='$soTK' 
            WHERE Id_TaiKhoan='$user_id'";

    if ($conn->query($sql) === TRUE) {
        $update_success = true; 
            
        // Redirect based on the session type
        if (isset($_SESSION['nguoidung']['id_user'])) {
            header("Location: ../view/u_giaodiennguoidung.php?page=aPR");
        } elseif (isset($_SESSION['nvgh']['id_user'])) {
            header("Location: ../view/d_giaodiennguoidung.php?page=aqltk");
        }
        exit();
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
