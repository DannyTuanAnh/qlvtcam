<?php
require_once __DIR__ . '/../../config/connect.php';

class ThuaDatModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getThuaDatByID($user_id) {
        $stmt = $this->db->conn->prepare("SELECT 
    td.mathua AS \"MaThua\",
    td.dientich AS \"DienTich\",
    td.loaidat AS \"LoaiDat\",
    td.vitri AS \"ViTri\"
FROM 
    quan_ly_nguoi_dung qlnd
JOIN 
    nong_ho nh ON qlnd.manguoidung = nh.manguoidung
JOIN 
    thua_dat td ON nh.maho = td.maho
WHERE 
    qlnd.manguoidung = ?");
        $stmt->execute([$user_id]);
        
        // Trả về mảng tất cả các thửa đất
        $thuaDatList = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $thuaDatList;
    }
}