<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once("../backend/config/connect.php");

function getTongSanLuong2024() {
    $conn = new connectDB();
    
    $sql = "SELECT SUM(SanLuong) as TongSanLuong FROM thu_hoach WHERE YEAR(NgayThuHoach) = 2024";
    $result = mysqli_query($conn->conn, $sql);
    $tongSanLuong = 0;
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $tongSanLuong = $row['TongSanLuong'] ?? 0;
    }
    
    return number_format($tongSanLuong/1000, 2);
}

function getSoNongHo() {
    $conn = new connectDB();
    
    $sql = "SELECT COUNT(*) as SoNongHo FROM nong_ho";
    $result = mysqli_query($conn->conn, $sql);
    $soNongHo = 0;
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $soNongHo = $row['SoNongHo'] ?? 0;
    }
    
    return $soNongHo;
}

function getSoThuaDat() {
    $conn = new connectDB();
    
    $sql = "SELECT COUNT(*) as SoThuaDat FROM thua_dat";
    $result = mysqli_query($conn->conn, $sql);
    $soThuaDat = 0;
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $soThuaDat = $row['SoThuaDat'] ?? 0;
    }
    
    return $soThuaDat;
}

function getVuMuaHienTai() {
    $conn = new connectDB();
    
    // Lấy vụ mùa mới nhất dựa trên ThoiGianBatDau
    $sql = "SELECT *
FROM vu_mua
WHERE NOW() BETWEEN ThoiGianBatDau AND ThoiGianThuHoach;";
    
    $result = mysqli_query($conn->conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        // Lấy thông tin vụ mùa từ database
        $tenVu = $row['TenVu'] ?? '';
        
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