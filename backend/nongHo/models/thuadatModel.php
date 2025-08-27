<?php
require_once __DIR__ . '/../../config/connect.php';

class ThuaDatModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getThuaDatByID($user_id) {
        $stmt = $this->db->conn->prepare("SELECT 
    td.MaThua,
    td.DienTich,
    td.LoaiDat,
    td.ViTri
FROM 
    quan_ly_nguoi_dung qlnd
JOIN 
    nong_ho nh ON qlnd.MaNguoiDung = nh.MaNguoiDung
JOIN 
    thua_dat td ON nh.MaHo = td.MaHo
WHERE 
    qlnd.MaNguoiDung = ?;
");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Trả về mảng tất cả các thửa đất
        $thuaDatList = [];
        while ($row = $result->fetch_assoc()) {
            $thuaDatList[] = $row;
        }
        
        return $thuaDatList;
    }
}