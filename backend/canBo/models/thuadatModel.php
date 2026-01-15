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
                  ORDER BY td.MaThua");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            MaThua = ?
        ");
        $ok = $stmt->execute([$maHo, $dienTich, $loaiDat, $viTri, $maThua]);
        if ($ok){
            return ["status" => "success", "message" => "Cập nhật thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể cập nhật thửa đất"];
        }
    }

    public function addInfoThuaDat( $maHo, $dienTich, $loaiDat, $viTri) {
        
        //Thêm thửa đất mới
        $add = $this->db->conn->prepare("INSERT INTO thua_dat ( MaHo, DienTich, LoaiDat, ViTri) VALUES (?, ?, ?, ?)");
        $ok = $add->execute([$maHo, $dienTich, $loaiDat, $viTri]);
        if ($ok) {
            return ["status" => "success", "message" => "Thêm thửa đất thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể thêm thửa đất"];
        }

    }

    public function deleteInfoThuaDat($MaThua) {
        // Kiểm tra thửa đất có đang được sử dụng không
        $checkUsageQuery = "SELECT COUNT(*) as count FROM giong_trong WHERE MaThua = ?";
        $checkUsageStmt = $this->db->conn->prepare($checkUsageQuery);
        $checkUsageStmt->execute([$MaThua]);
        $usage = $checkUsageStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($usage['count'] > 0) {
            return ["status" => "error", "message" => "Không thể xóa thửa đất vì nó đang được sử dụng"];
        }

        // Xóa thửa đất
        $deleteQuery = "DELETE FROM thua_dat WHERE MaThua = ?";
        $deleteStmt = $this->db->conn->prepare($deleteQuery);
        
        if ($deleteStmt->execute([$MaThua])) {
            return ["status" => "success", "message" => "Xóa thửa đất thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể xóa thửa đất"];
        }
    }
}