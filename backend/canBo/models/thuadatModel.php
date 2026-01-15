<?php
require_once __DIR__ . '/../../config/connect.php';

class ThuaDatModel{

    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getInfoThuaDat() {
        $stmt = $this->db->conn->prepare("SELECT 
                    td.mathua AS \"MaThua\",
                    td.maho AS \"MaHo\",
                    td.dientich AS \"DienTich\",
                    td.loaidat AS \"LoaiDat\",
                    td.vitri AS \"ViTri\",
                    nh.mavung AS \"MaVung\",
                    vt.tenvung AS \"TenVung\",
                    nh.hoten AS \"HoTen\",
                    nh.sodienthoai AS \"SoDienThoai\"
                  FROM thua_dat td
                  LEFT JOIN nong_ho nh ON td.maho = nh.maho
                  LEFT JOIN vung_trong vt ON nh.mavung = vt.mavung
                  ORDER BY td.mathua");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
        
    }

    public function updateInfoThuaDat($maThua, $maHo, $dienTich, $loaiDat, $viTri) {
        
        $stmt = $this->db->conn->prepare("
        UPDATE thua_dat
        SET  
            maho = ?, 
            dientich = ?, 
            loaidat = ?, 
            vitri = ?
        WHERE 
            mathua = ?
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
        $add = $this->db->conn->prepare("INSERT INTO thua_dat (maho, dientich, loaidat, vitri) VALUES (?, ?, ?, ?)");
        $ok = $add->execute([$maHo, $dienTich, $loaiDat, $viTri]);
        if ($ok) {
            return ["status" => "success", "message" => "Thêm thửa đất thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể thêm thửa đất"];
        }

    }

    public function deleteInfoThuaDat($MaThua) {
        // Kiểm tra thửa đất có đang được sử dụng không
        $checkUsageQuery = "SELECT COUNT(*) AS \"count\" FROM giong_trong WHERE mathua = ?";
        $checkUsageStmt = $this->db->conn->prepare($checkUsageQuery);
        $checkUsageStmt->execute([$MaThua]);
        $usage = $checkUsageStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($usage['count'] > 0) {
            return ["status" => "error", "message" => "Không thể xóa thửa đất vì nó đang được sử dụng"];
        }

        // Xóa thửa đất
        $deleteQuery = "DELETE FROM thua_dat WHERE mathua = ?";
        $deleteStmt = $this->db->conn->prepare($deleteQuery);
        
        if ($deleteStmt->execute([$MaThua])) {
            return ["status" => "success", "message" => "Xóa thửa đất thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể xóa thửa đất"];
        }
    }
}