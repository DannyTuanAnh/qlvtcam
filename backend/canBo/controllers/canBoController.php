<?php
require_once __DIR__ . '/../../config/connect.php';

class canboController {
	public function getThongTinCanBo($maCanBo) {
		$db = new connectDB();
		$conn = $db->conn;
		$stmt = $conn->prepare("SELECT MaCanBo, HoTen, GioiTinh, NgaySinh, SoDienThoai, Email, DonViCongTac, avatar FROM canbo_kt WHERE MaCanBo = ?");
		$stmt->bind_param("s", $maCanBo);
		$stmt->execute();
		$result = $stmt->get_result();
		if ($row = $result->fetch_assoc()) {
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
