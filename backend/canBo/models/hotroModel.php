<?php
require_once __DIR__ . '/../../config/connect.php';

class HoTroModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getInfoHoTro() {
        $stmt = $this->db->conn->prepare("SELECT 
                ht.MaHoTro,
                DATE(ht.NgayHoTro) AS NgayHoTro,
                TO_CHAR(ht.NgayHoTro, 'HH24:MI:SS') AS Gio,
                ht.NoiDung,
                cb.HoTen AS CanBoHoTro,
                nh.HoTen AS TenNongHo,   
                vt.MaVung
                FROM ho_tro_ky_thuat ht
                JOIN canbo_kt cb ON ht.MaCanBo = cb.MaCanBo
                JOIN nong_ho nh ON nh.MaHo = ht.MaHo
                JOIN vung_trong vt ON vt.MaVung = ht.MaVung
                ORDER BY ht.NgayHoTro DESC");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
        
    }

    public function updateInfoHoTro($maHoTro, $ngayHoTro, $noiDung, $maCanBo, $maNongHo, $maVung) {
        
        $stmt = $this->db->conn->prepare("
        UPDATE ho_tro_ky_thuat
        SET 
            NgayHoTro = ?, 
            NoiDung = ?, 
            MaCanBo = ?, 
            MaHo = ?,
            MaVung = ?
        WHERE 
            MaHoTro = ?");
        $ok = $stmt->execute([$ngayHoTro, $noiDung, $maCanBo, $maNongHo, $maVung, $maHoTro]);
        if ($ok){
            return ["status" => "success", "message" => "Cập nhật thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể cập nhật thửa đất"];
        }
    }

    public function addInfoHoTro($ngayHoTro, $noiDung, $maCanBo, $maNongHo, $maVung) {
        
        //Thêm hỗ trợ mới
        $add = $this->db->conn->prepare("INSERT INTO ho_tro_ky_thuat (NgayHoTro, NoiDung, MaCanBo, MaHo, MaVung) VALUES (?, ?, ?, ?, ?)");
        $ok = $add->execute([$ngayHoTro, $noiDung, $maCanBo, $maNongHo, $maVung]);
        if ($ok) {
            return ["status" => "success", "message" => "Thêm thửa đất thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể thêm thửa đất"];
        }

    }

    public function deleteInfoHoTro($MaHoTro) {
        
        // Xóa hỗ trợ
        $deleteQuery = "DELETE FROM ho_tro_ky_thuat WHERE MaHoTro = ?";
        $deleteStmt = $this->db->conn->prepare($deleteQuery);
        
        if ($deleteStmt->execute([$MaHoTro])) {
            return ["status" => "success", "message" => "Xóa thửa đất thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể xóa thửa đất"];
        }
    }
}