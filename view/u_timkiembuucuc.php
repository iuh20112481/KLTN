<?php
    // Kết nối đến cơ sở dữ liệu MySQL
    $servername = "localhost";
    $username = "root"; // Thay username và password bằng thông tin của bạn
    $password = "";
    $dbname = "HPship";

    // Tạo kết nối
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối không thành công: " . $conn->connect_error);
    }

    // Lấy từ khóa tìm kiếm từ yêu cầu GET
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

    // Truy vấn dữ liệu từ bảng buucuc theo từ khóa tìm kiếm
    $sql = "SELECT Id_TenBC, tenBuuCuc, diaChiBC, time FROM tenbc WHERE tenBuuCuc LIKE '%$searchTerm%'";
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BƯU CỤC HPship TOÀN QUỐC</title>
    <!-- Link CSS Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- CSS tùy chỉnh -->
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .list-location-url {
            display: flex;
            flex-wrap: wrap;
        }
        .list-location-url .col-md-3 {
            padding: 10px;
            display: flex;
            align-items: stretch;
            font-family: 'Samsung One 700', Arial, sans-serif;
        }
        .list-location-url .location-card {
            padding: 10px;
            border: 2px solid #5e007f;
            cursor: pointer;
            box-shadow: 0 0 5px #ccc;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100px; /* Chiều cao cố định */
            width: 100%; /* Chiều rộng đầy đủ của cột */
            text-align: center; /* Căn giữa nội dung theo chiều ngang */
        }
        .list-location-url .location-card:hover {
            background-color: #6cbbff40;
            box-shadow: 0 4px 8px #ccc;
            transform: translateY(-2px);
        }
        .modal-body p {
            margin: 0;
            padding: 5px 0;
        }
        span {
            font-family: 'Samsung One 400', Arial, sans-serif;
        }
        button, input {
            font-family: 'Samsung One 700', Arial, sans-serif;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center" id="h2-content">Danh sách Bưu cục</h2>
        <!-- Form tìm kiếm -->
        <form method="GET" action="">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Nhập tên bưu cục" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                    <?php if (!empty($searchTerm)) : ?>
                        <a href="?search=" class="btn btn-danger">Xóa tìm kiếm</a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
        <!-- Danh sách Bưu cục chia thành 4 cột -->
        <div class="row list-location-url">
            <?php
            // Hiển thị danh sách Bưu cục
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='col-md-3'>";
                    echo "<div class='location-card' onclick=\"showPostOfficeInfo('".$row["tenBuuCuc"]."', '".$row["diaChiBC"]."','".$row["time"]."')\">".$row["tenBuuCuc"]."</div>";
                    echo "</div>";
                }
            } else {
                echo "<div class='col-12'><div class='location-card'>Không có bưu cục nào.</div></div>";
            }
            ?>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="postOfficeModal" tabindex="-1" role="dialog" aria-labelledby="postOfficeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="postOfficeModalLabel">Thông tin Bưu cục</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="h2-content">Tên bưu cục:</p> <span id="modalName"></span>
                    <p id="h2-content">Địa chỉ bưu cục:</p> <span id="modalAddress"></span>
                    <p id="h2-content">Thời gian làm việc:</p> <span id="modalWorkingHours"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Bootstrap và JavaScript -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Hàm để hiển thị modal khi click vào Bưu cục
        function showPostOfficeInfo(tenBuuCuc, diaChiBC, time) {
            // Cập nhật giá trị trong modal
            document.getElementById('modalName').innerText = tenBuuCuc;
            document.getElementById('modalAddress').innerText = diaChiBC;
            document.getElementById('modalWorkingHours').innerText = time;
            // Hiển thị modal
            $('#postOfficeModal').modal('show');
        }
    </script>
</body>
</html>

<?php
// Đóng kết nối
$conn->close();
?>
