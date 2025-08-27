<?php
header("Content-Type: application/json");
session_start();

require_once __DIR__ . '/../backend/nongHo/controllers/saubenhController.php';
if (!isset($_SESSION['MaNguoiDung'])) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Chưa đăng nhập"]);
    exit();
}
$controller = new SauBenhController();
$response = $controller->xoaBaoCaoSauBenh();

echo json_encode($response);