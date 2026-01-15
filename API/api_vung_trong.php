<?php
require_once __DIR__ . '/../backend/config/connect.php'; // Kết nối CSDL

header("Content-Type: application/json");
session_start();

require_once __DIR__ . '/../backend/nongHo/controllers/profileController.php';
if (!isset($_SESSION['MaNguoiDung'])) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Chưa đăng nhập"]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $db = new connectDB();

        $stmt = $db->conn->prepare("SELECT mavung AS \"MaVung\", huyen AS \"Huyen\" FROM vung_trong");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        error_log("Found " . count($data) . " vung trong records");
        echo json_encode(["status" => "success", "data" => $data, "count" => count($data)]);
        
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        echo json_encode(["status" => "error", "message" => "Lỗi hệ thống."]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Phương thức không hợp lệ."]);
}
?>