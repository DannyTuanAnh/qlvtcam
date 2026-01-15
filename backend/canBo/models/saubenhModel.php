<?php
require_once __DIR__ . '/../../config/connect.php';

class SauBenhModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getInfoSauBenh() {
        $stmt = $this->db->conn->prepare("SELECT 
    DATE(phs.ngayphathien) AS \"NgayPhatHien\",
    TO_CHAR(phs.ngayphathien, 'HH24:MI:SS') AS \"Gio\",
    phs.mucdo AS \"MucDo\",
    sb.tensaubenh AS \"TenSauBenh\",
    nh.hoten AS \"TenNongHo\",   
    vm.tenvu AS \"Vu\",
    phs.ghichu AS \"GhiChu\"
FROM phat_hien_sau phs
JOIN sau_benh sb ON phs.masau = sb.masau
JOIN thua_dat td ON phs.mathua = td.mathua
JOIN nong_ho nh ON td.maho = nh.maho
JOIN vu_mua vm ON phs.mavu = vm.mavu
ORDER BY phs.ngayphathien DESC");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
        
    }
}