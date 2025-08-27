<?php
session_start();
header("Content-Type: application/json");
if (!isset($_SESSION['MaNguoiDung'])) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Chưa đăng nhập"]);
    exit();
}
$user_id = $_SESSION['MaNguoiDung'];
if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] != 0) {
    echo json_encode(["status" => "error", "message" => "Không có file hợp lệ"]);
    exit();
}
$targetDir = "../uploads/avatars/";
if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
$ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
$filename = "avatar_" . $user_id . "_" . time() . "." . $ext;
$targetFile = $targetDir . $filename;
if (move_uploaded_file($_FILES['avatar']['tmp_name'], $targetFile)) {
    // Lưu đường dẫn vào DB
    require_once __DIR__ . '/../backend/config/connect.php';
    $db = new connectDB();
    $avatarPath = "uploads/avatars/" . $filename;
    $stmt = $db->conn->prepare("UPDATE nong_ho SET avatar=? WHERE MaNguoiDung=?");
    $stmt->bind_param("si", $avatarPath, $user_id);
    $ok = $stmt->execute();
    $stmt->close();
    echo json_encode([  
        "status" => $ok ? "success" : "error",
        "message" => $ok ? "Đã cập nhật ảnh đại diện" : "Không thể cập nhật DB",
        "avatar" => $avatarPath
    ]);
} else {
    echo json_encode(["status" => "error", "message" => "Upload thất bại"]);
}