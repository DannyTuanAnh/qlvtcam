<?php
require_once __DIR__ . '/../../config/connect.php';

class CanhTacModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getInfoCayTrong() {
        $stmt = $this->db->conn->prepare("SELECT 
    nk.manhatky AS \"STT\",
    DATE(nk.thoigian) AS \"NgayCanhTac\",
    TO_CHAR(nk.thoigian, 'HH24:MI:SS') AS \"Gio\",
    nh.hoten AS \"NongHo\",
    vm.tenvu AS \"TenVu\",
    nk.loaihoatdong AS \"LoaiHoatDong\",
    nk.noidung AS \"NoiDung\"
FROM nhat_ky_canh_tac nk
JOIN thua_dat td ON nk.mathua = td.mathua
JOIN nong_ho nh ON td.maho = nh.maho
JOIN vu_mua vm ON nk.mavu = vm.mavu
ORDER BY nk.thoigian DESC");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
        
    }
}