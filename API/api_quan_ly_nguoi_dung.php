<?php
header("Content-Type: application/json");
session_start();

require_once __DIR__ . '/../backend/canBo/controllers/nguoidungController.php';
if (!isset($_SESSION['MaNguoiDung'])) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Chưa đăng nhập"]);
    exit();
}
$controller = new NguoiDungController();
$response = $controller->getNguoiDung();

echo json_encode($response);