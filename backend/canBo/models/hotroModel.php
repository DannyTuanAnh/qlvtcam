<?php
require_once __DIR__ . '/../../config/connect.php';

class HoTroModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getInfoHoTro() {
        $stmt = $this->db->conn->prepare("SELECT 
                ht.mahotro AS \"MaHoTro\",
                DATE(ht.ngayhotro) AS \"NgayHoTro\",
                TO_CHAR(ht.ngayhotro, 'HH24:MI:SS') AS \"Gio\",
                ht.noidung AS \"NoiDung\",
                cb.hoten AS \"CanBoHoTro\",
                nh.hoten AS \"TenNongHo\",   
                vt.mavung AS \"MaVung\"
                FROM ho_tro_ky_thuat ht
                JOIN canbo_kt cb ON ht.macanbo = cb.macanbo
                JOIN nong_ho nh ON nh.maho = ht.maho
                JOIN vung_trong vt ON vt.mavung = ht.mavung
                ORDER BY ht.ngayhotro DESC");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
        
    }

    public function updateInfoHoTro($maHoTro, $ngayHoTro, $noiDung, $maCanBo, $maNongHo, $maVung) {
        
        $stmt = $this->db->conn->prepare("
        UPDATE ho_tro_ky_thuat
        SET 
            ngayhotro = ?, 
            noidung = ?, 
            macanbo = ?, 
            maho = ?,
            mavung = ?
        WHERE 
            mahotro = ?");
        $ok = $stmt->execute([$ngayHoTro, $noiDung, $maCanBo, $maNongHo, $maVung, $maHoTro]);
        if ($ok){
            return ["status" => "success", "message" => "Cập nhật thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể cập nhật thửa đất"];
        }
    }

    public function addInfoHoTro($ngayHoTro, $noiDung, $maCanBo, $maNongHo, $maVung) {
        
        //Thêm hỗ trợ mới
        $add = $this->db->conn->prepare("INSERT INTO ho_tro_ky_thuat (ngayhotro, noidung, macanbo, maho, mavung) VALUES (?, ?, ?, ?, ?)");
        $ok = $add->execute([$ngayHoTro, $noiDung, $maCanBo, $maNongHo, $maVung]);
        if ($ok) {
            return ["status" => "success", "message" => "Thêm thửa đất thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể thêm thửa đất"];
        }

    }

    public function deleteInfoHoTro($MaHoTro) {
        
        // Xóa hỗ trợ
        $deleteQuery = "DELETE FROM ho_tro_ky_thuat WHERE mahotro = ?";
        $deleteStmt = $this->db->conn->prepare($deleteQuery);
        
        if ($deleteStmt->execute([$MaHoTro])) {
            return ["status" => "success", "message" => "Xóa thửa đất thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể xóa thửa đất"];
        }
    }
}