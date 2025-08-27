<?php
require_once __DIR__ . '/../../config/connect.php';

class NguoiDungModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getInfoNguoiDung() {
        $stmt = $this->db->conn->prepare("SELECT 
    nh.HoTen,
    nh.GioiTinh,
    nh.NgaySinh,
    nh.DiaChi,
    nh.SoDienThoai,
    nh.Email,
    COUNT(td.MaThua) AS SoThuaDat
FROM 
    nong_ho nh
LEFT JOIN 
    thua_dat td ON nh.MaHo = td.MaHo
GROUP BY 
    nh.MaHo, nh.HoTen, nh.GioiTinh, nh.NgaySinh, nh.DiaChi, nh.SoDienThoai, nh.Email
ORDER BY 
    nh.MaHo;



");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
        
    }
}