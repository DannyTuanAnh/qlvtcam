<?php
require_once __DIR__ . '/../backend/config/connect.php'; // Kết nối CSDL

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new connectDB();
    $maNhatKy = $_POST['MaNhatKy'] ?? null;

    // 1. Lấy MaThua và MaVu từ nhật ký
    $stmt = $db->conn->prepare("
        SELECT MaThua, MaVu 
        FROM nhat_ky_canh_tac 
        WHERE MaNhatKy = ?
    ");
    $stmt->bind_param("i", $maNhatKy);
    $stmt->execute();
    $result = $stmt->get_result();
    $nhatKy = $result->fetch_assoc();
    $stmt->close();

    if (!$nhatKy) {
        echo json_encode(["status" => "error", "message" => "Không tìm thấy nhật ký"]);
        exit;
    }

    $maThua = $nhatKy['MaThua'];
    $maVuNhatKy = $nhatKy['MaVu'];

    // 2. Kiểm tra xem thửa đất này trong vụ đó đã thu hoạch chưa
    $stmt = $db->conn->prepare("
        SELECT * 
        FROM thu_hoach 
        WHERE MaThua = ? AND MaVu = ?
        LIMIT 1
    ");
    $stmt->bind_param("ii", $maThua, $maVuNhatKy);
    $stmt->execute();
    $stmt->store_result();
    $isHarvested = $stmt->num_rows > 0;
    $stmt->close();

    if ($isHarvested) {
        echo json_encode([
            "status" => "error",
            "message" => "Thửa đất ở đợt này đã được thu hoạch nên không cho chỉnh sửa"
        ]);
        exit;
    }
    if (!$maNhatKy) {
        echo json_encode(["status" => "error", "message" => "Thiếu mã nhật ký."]);
        exit;
    }

    $stmt = $db->conn->prepare("DELETE FROM nhat_ky_canh_tac WHERE MaNhatKy = ?");
    $stmt->bind_param("i", $maNhatKy);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi khi xóa nhật ký."]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Phương thức không hợp lệ."]);
}
?>