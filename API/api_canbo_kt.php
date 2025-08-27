<?php
header("Content-Type: application/json");
session_start();

require_once __DIR__ . "/../backend/canBo/controllers/canBoController.php";

if (!isset($_SESSION['MaNguoiDung'])) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Chưa đăng nhập"]);
    exit();
}

$maCanBo = $_GET['MaCanBo'] ?? '';

if (!$maCanBo) {
    echo json_encode(["status" => "error", "message" => "Thiếu mã cán bộ"]);
    exit();
}

try {
    $controller = new canboController();
    $response = $controller->getThongTinCanBo($maCanBo); // Method lấy thông tin cán bộ

    echo json_encode($response);

} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Lỗi server: " . $e->getMessage()
    ]);
}
?>