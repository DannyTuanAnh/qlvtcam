<?php
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
require_once("../backend/config/connect.php");

if(!isset($_SESSION['MaNguoiDung'])) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Chưa đăng nhập"]);
    exit();
}

function getInfoCanBo() {
    $conn = new connectDB();
    
    $sql = "SELECT * FROM canbo_kt WHERE MaNguoiDung = ?";
    $stmt = $conn->conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION['MaNguoiDung']);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    if ($data) {
        return [
            "status" => "success",
            "data" => $data
        ];
    } else {
        return [
            "status" => "error",
            "message" => "Không tìm thấy thông tin cán bộ."
        ];
    }
}

$result = getInfoCanBo();
echo json_encode($result);
?>