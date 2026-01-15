<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://qlvtcam.onrender.com');

require_once("../backend/config/connect.php");

function getSanLuongTheoMua($year = 2024) {
    $conn = new connectDB();
    
    // Lấy dữ liệu theo năm được truyền vào
    $sql = "SELECT 
                vm.tenvu AS \"TenVu\",
                vm.mavu AS \"MaVu\",
                vm.thoigianbatdau AS \"ThoiGianBatDau\",
                COALESCE(SUM(th.sanluong), 0) AS \"TongSanLuong\"
            FROM vu_mua vm
            LEFT JOIN thu_hoach th ON vm.mavu = th.mavu
            WHERE EXTRACT(YEAR FROM vm.thoigianbatdau) = ?
            GROUP BY vm.mavu, vm.tenvu, vm.thoigianbatdau
            ORDER BY vm.thoigianbatdau";
    
    $stmt = $conn->conn->prepare($sql);
    $stmt->execute([$year]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $data = [];
    
    if ($result && count($result) > 0) {
        foreach ($result as $row) {
            $data[] = [
                'tenVu' => $row['TenVu'],
                'sanLuong' => round($row['TongSanLuong'] / 1000, 2) // Chuyển kg thành tấn
            ];
        }
    }
    
    return $data;
}

try {
    // Lấy parameter năm từ GET, mặc định là 2024
    $year = isset($_GET['year']) ? (int)$_GET['year'] : 2024;
    
    // Validate năm (chỉ cho phép 2024 và 2025)
    if (!in_array($year, [2024, 2025])) {
        $year = 2024;
    }
    
    $chartData = getSanLuongTheoMua($year);
    
    echo json_encode([
        "success" => true,
        "year" => $year,
        "data" => $chartData
    ], JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Lỗi: " . $e->getMessage(),
        "data" => []
    ], JSON_UNESCAPED_UNICODE);
}
?>