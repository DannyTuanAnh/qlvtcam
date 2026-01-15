<?php
require_once __DIR__ . '/../../config/connect.php';

class canboController {
	public function getThongTinCanBo($maCanBo) {
		$db = new connectDB();
		$conn = $db->conn;
		$stmt = $conn->prepare("SELECT 
			macanbo AS \"MaCanBo\", 
			hoten AS \"HoTen\", 
			gioitinh AS \"GioiTinh\", 
			ngaysinh AS \"NgaySinh\", 
			sodienthoai AS \"SoDienThoai\", 
			email AS \"Email\", 
			donvicongtac AS \"DonViCongTac\", 
			avatar AS \"avatar\" 
		FROM canbo_kt 
		WHERE macanbo = ?");
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
