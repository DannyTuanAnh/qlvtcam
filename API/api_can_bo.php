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

require_once __DIR__ . '/../backend/config/connect.php';

//Kiểm tra session
if (!isset($_SESSION['MaNguoiDung'])) {
    http_response_code(401);
    echo json_encode([
        'status' => 'error',
        'message' => 'Chưa đăng nhập'
    ]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
try {
    switch ($method) {
        case 'GET':
            $conn = new connectDB();
            $stmt = $conn->conn->prepare("SELECT * FROM canbo_kt where MaNguoiDung = ?");
            $stmt->bind_param("s", $_SESSION['MaNguoiDung']);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            echo json_encode([
                'status' => 'success',
                'data' => $result
            ]);
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