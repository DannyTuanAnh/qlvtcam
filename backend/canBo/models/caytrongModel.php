<?php
require_once __DIR__ . '/../../config/connect.php';

class CayTrongModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getInfoCayTrong() {
        $stmt = $this->db->conn->prepare("SELECT 
                    magiong AS \"MaGiong\",
                    tengiong AS \"TenGiong\",
                    dactinh AS \"DacTinh\",
                    nguongoc AS \"NguonGoc\"
                  FROM giong_cam 
                  ORDER BY magiong");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
        
    }

    public function updateInfoCayTrong($MaGiong, $TenGiong, $DacTinh, $NguonGoc) {
        
        $stmt = $this->db->conn->prepare("
        UPDATE giong_cam
        SET 
            tengiong = ?, 
            dactinh = ?, 
            nguongoc = ?
        WHERE 
            magiong = ?
        ");
        $ok = $stmt->execute([$TenGiong, $DacTinh, $NguonGoc, $MaGiong]);
        if ($ok){
            return ["status" => "success", "message" => "Cập nhật thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể cập nhật giống cam"];
        }
    }

    public function addInfoCayTrong( $TenGiong, $DacTinh, $NguonGoc) {
        //Kiểm tra tên giống đã tồn tại chưa
        $checkStmt = $this->db->conn->prepare("SELECT COUNT(*) AS \"count\" FROM giong_cam WHERE tengiong = ?");
        $checkStmt->execute([$TenGiong]);
        $result = $checkStmt->fetch(PDO::FETCH_ASSOC);
        $count = $result['count'];
        
        if ($count > 0) {
            return ["status" => "error", "message" => "Tên giống đã tồn tại"];
        }
        //Thêm giống cam mới
        $add = $this->db->conn->prepare("INSERT INTO giong_cam (tengiong, dactinh, nguongoc) VALUES (?, ?, ?)");
        $ok = $add->execute([$TenGiong, $DacTinh, $NguonGoc]);
        if ($ok) {
            return ["status" => "success", "message" => "Thêm giống cam thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể thêm giống cam"];
        }

    }

    public function deleteInfoCayTrong($MaGiong) {
    
        // Xóa giống cam
        $deleteQuery = "DELETE FROM giong_cam WHERE magiong = ?";
        $deleteStmt = $this->db->conn->prepare($deleteQuery);
        if ($deleteStmt->execute([$MaGiong])) {
            return ["status" => "success", "message" => "Xóa giống cam thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể xóa giống cam"];
        }
    }
}