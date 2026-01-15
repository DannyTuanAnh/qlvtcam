<?php
require_once __DIR__ . '/../../config/connect.php';

class VuMuaModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getInfoVuMua() {
        $stmt = $this->db->conn->prepare("SELECT * FROM vu_mua order by MaVu");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateInfoVuMua($MaVu, $TenVu, $NgayBatDau, $NgayKetThuc, $MoTa) {
        
        $stmt = $this->db->conn->prepare("
        UPDATE vu_mua
        SET  
            TenVu = ?, 
            ThoiGianBatDau = ?, 
            ThoiGianThuHoach = ?, 
            MoTaVu = ?
        WHERE 
           MaVu = ?
        ");
        $ok = $stmt->execute([$TenVu, $NgayBatDau, $NgayKetThuc, $MoTa, $MaVu]);
        if ($ok){
            return ["status" => "success", "message" => "Cập nhật thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể cập nhật vụ mùa"];
        }
    }

    public function addInfoVuMua($TenVu, $NgayBatDau, $NgayKetThuc, $MoTa) {
        
        //Thêm vụ mùa mới
        $add = $this->db->conn->prepare("INSERT INTO vu_mua (TenVu, ThoiGianBatDau, ThoiGianThuHoach, MoTaVu) VALUES (?, ?, ?, ?)");
        $ok = $add->execute([$TenVu, $NgayBatDau, $NgayKetThuc, $MoTa]);
        if ($ok) {
            return ["status" => "success", "message" => "Thêm vụ mùa thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể thêm vụ mùa"];
        }

    }
    public function deleteInfoVuMua($MaVu) {
        // Kiểm tra vụ mùa có đang được sử dụng không
        $checkUsageQuery = "SELECT COUNT(*) as count FROM nhat_ky_canh_tac WHERE MaVu = ?";
        $checkUsageStmt = $this->db->conn->prepare($checkUsageQuery);
        $checkUsageStmt->execute([$MaVu]);
        $usage = $checkUsageStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($usage['count'] > 0) {
            return ["status" => "error", "message" => "Không thể xóa vụ mùa vì nó đang được sử dụng"];
        }

        // Xóa vụ mùa
        $deleteQuery = "DELETE FROM vu_mua WHERE MaVu = ?";
        $deleteStmt = $this->db->conn->prepare($deleteQuery);
        
        if ($deleteStmt->execute([$MaVu])) {
            return ["status" => "success", "message" => "Xóa vụ mùa thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể xóa vụ mùa"];
        }
    }
}
    