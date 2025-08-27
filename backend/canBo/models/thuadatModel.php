<?php
require_once __DIR__ . '/../../config/connect.php';

class ThuaDatModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getInfoThuaDat() {
        $stmt = $this->db->conn->prepare("SELECT 
                    td.MaThua,
                    td.MaHo,
                    td.DienTich,
                    td.LoaiDat,
                    td.ViTri,
                    nh.MaVung,
                    vt.TenVung,
                    nh.HoTen,
                    nh.SoDienThoai
                  FROM thua_dat td
                  LEFT JOIN nong_ho nh ON td.MaHo = nh.MaHo
                  LEFT JOIN vung_trong vt ON nh.MaVung = vt.MaVung
                    ORDER BY td.MaThua;
");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
        
    }

    public function updateInfoThuaDat($maThua, $maHo, $dienTich, $loaiDat, $viTri) {
        
        $stmt = $this->db->conn->prepare("
        UPDATE thua_dat
        SET  
            MaHo = ?, 
            DienTich = ?, 
            LoaiDat = ?, 
            ViTri = ?
        WHERE 
            MaThua = ?;
            
        
        ");
        $stmt->bind_param("idssi", $maHo, $dienTich, $loaiDat, $viTri, $maThua);
        $ok = $stmt->execute();
        $stmt->close();
        if ($ok){
            return ["status" => "success", "message" => "Cập nhật thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể cập nhật thửa đất"];
        }
    }

    public function addInfoThuaDat( $maHo, $dienTich, $loaiDat, $viTri) {
        
        //Thêm thửa đất mới
        $add = $this->db->conn->prepare("INSERT INTO thua_dat ( MaHo, DienTich, LoaiDat, ViTri) VALUES (?, ?, ?, ?)");
        $add->bind_param("idss", $maHo, $dienTich, $loaiDat, $viTri);
        $ok = $add->execute();
        $add->close();
        if ($ok) {
            return ["status" => "success", "message" => "Thêm thửa đất thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể thêm thửa đất"];
        }

    }

    public function deleteInfoThuaDat($MaThua) {
        // Kiểm tra thửa đất có đang được sử dụng không
        $checkUsageQuery = "SELECT COUNT(*) FROM giong_trong WHERE MaThua = ?";
        $checkUsageStmt = $this->db->conn->prepare($checkUsageQuery);
        $checkUsageStmt->bind_param("i", $MaThua);
        $checkUsageStmt->execute();
        $usage = $checkUsageStmt->get_result()->fetch_assoc();
        $checkUsageStmt->close();
        if ($usage['COUNT(*)'] > 0) {
            return ["status" => "error", "message" => "Không thể xóa thửa đất vì nó đang được sử dụng"];
        }

        // Xóa thửa đất
        $deleteQuery = "DELETE FROM thua_dat WHERE MaThua = ?";
        $deleteStmt = $this->db->conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $MaThua);
        
        if ($deleteStmt->execute()) {
            return ["status" => "success", "message" => "Xóa thửa đất thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể xóa thửa đất"];
        }
    }
}