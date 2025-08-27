<?php
header("Content-Type: application/json");
session_start();

// Kiểm tra session MaNguoiDung (tương đương username)
if (!isset($_SESSION['MaNguoiDung'])) {
    http_response_code(401);
    echo json_encode([
        "status" => "error",
        "message" => "Chưa đăng nhập",
        "redirect" => true
    ]);
    exit();
}

// Session hợp lệ
echo json_encode([
    "status" => "success", 
    "message" => "Session hợp lệ",
    "user_id" => $_SESSION['MaNguoiDung'],
    "email" => $_SESSION['Email'] ?? null
]);
?>