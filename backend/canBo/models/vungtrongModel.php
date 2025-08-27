<?php
require_once __DIR__ . '/../../config/connect.php';

class vungtrongModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getInfoVungTrong() {
        $stmt = $this->db->conn->prepare("SELECT 
    *
FROM 
    vung_trong
ORDER BY 
    MaVung;



");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
        
    }

    public function updateInfoVungTrong($MaVung, $TenVung, $DiaChi, $Tinh, $Huyen, $Xa, $DienTich, $SoHoDan, $TrangThai, $MoTa) {
        
        $stmt = $this->db->conn->prepare("
        UPDATE vung_trong
        SET 
            TenVung = ?, 
            DiaChi = ?, 
            Tinh = ?, 
            Huyen = ?, 
            Xa = ?, 
            DienTich = ?, 
            SoHoDan = ?, 
            TrangThai = ?, 
            MoTa = ?
        WHERE 
            MaVung = ?;
        
        ");
        $stmt->bind_param("sssssdiisi", $TenVung, $DiaChi, $Tinh, $Huyen, $Xa, $DienTich, $SoHoDan, $TrangThai, $MoTa, $MaVung);
        $ok = $stmt->execute();
        $stmt->close();
        if ($ok){
            return ["status" => "success", "message" => "Cập nhật thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể cập nhật vùng trồng"];
        }
    }

    public function addInfoVungTrong( $TenVung, $DiaChi, $Tinh, $Huyen, $Xa, $DienTich, $SoHoDan, $TrangThai, $MoTa) {
        //Kiểm tra địa chỉ vùng trồng đã tồn tại chưa
        $stmt = $this->db->conn->prepare("SELECT COUNT(*) FROM vung_trong WHERE DiaChi = ? AND Tinh = ? AND Huyen = ? AND Xa = ?");
        $stmt->bind_param("ssss", $DiaChi, $Tinh, $Huyen, $Xa);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        if ($count > 0) {
            return ["status" => "error", "message" => "Địa chỉ vùng trồng đã tồn tại"];
        }
        //Thêm vùng trồng mới
        $add = $this->db->conn->prepare("INSERT INTO vung_trong (TenVung, DiaChi, Tinh, Huyen, Xa, DienTich, SoHoDan, TrangThai, MoTa) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $add->bind_param("sssssdiis", $TenVung, $DiaChi, $Tinh, $Huyen, $Xa, $DienTich, $SoHoDan, $TrangThai, $MoTa);
        $ok = $add->execute();
        $add->close();
        if ($ok) {
            return ["status" => "success", "message" => "Thêm vùng trồng thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể thêm vùng trồng"];
        }

    }

    public function deleteInfoVungTrong($MaVung) {
        // Kiểm tra vùng trồng có đang được sử dụng không
        $checkUsageQuery = "SELECT 
                              (SELECT COUNT(*) FROM thua_dat td JOIN nong_ho nh WHERE nh.MaHo = td.MaHo and nh.MaVung = ?) as thua_count,
                              (SELECT COUNT(*) FROM nong_ho WHERE MaVung = ?) as nong_ho_count";
        $checkUsageStmt = $this->db->conn->prepare($checkUsageQuery);
        $checkUsageStmt->bind_param("ii", $MaVung, $MaVung);
        $checkUsageStmt->execute();
        $usage = $checkUsageStmt->get_result()->fetch_assoc();
        $checkUsageStmt->close();
        if ($usage['thua_count'] > 0 || $usage['nong_ho_count'] > 0) {
            return ["status" => "error", "message" => "Không thể xóa vùng trồng đang được nông hộ sử dụng"];
        }

        // Xóa vùng trồng
        $deleteQuery = "DELETE FROM vung_trong WHERE MaVung = ?";
        $deleteStmt = $this->db->conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $MaVung);
        
        if ($deleteStmt->execute()) {
            return ["status" => "success", "message" => "Xóa vùng trồng thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể xóa vùng trồng"];
        }
    }
}