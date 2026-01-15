<?php
require_once __DIR__ . '/../../config/connect.php';

class NguoiDungModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getInfoNguoiDung() {
        $stmt = $this->db->conn->prepare("SELECT 
    nh.hoten AS \"HoTen\",
    nh.gioitinh AS \"GioiTinh\",
    nh.ngaysinh AS \"NgaySinh\",
    nh.diachi AS \"DiaChi\",
    nh.sodienthoai AS \"SoDienThoai\",
    nh.email AS \"Email\",
    COUNT(td.mathua) AS \"SoThuaDat\"
FROM 
    nong_ho nh
LEFT JOIN 
    thua_dat td ON nh.maho = td.maho
GROUP BY 
    nh.maho, nh.hoten, nh.gioitinh, nh.ngaysinh, nh.diachi, nh.sodienthoai, nh.email
ORDER BY 
    nh.maho");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
        
    }
}