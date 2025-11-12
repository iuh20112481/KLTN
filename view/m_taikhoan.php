<?php
include_once "../control/ctaikhoan.php";

        // Khởi tạo một đối tượng của controller
        $controller = new controller_tk();
      
        // Gọi phương thức để cập nhật loại người dùng tự động
        $controller->updateUserType();
        ?>