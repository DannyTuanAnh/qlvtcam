<?php
require_once __DIR__ . '/../backend/config/connect.php'; // Kết nối CSDL

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new connectDB();
    $maNhatKy = $_POST['MaNhatKy'] ?? null;

    // 1. Lấy MaThua và MaVu từ nhật ký
    $stmt = $db->conn->prepare("
        SELECT mathua AS \"MaThua\", mavu AS \"MaVu\" 
        FROM nhat_ky_canh_tac 
        WHERE manhatky = ?
    ");
    $stmt->execute([$maNhatKy]);
    $nhatKy = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$nhatKy) {
        echo json_encode(["status" => "error", "message" => "Không tìm thấy nhật ký"]);
        exit;
    }

    $maThua = $nhatKy['MaThua'];
    $maVuNhatKy = $nhatKy['MaVu'];

    // 2. Kiểm tra xem thửa đất này trong vụ đó đã thu hoạch chưa
    $stmt = $db->conn->prepare("
        SELECT COUNT(*) AS \"count\"
        FROM thu_hoach 
        WHERE mathua = ? AND mavu = ?
        LIMIT 1
    ");
    $stmt->execute([$maThua, $maVuNhatKy]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $isHarvested = $result['count'] > 0;

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

    $stmt = $db->conn->prepare("DELETE FROM nhat_ky_canh_tac WHERE manhatky = ?");

    if ($stmt->execute([$maNhatKy])) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi khi xóa nhật ký."]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Phương thức không hợp lệ."]);
}
?>