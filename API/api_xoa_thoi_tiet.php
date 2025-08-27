<?php
require_once __DIR__ . '/../backend/config/connect.php'; // Kết nối CSDL

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new connectDB();
    $maThoiTiet = $_POST['MaThoiTiet'] ?? null;

    if (!$maThoiTiet) {
        echo json_encode(["status" => "error", "message" => "Thiếu mã nhật ký."]);
        exit;
    }

    // Lấy thời gian đo
    $stmt = $db->conn->prepare("SELECT NgayDo FROM thoi_tiet WHERE MaThoiTiet = ?");
    $stmt->bind_param("i", $maThoiTiet);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if (!$row) {
        echo json_encode(["status" => "error", "message" => "Không tìm thấy thông tin thời tiết."]);
        exit;
    }

    $thoiGianDo = $row['NgayDo'];
    $now = new DateTime();
    $thoiGianDoDT = new DateTime($thoiGianDo);
    $diffSeconds = $now->getTimestamp() - $thoiGianDoDT->getTimestamp();
    if ($diffSeconds >= 86400) { // 24h = 86400 giây
        echo json_encode(["status" => "error", "message" => "Đã quá 24h kể từ thời gian đo, không thể chỉnh sửa/xóa."]);
        exit;
    }

    $stmt = $db->conn->prepare("DELETE FROM thoi_tiet WHERE MaThoiTiet = ?");
    $stmt->bind_param("i", $maThoiTiet);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi khi xóa nhật ký."]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Phương thức không hợp lệ."]);
}
?>