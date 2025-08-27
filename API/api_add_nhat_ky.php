<?php
header("Content-Type: application/json");
session_start();

require_once __DIR__ . "/../backend/nongHo/controllers/nhatkyController.php";

if (!isset($_SESSION['MaNguoiDung'])) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Chưa đăng nhập"]);
    exit();
}

try {
    $controller = new nhatkyController();
    $response = $controller->addNhatKy(); // Method thêm mới
    
    echo json_encode($response);
    
} catch (Exception $e) {
    echo json_encode([
        "status" => "error",
        "message" => "Lỗi server: " . $e->getMessage()
    ]);
}
?>