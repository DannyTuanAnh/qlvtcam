<?php
require_once __DIR__ . '/../../config/connect.php';

class VuMuaModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getInfoVuMua() {
        $stmt = $this->db->conn->prepare("SELECT 
            mavu AS \"MaVu\",
            tenvu AS \"TenVu\",
            thoigianbatdau AS \"ThoiGianBatDau\",
            thoigianthuh AS \"ThoiGianThuHoach\",
            motavu AS \"MoTaVu\"
        FROM vu_mua ORDER BY mavu");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateInfoVuMua($MaVu, $TenVu, $NgayBatDau, $NgayKetThuc, $MoTa) {
        
        $stmt = $this->db->conn->prepare("
        UPDATE vu_mua
        SET  
            tenvu = ?, 
            thoigianbatdau = ?, 
            thoigianthuh = ?, 
            motavu = ?
        WHERE 
           mavu = ?
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
        $add = $this->db->conn->prepare("INSERT INTO vu_mua (tenvu, thoigianbatdau, thoigianthuh, motavu) VALUES (?, ?, ?, ?)");
        $ok = $add->execute([$TenVu, $NgayBatDau, $NgayKetThuc, $MoTa]);
        if ($ok) {
            return ["status" => "success", "message" => "Thêm vụ mùa thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể thêm vụ mùa"];
        }

    }
    public function deleteInfoVuMua($MaVu) {
        // Kiểm tra vụ mùa có đang được sử dụng không
        $checkUsageQuery = "SELECT COUNT(*) AS \"count\" FROM nhat_ky_canh_tac WHERE mavu = ?";
        $checkUsageStmt = $this->db->conn->prepare($checkUsageQuery);
        $checkUsageStmt->execute([$MaVu]);
        $usage = $checkUsageStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($usage['count'] > 0) {
            return ["status" => "error", "message" => "Không thể xóa vụ mùa vì nó đang được sử dụng"];
        }

        // Xóa vụ mùa
        $deleteQuery = "DELETE FROM vu_mua WHERE mavu = ?";
        $deleteStmt = $this->db->conn->prepare($deleteQuery);
        
        if ($deleteStmt->execute([$MaVu])) {
            return ["status" => "success", "message" => "Xóa vụ mùa thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể xóa vụ mùa"];
        }
    }
}
    