<?php
require_once __DIR__ . '/../../config/connect.php';

class SauBenhModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getInfoSauBenh() {
        $stmt = $this->db->conn->prepare("SELECT 
    DATE(phs.NgayPhatHien) AS NgayPhatHien,
    TIME(phs.NgayPhatHien) AS Gio,
    phs.MucDo,
    sb.TenSauBenh,
    nh.HoTen AS TenNongHo,   
    vm.TenVu AS Vu,
    phs.GhiChu
FROM phat_hien_sau phs
JOIN sau_benh sb ON phs.MaSau = sb.MaSau
JOIN thua_dat td ON phs.MaThua = td.MaThua
JOIN nong_ho nh ON td.MaHo = nh.MaHo
JOIN vu_mua vm ON phs.MaVu = vm.MaVu
ORDER BY phs.NgayPhatHien DESC;

");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
        
    }
}