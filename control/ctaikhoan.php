<?php
include_once "../model/mtaikhoan.php";

class controller_tk {
        function updateUserType() {
            $model = new model_tk();

            // Lấy danh sách các Id_TaiKhoan chưa được thêm vào bảng phanloainguoidung
            $newUserIds = $model->getNewUserIds();

            // Thêm loại người dùng mới vào bảng phanloainguoidung cho từng Id_TaiKhoan
            foreach ($newUserIds as $userId) {
                $userType = $model->checkUserType($userId);
                if ($userType == 'Cá nhân' || $userType == 'Doanh nghiệp') {
                    $model->insertUserType($userId, 'Người dùng');
                }
            }
        }
        
        public function getDSNVGH($maBuuCuc = null) {
            $model = new model_tk();
            return $model->getDSNVGH($maBuuCuc);
        }

        public function getcountDonHangofNVGH($maNhanVien) {
            $model = new model_tk();
            return $model->countDonHangofNVGH($maNhanVien);
        }    

        public function deleteNVGH($Id_TaiKhoan) {
            $model = new model_tk();
            return $model->deleteNVGH($Id_TaiKhoan);
        }
    
    // kết thúc hàm     
    }

    // Xử lý request xem thống kê đơn giao cho nhân viên giao hàng 
    if (isset($_POST['maNhanVien'])) {
        $maNhanVien = $_POST['maNhanVien'];
        $controller = new controller_tk();

        $result = $controller->getcountDonHangofNVGH($maNhanVien); 

        if ($result) {
            echo json_encode([
                'tongdonhang' => $result['tongdonhang'], 
                'tongdondagiao' => $result['tongdondagiao'] 
            ]);
        } else {
            echo json_encode(['error' => 'No data found']); 
        }
    } 
?>
