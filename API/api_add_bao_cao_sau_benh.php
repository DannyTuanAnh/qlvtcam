<?php
header("Content-Type: application/json");
session_start();

require_once __DIR__ . '/../backend/nongHo/controllers/saubenhController.php';

if (!isset($_SESSION['MaNguoiDung'])) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Chưa đăng nhập"]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "error", "message" => "Chỉ hỗ trợ POST"]);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$required = ['ngayPhatHien', 'mucDo', 'maSau', 'maThua', 'maVu'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        echo json_encode(["status" => "error", "message" => "Thiếu trường $field"]);
        exit();
    }
}

$controller = new SauBenhController();
$response = $controller->addBaoCaoSauBenh(
    $_SESSION['MaNguoiDung'],
    $data['ngayPhatHien'],
    $data['mucDo'],
    $data['maSau'],
    $data['maThua'],
    $data['maVu'],
    isset($data['ghiChu']) ? $data['ghiChu'] : ''
);
echo json_encode($response);
