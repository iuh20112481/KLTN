-- Migration: Thêm field soDonCanGiao vào bảng buucuc
-- Mục đích: Cho phép NVBC cài đặt số đơn cần giao/tháng cho NVGH của bưu cục
-- Ngày tạo: 2025-12-11

-- Thêm cột soDonCanGiao vào bảng buucuc
ALTER TABLE `buucuc`
ADD COLUMN `soDonCanGiao` INT NOT NULL DEFAULT 100 COMMENT 'Số đơn cần giao tối thiểu mỗi tháng để được tính hoa hồng';

-- Cập nhật giá trị mặc định cho tất cả các bưu cục hiện tại
UPDATE `buucuc` SET `soDonCanGiao` = 100 WHERE `soDonCanGiao` IS NULL;

-- Kiểm tra kết quả
SELECT maBuuCuc, maNhanVien, soDonCanGiao FROM `buucuc` LIMIT 10;
