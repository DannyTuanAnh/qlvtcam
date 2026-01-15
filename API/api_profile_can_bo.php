<?php
session_start();
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://qlvtcam.onrender.com');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');
require_once("../backend/config/connect.php");

if(!isset($_SESSION['MaNguoiDung'])) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Chưa đăng nhập"]);
    exit();
}

function getInfoCanBo() {
    $conn = new connectDB();
    
    $sql = "SELECT 
                macanbo AS \"MaCanBo\",
                manguoidung AS \"MaNguoiDung\",
                hoten AS \"HoTen\",
                gioitinh AS \"GioiTinh\",
                ngaysinh AS \"NgaySinh\",
                sodienthoai AS \"SoDienThoai\",
                email AS \"Email\",
                donvicongtac AS \"DonViCongTac\",
                avatar AS \"avatar\"
            FROM canbo_kt WHERE manguoidung = ?";
    $stmt = $conn->conn->prepare($sql);
    $stmt->execute([$_SESSION['MaNguoiDung']]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
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