<?php
require_once __DIR__ . '/../../config/connect.php';

class CanhTacModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getInfoCayTrong() {
        $stmt = $this->db->conn->prepare("SELECT 
    nk.MaNhatKy AS STT,
    DATE(nk.ThoiGian) AS NgayCanhTac,
    TIME(nk.ThoiGian) AS Gio,
    nh.HoTen AS NongHo,
    vm.TenVu,
    nk.LoaiHoatDong,
    nk.NoiDung
FROM nhat_ky_canh_tac nk
JOIN thua_dat td ON nk.MaThua = td.MaThua
JOIN nong_ho nh ON td.MaHo = nh.MaHo
JOIN vu_mua vm ON nk.MaVu = vm.MaVu
ORDER BY nk.ThoiGian DESC;

");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
        
    }
}