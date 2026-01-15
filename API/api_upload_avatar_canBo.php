<?php
header("Content-Type: application/json");
session_start();

require_once __DIR__ . '/../backend/config/connect.php';

if (!isset($_SESSION['MaNguoiDung'])) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Chưa đăng nhập"]);
    exit();
}

if (!isset($_POST['MaCanBo']) || !isset($_FILES['avatar'])) {
    echo json_encode(["status" => "error", "message" => "Thiếu dữ liệu gửi lên"]);
    exit();
}

$maCanBo = $_POST['MaCanBo'];
$file = $_FILES['avatar'];
$targetDir = __DIR__ . '/../uploads/avatars/';
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = 'canbo_' . $maCanBo . '_' . time() . '.' . $ext;
$targetFile = $targetDir . $filename;

if (move_uploaded_file($file['tmp_name'], $targetFile)) {
    // Lưu tên file vào DB
    $db = new connectDB();
    $conn = $db->conn;
    $stmt = $conn->prepare("UPDATE canbo_kt SET avatar = ? WHERE macanbo = ?");
    if ($stmt->execute([$filename, $maCanBo])) {
        echo json_encode(["status" => "success", "filename" => $filename]);
    } else {
        echo json_encode(["status" => "error", "message" => "Lỗi cập nhật DB"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Lỗi upload file"]);
}
?>
