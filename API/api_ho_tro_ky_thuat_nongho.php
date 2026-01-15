<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

if (!isset($_SESSION['MaNguoiDung'])) {
    http_response_code(401);
    echo json_encode([
        'status' => 'error',
        'message' => 'Chưa đăng nhập'
    ]);
    exit;
}

require_once __DIR__ . '/../backend/config/connect.php';
$db = new connectDB();
$maNguoiDung = $_SESSION['MaNguoiDung'];

// Lấy MaHo của nông hộ này
$sqlHo = "SELECT maho AS \"MaHo\" FROM nong_ho WHERE manguoidung = ?";
$stmtHo = $db->conn->prepare($sqlHo);
if (!$stmtHo) {
    echo json_encode(["status" => "error", "message" => "SQL prepare failed"]);
    exit;
}
$stmtHo->execute([$maNguoiDung]);
$resultHo = $stmtHo->fetch(PDO::FETCH_ASSOC);
$maHo = $resultHo ? $resultHo['MaHo'] : null;

if (!$maHo) {
    echo json_encode([]);
    exit;
}

// Lấy các hỗ trợ kỹ thuật gửi cho nông hộ này
// ...existing code...
$sql = "SELECT 
            htk.noidung AS \"NoiDung\", 
            htk.ngayhotro AS \"NgayHoTro\", 
            cb.hoten AS \"hoTenCanBo\"
        FROM ho_tro_ky_thuat htk
        JOIN canbo_kt cb ON htk.macanbo = cb.macanbo
        WHERE htk.maho = ?
        ORDER BY htk.ngayhotro DESC LIMIT 10";
// ...existing code...
$stmt = $db->conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "SQL prepare failed"]);
    exit;
}
$stmt->execute([$maHo]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$messages = [];
foreach ($result as $row) {
    $messages[] = [
        "avatar" => "img/undraw_profile.svg", // Nếu có avatar cán bộ thì lấy thêm trường này
        "hoTen" => $row["hoTenCanBo"],
        "noiDung" => $row["NoiDung"],
        "thoiGian" => $row["NgayHoTro"]
    ];
}
echo json_encode($messages);