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
        $now = date('Y-m-d H:i:s');
        $stmt = $db->conn->prepare("SELECT MaVu, TenVu FROM vu_mua WHERE ? BETWEEN ThoiGianBatDau AND ThoiGianThuHoach");
        $stmt->bind_param("s", $now);
        $result = $stmt->execute();
        if ($result) {
            $result = $stmt->get_result();
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            error_log("Found " . count($data) . " vu mua records");
            echo json_encode(["status" => "success", "data" => $data, "count"=> count($data)]);
        } else {
            error_log("Query execution failed");
            echo json_encode(["status" => "error", "message" => "Lỗi lấy mã vụ."]);
        }
        $stmt->close();
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        echo json_encode(["status" => "error", "message" => "Lỗi hệ thống."]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Phương thức không hợp lệ."]);
}
?>