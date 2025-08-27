<?php
require_once __DIR__ . '/../backend/config/connect.php'; // Kết nối CSDL

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new connectDB();
    $maThuHoach = $_POST['MaThuHoach'] ?? null;

    if (!$maThuHoach) {
        echo json_encode(["status" => "error", "message" => "Thiếu mã nhật ký."]);
        exit;
    }

    // Lấy ngày thu hoạch
    $stmt = $db->conn->prepare("SELECT NgayThuHoach FROM thu_hoach WHERE MaThuHoach = ?");
    $stmt->bind_param("i", $maThuHoach);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if (!$row) {
        echo json_encode(["status" => "error", "message" => "Không tìm thấy thông tin thu hoạch."]);
        exit;
    }

    $ngayThuHoach = $row['NgayThuHoach'];
    $now = new DateTime();
    $ngayThuHoachDT = new DateTime($ngayThuHoach);
    $interval = $ngayThuHoachDT->diff($now);
    if ($interval->days >= 15 && $ngayThuHoachDT < $now) {
        echo json_encode(["status" => "error", "message" => "Đã quá 15 ngày kể từ ngày thu hoạch, không thể chỉnh sửa/xóa."]);
        exit;
    }

    $stmt = $db->conn->prepare("DELETE FROM thu_hoach WHERE MaThuHoach = ?");
    $stmt->bind_param("i", $maThuHoach);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi khi xóa nhật ký."]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Phương thức không hợp lệ."]);
}
?>