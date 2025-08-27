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
$sqlHo = "SELECT MaHo FROM nong_ho WHERE MaNguoiDung = ?";
$stmtHo = $db->conn->prepare($sqlHo);
if (!$stmtHo) {
    echo json_encode(["status" => "error", "message" => "SQL prepare failed: " . $db->conn->error]);
    exit;
}
$stmtHo->bind_param("i", $maNguoiDung);
$stmtHo->execute();
$stmtHo->bind_result($maHo);
$stmtHo->fetch();
$stmtHo->close();

if (!$maHo) {
    echo json_encode([]);
    exit;
}

// Lấy các hỗ trợ kỹ thuật gửi cho nông hộ này
// ...existing code...
$sql = "SELECT htk.NoiDung, htk.NgayHoTro, cb.HoTen AS hoTenCanBo
        FROM ho_tro_ky_thuat htk
        JOIN canbo_kt cb ON htk.MaCanBo = cb.MaCanBo
        WHERE htk.MaHo = ?
        ORDER BY htk.NgayHoTro DESC LIMIT 10";
// ...existing code...
$stmt = $db->conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "SQL prepare failed: " . $db->conn->error]);
    exit;
}
$stmt->bind_param("i", $maHo);
$stmt->execute();
$result = $stmt->get_result();
$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = [
        "avatar" => "img/undraw_profile.svg", // Nếu có avatar cán bộ thì lấy thêm trường này
        "hoTen" => $row["hoTenCanBo"],
        "noiDung" => $row["NoiDung"],
        "thoiGian" => $row["NgayHoTro"]
    ];
}
echo json_encode($messages);