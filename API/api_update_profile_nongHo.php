<?php
header("Content-Type: application/json");
session_start();

require_once __DIR__ . "/../backend/nongHo/controllers/profileController.php";

if (!isset($_SESSION['MaNguoiDung'])) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Chưa đăng nhập"]);
    exit();
}

$controller = new ProfileController();
$response = $controller->updateProfile();

echo json_encode($response);