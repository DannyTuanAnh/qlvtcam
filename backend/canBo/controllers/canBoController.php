<?php
require_once __DIR__ . '/../../config/connect.php';

class canboController {
	public function getThongTinCanBo($maCanBo) {
		$db = new connectDB();
		$conn = $db->conn;
		$stmt = $conn->prepare("SELECT MaCanBo, HoTen, GioiTinh, NgaySinh, SoDienThoai, Email, DonViCongTac, avatar FROM canbo_kt WHERE MaCanBo = ?");
		$stmt->execute([$maCanBo]);
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($row) {
			return [
				'status' => 'success',
				'data' => $row
			];
		} else {
			return [
				'status' => 'error',
				'message' => 'Không tìm thấy cán bộ'
			];
		}
	}
}
