<?php
require_once __DIR__ . '/../../config/connect.php';

class CayTrongModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getInfoCayTrong() {
        $stmt = $this->db->conn->prepare("SELECT 
                    *
                  FROM giong_cam 
                  ORDER BY MaGiong;
");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
        
    }

    public function updateInfoCayTrong($MaGiong, $TenGiong, $DacTinh, $NguonGoc) {
        
        $stmt = $this->db->conn->prepare("
        UPDATE giong_cam
        SET 
            TenGiong = ?, 
            DacTinh = ?, 
            NguonGoc = ?
        WHERE 
            MaGiong = ?;
        
        ");
        $stmt->bind_param("sssi", $TenGiong, $DacTinh, $NguonGoc, $MaGiong);
        $ok = $stmt->execute();
        $stmt->close();
        if ($ok){
            return ["status" => "success", "message" => "Cập nhật thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể cập nhật giống cam"];
        }
    }

    public function addInfoCayTrong( $TenGiong, $DacTinh, $NguonGoc) {
        //Kiểm tra tên giống đã tồn tại chưa
        $checkStmt = $this->db->conn->prepare("SELECT COUNT(*) as count FROM giong_cam WHERE TenGiong = ?");
        $checkStmt->bind_param("s", $TenGiong);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();
        if ($count > 0) {
            return ["status" => "error", "message" => "Tên giống đã tồn tại"];
        }
        //Thêm giống cam mới
        $add = $this->db->conn->prepare("INSERT INTO giong_cam (TenGiong, DacTinh, NguonGoc) VALUES (?, ?, ?)");
        $add->bind_param("sss", $TenGiong, $DacTinh, $NguonGoc);
        $ok = $add->execute();
        $add->close();
        if ($ok) {
            return ["status" => "success", "message" => "Thêm giống cam thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể thêm giống cam"];
        }

    }

    public function deleteInfoCayTrong($MaGiong) {
    
        // Xóa giống cam
        $deleteQuery = "DELETE FROM giong_cam WHERE MaGiong = ?";
        $deleteStmt = $this->db->conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $MaGiong);
        if ($deleteStmt->execute()) {
            return ["status" => "success", "message" => "Xóa giống cam thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể xóa giống cam"];
        }
    }
}