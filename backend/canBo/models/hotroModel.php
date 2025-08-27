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
                TIME(ht.NgayHoTro) AS Gio,
                ht.NoiDung,
                cb.HoTen AS CanBoHoTro,
                nh.HoTen AS TenNongHo,   
                vt.MaVung
                FROM ho_tro_ky_thuat ht
                JOIN canbo_kt cb ON ht.MaCanBo = cb.MaCanBo
                JOIN nong_ho nh ON nh.MaHo = ht.MaHo
                JOIN vung_trong vt ON vt.MaVung = ht.MaVung
                ORDER BY ht.NgayHoTro DESC;
            ");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
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
        $stmt->bind_param("ssiiii", $ngayHoTro, $noiDung, $maCanBo, $maNongHo, $maVung, $maHoTro);
        $ok = $stmt->execute();
        $stmt->close();
        if ($ok){
            return ["status" => "success", "message" => "Cập nhật thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể cập nhật thửa đất"];
        }
    }

    public function addInfoHoTro($ngayHoTro, $noiDung, $maCanBo, $maNongHo, $maVung) {
        
        //Thêm hỗ trợ mới
        $add = $this->db->conn->prepare("INSERT INTO ho_tro_ky_thuat (NgayHoTro, NoiDung, MaCanBo, MaHo, MaVung) VALUES (?, ?, ?, ?, ?)");
        $add->bind_param("ssiii", $ngayHoTro, $noiDung, $maCanBo, $maNongHo, $maVung);
        $ok = $add->execute();
        $add->close();
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
        $deleteStmt->bind_param("i", $MaHoTro);
        
        if ($deleteStmt->execute()) {
            return ["status" => "success", "message" => "Xóa thửa đất thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể xóa thửa đất"];
        }
    }
}