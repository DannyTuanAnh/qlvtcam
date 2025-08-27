<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

require_once __DIR__ . '/../backend/canBo/controllers/thuadatController.php';

// Kiểm tra session
if (!isset($_SESSION['MaNguoiDung'])) {
    http_response_code(401);
    echo json_encode([
        'status' => 'error',
        'message' => 'Chưa đăng nhập'
    ]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$controller = new ThuaDatController();


try {
    switch ($method) {
        case 'GET':
            $response = $controller->getInfoThuaDat();
            echo json_encode($response);
            break;
        case 'POST':
            $response = $controller->addInfoThuaDat();
            echo json_encode($response);
            break;
        case 'PUT':
            $response = $controller->updateInfoThuaDat();
            echo json_encode($response);
            break;
        case 'DELETE':
            $response = $controller->deleteInfoThuaDat();
            echo json_encode($response);
            break;
        default:
            http_response_code(405);
            echo json_encode([
                'status' => 'error',
                'message' => 'Phương thức không được hỗ trợ'
            ]);
            break;
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Lỗi server: ' . $e->getMessage()
    ]);
}




?>