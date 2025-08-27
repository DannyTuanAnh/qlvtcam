<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once("../backend/config/connect.php");

function getSanLuongTheoMua($year = 2024) {
    $conn = new connectDB();
    
    // Lấy dữ liệu theo năm được truyền vào
    $sql = "SELECT 
                vm.TenVu,
                vm.MaVu,
                vm.ThoiGianBatDau,
                COALESCE(SUM(th.SanLuong), 0) as TongSanLuong
            FROM vu_mua vm
            LEFT JOIN thu_hoach th ON vm.MaVu = th.MaVu
            WHERE YEAR(vm.ThoiGianBatDau) = ?
            GROUP BY vm.MaVu, vm.TenVu, vm.ThoiGianBatDau
            ORDER BY vm.ThoiGianBatDau";
    
    $stmt = $conn->conn->prepare($sql);
    $stmt->bind_param("i", $year);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = [];
    
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = [
                'tenVu' => $row['TenVu'],
                'sanLuong' => round($row['TongSanLuong'] / 1000, 2) // Chuyển kg thành tấn
            ];
        }
    }
    
    $stmt->close();
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