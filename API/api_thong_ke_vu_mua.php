<?php
header("Content-Type: application/json");
session_start();

require_once __DIR__ . '/../backend/nongHo/controllers/sanluongController.php';
if (!isset($_SESSION['MaNguoiDung'])) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Chưa đăng nhập"]);
    exit();
}
$controller = new sanluongController();
$response = $controller->getThongKeVuMua();

echo json_encode($response);