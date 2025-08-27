<?php
session_start();
header("Content-Type: application/json");

require_once __DIR__ . '/../backend/nongHo/controllers/saubenhController.php';

if (!isset($_SESSION['MaNguoiDung'])) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Chưa đăng nhập"]);
    exit();
}
$controller = new SauBenhController();
$response = $controller->getSauBenh();

echo json_encode($response);