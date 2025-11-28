<?php
// Thông tin kết nối CSDL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "HPship";

// Kết nối CSDL
$link = mysqli_connect($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if (!$link) {
    die("Kết nối CSDL thất bại: " . mysqli_connect_error());
}

// Set charset UTF-8
mysqli_set_charset($link, "utf8");

// Lấy dữ liệu JSON từ request
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validate dữ liệu
if (!isset($data['hoTen']) || !isset($data['sdt']) || !isset($data['email']) ||
    !isset($data['maBuuCuc']) || !isset($data['matKhau']) || !isset($data['maNhanVien'])) {
    echo json_encode(array('success' => false, 'message' => 'Thiếu thông tin bắt buộc'));
    exit();
}

// Bắt đầu transaction
mysqli_begin_transaction($link);

try {
    // 1. Insert vào bảng taikhoan
    $sqlTK = "INSERT INTO taikhoan (tenND, sdtND, emailND, mkND)
              VALUES (?, ?, ?, ?)";

    $stmtTK = mysqli_prepare($link, $sqlTK);
    $hashedPassword = md5($data['matKhau']);

    mysqli_stmt_bind_param($stmtTK, "ssss",
        $data['hoTen'],
        $data['sdt'],
        $data['email'],
        $hashedPassword
    );

    if (!mysqli_stmt_execute($stmtTK)) {
        throw new Exception('Lỗi khi tạo tài khoản: ' . mysqli_error($link));
    }

    $idTaiKhoan = mysqli_insert_id($link);

    // 2. Insert vào bảng phanloainguoidung
    $sqlPLND = "INSERT INTO phanloainguoidung (Id_TaiKhoan, loaiNguoiDung)
                VALUES (?, 'Nhân viên giao hàng')";

    $stmtPLND = mysqli_prepare($link, $sqlPLND);
    mysqli_stmt_bind_param($stmtPLND, "i", $idTaiKhoan);

    if (!mysqli_stmt_execute($stmtPLND)) {
        throw new Exception('Lỗi khi phân loại người dùng: ' . mysqli_error($link));
    }

    $idPhanLoai = mysqli_insert_id($link);

    // 3. Lấy Id_TenBC từ bảng tenbc dựa trên maBuuCuc
    $sqlGetIdTenBC = "SELECT Id_TenBC FROM tenbc WHERE maBuuCuc = ?";
    $stmtGetIdTenBC = mysqli_prepare($link, $sqlGetIdTenBC);
    mysqli_stmt_bind_param($stmtGetIdTenBC, "s", $data['maBuuCuc']);
    mysqli_stmt_execute($stmtGetIdTenBC);
    $resultIdTenBC = mysqli_stmt_get_result($stmtGetIdTenBC);
    $rowIdTenBC = mysqli_fetch_assoc($resultIdTenBC);

    if (!$rowIdTenBC) {
        throw new Exception('Không tìm thấy bưu cục với mã: ' . $data['maBuuCuc']);
    }

    $idTenBC = $rowIdTenBC['Id_TenBC'];

    // 4. Insert vào bảng buucuc
    $sqlBC = "INSERT INTO buucuc (Id_TaiKhoan, Id_PhanLoaiNguoiDung, Id_TenBC, maNhanVien, maBuuCuc)
              VALUES (?, ?, ?, ?, ?)";

    $stmtBC = mysqli_prepare($link, $sqlBC);
    mysqli_stmt_bind_param($stmtBC, "iiiss",
        $idTaiKhoan,
        $idPhanLoai,
        $idTenBC,
        $data['maNhanVien'],
        $data['maBuuCuc']
    );

    if (!mysqli_stmt_execute($stmtBC)) {
        throw new Exception('Lỗi khi gán bưu cục: ' . mysqli_error($link));
    }

    // Commit transaction
    mysqli_commit($link);

    echo json_encode(array(
        'success' => true,
        'message' => 'Thêm nhân viên giao hàng thành công',
        'idTaiKhoan' => $idTaiKhoan
    ));

    mysqli_stmt_close($stmtTK);
    mysqli_stmt_close($stmtPLND);
    mysqli_stmt_close($stmtGetIdTenBC);
    mysqli_stmt_close($stmtBC);

} catch (Exception $e) {
    // Rollback nếu có lỗi
    mysqli_rollback($link);
    echo json_encode(array('success' => false, 'message' => $e->getMessage()));
}

// Đóng kết nối CSDL
mysqli_close($link);
?>
