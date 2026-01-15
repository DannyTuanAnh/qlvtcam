<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once("../backend/config/connect.php");

function getTongSanLuong2024() {
    $conn = new connectDB();
    
    $sql = "SELECT SUM(sanluong) AS \"TongSanLuong\" FROM thu_hoach WHERE EXTRACT(YEAR FROM ngaythuhoach) = 2024";
    $stmt = $conn->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $tongSanLuong = 0;
    
    if ($result) {
        $tongSanLuong = $result['TongSanLuong'] ?? 0;
    }
    
    return number_format($tongSanLuong/1000, 2);
}

function getSoNongHo() {
    $conn = new connectDB();
    
    $sql = "SELECT COUNT(*) AS \"SoNongHo\" FROM nong_ho";
    $stmt = $conn->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $soNongHo = 0;
    
    if ($result) {
        $soNongHo = $result['SoNongHo'] ?? 0;
    }
    
    return $soNongHo;
}

function getSoThuaDat() {
    $conn = new connectDB();
    
    $sql = "SELECT COUNT(*) AS \"SoThuaDat\" FROM thua_dat";
    $stmt = $conn->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $soThuaDat = 0;
    
    if ($result) {
        $soThuaDat = $result['SoThuaDat'] ?? 0;
    }
    
    return $soThuaDat;
}

function getVuMuaHienTai() {
    $conn = new connectDB();
    
    // Lấy vụ mùa mới nhất dựa trên ThoiGianBatDau
    $sql = "SELECT 
                tenvu AS \"TenVu\",
                thoigianbatdau AS \"ThoiGianBatDau\",
                thoigianthuhoach AS \"ThoiGianThuHoach\"
            FROM vu_mua
            WHERE NOW() BETWEEN thoigianbatdau AND thoigianthuhoach";
    
    $stmt = $conn->conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        // Lấy thông tin vụ mùa từ database
        $tenVu = $result['TenVu'] ?? '';
        
        // Nếu có thông tin vụ mùa từ database
        if (!empty($tenVu)) {
            return $tenVu;
        }
    }

    
    //Fallback: Nếu không có dữ liệu trong database, tính toán theo thời gian hiện tại
    $thang = date('n'); // Tháng hiện tại (1-12)
    $nam = date('Y');   // Năm hiện tại
    
    // Xác định mùa dựa trên tháng hiện tại
    if ($thang >= 1 && $thang <= 3) {
        $mua = "Xuân";
    } elseif ($thang >= 4 && $thang <= 6) {
        $mua = "Hạ";
    } elseif ($thang >= 7 && $thang <= 9) {
        $mua = "Thu";
    } else { // tháng 10, 11, 12
        $mua = "Đông";
    }
    
    return $mua . " " . $nam;
}

try {
    $tongSanLuong = getTongSanLuong2024();
    $soNongHo = getSoNongHo();
    $soThuaDat = getSoThuaDat();
    $vuMuaHienTai = getVuMuaHienTai();
    
    echo json_encode([
        "success" => true,
        "data" => [
            "tongSanLuong" => $tongSanLuong,
            "soNongHo" => $soNongHo,
            "soThuaDat" => $soThuaDat,
            "vuMuaHienTai" => $vuMuaHienTai
        ]
    ], JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Lỗi: " . $e->getMessage(),
        "data" => []
    ], JSON_UNESCAPED_UNICODE);
}
?>