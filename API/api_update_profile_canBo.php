<?php
header("Content-Type: application/json");
session_start();
require_once __DIR__ . '/../backend/config/connect.php';

if (!isset($_SESSION['MaNguoiDung'])) {
	http_response_code(401);
	echo json_encode(["status" => "error", "message" => "Chưa đăng nhập"]);
	exit();
}
// Nhận dữ liệu POST
$maCanBo = $_POST['MaCanBo'] ?? '';
$hoTen = $_POST['HoTen'] ?? '';
$gioiTinh = $_POST['GioiTinh'] ?? '';
$ngaySinh = $_POST['NgaySinh'] ?? '';
$soDienThoai = $_POST['SoDienThoai'] ?? '';
$email = $_POST['Email'] ?? '';
$donViCongTac = $_POST['DonViCongTac'] ?? '';

if (!$maCanBo) {
	echo json_encode(["status" => "error", "message" => "Thiếu mã cán bộ"]);
	exit();
}
try {
	$db = new connectDB();
	$conn = $db->conn;
	$stmt = $conn->prepare("UPDATE canbo_kt SET hoten=?, gioitinh=?, ngaysinh=?, sodienthoai=?, email=?, donvicongtac=? WHERE macanbo=?");
	if ($stmt->execute([$hoTen, $gioiTinh, $ngaySinh, $soDienThoai, $email, $donViCongTac, $maCanBo])) {
		echo json_encode(["status" => "success"]);
	} else {
		echo json_encode(["status" => "error", "message" => "Lỗi cập nhật DB"]);
	}
} catch (Exception $e) {
	echo json_encode([
		"status" => "error",
		"message" => "Lỗi server: " . $e->getMessage()
	]);
}
?>
