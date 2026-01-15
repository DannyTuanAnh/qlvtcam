<?php
require_once __DIR__ . '/../../config/connect.php';

class vungtrongModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getInfoVungTrong() {
        $stmt = $this->db->conn->prepare("SELECT 
    mavung AS \"MaVung\",
    tenvung AS \"TenVung\",
    diachi AS \"DiaChi\",
    tinh AS \"Tinh\",
    huyen AS \"Huyen\",
    xa AS \"Xa\",
    dientich AS \"DienTich\",
    sohodan AS \"SoHoDan\",
    trangthai AS \"TrangThai\",
    mota AS \"MoTa\"
FROM 
    vung_trong
ORDER BY 
    mavung");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
        
    }

    public function updateInfoVungTrong($MaVung, $TenVung, $DiaChi, $Tinh, $Huyen, $Xa, $DienTich, $SoHoDan, $TrangThai, $MoTa) {
        
        $stmt = $this->db->conn->prepare("
        UPDATE vung_trong
        SET 
            tenvung = ?, 
            diachi = ?, 
            tinh = ?, 
            huyen = ?, 
            xa = ?, 
            dientich = ?, 
            sohodan = ?, 
            trangthai = ?, 
            mota = ?
        WHERE 
            mavung = ?
        ");
        $ok = $stmt->execute([$TenVung, $DiaChi, $Tinh, $Huyen, $Xa, $DienTich, $SoHoDan, $TrangThai, $MoTa, $MaVung]);
        if ($ok){
            return ["status" => "success", "message" => "Cập nhật thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể cập nhật vùng trồng"];
        }
    }

    public function addInfoVungTrong( $TenVung, $DiaChi, $Tinh, $Huyen, $Xa, $DienTich, $SoHoDan, $TrangThai, $MoTa) {
        //Kiểm tra địa chỉ vùng trồng đã tồn tại chưa
        $stmt = $this->db->conn->prepare("SELECT COUNT(*) AS \"count\" FROM vung_trong WHERE diachi = ? AND tinh = ? AND huyen = ? AND xa = ?");
        $stmt->execute([$DiaChi, $Tinh, $Huyen, $Xa]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $result['count'];
        
        if ($count > 0) {
            return ["status" => "error", "message" => "Địa chỉ vùng trồng đã tồn tại"];
        }
        //Thêm vùng trồng mới
        $add = $this->db->conn->prepare("INSERT INTO vung_trong (tenvung, diachi, tinh, huyen, xa, dientich, sohodan, trangthai, mota) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $ok = $add->execute([$TenVung, $DiaChi, $Tinh, $Huyen, $Xa, $DienTich, $SoHoDan, $TrangThai, $MoTa]);
        if ($ok) {
            return ["status" => "success", "message" => "Thêm vùng trồng thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể thêm vùng trồng"];
        }

    }

    public function deleteInfoVungTrong($MaVung) {
        // Kiểm tra vùng trồng có đang được sử dụng không
        $checkUsageQuery = "SELECT 
                              (SELECT COUNT(*) FROM thua_dat td JOIN nong_ho nh ON nh.maho = td.maho WHERE nh.mavung = ?) AS \"thua_count\",
                              (SELECT COUNT(*) FROM nong_ho WHERE mavung = ?) AS \"nong_ho_count\"";
        $checkUsageStmt = $this->db->conn->prepare($checkUsageQuery);
        $checkUsageStmt->execute([$MaVung, $MaVung]);
        $usage = $checkUsageStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($usage['thua_count'] > 0 || $usage['nong_ho_count'] > 0) {
            return ["status" => "error", "message" => "Không thể xóa vùng trồng đang được nông hộ sử dụng"];
        }

        // Xóa vùng trồng
        $deleteQuery = "DELETE FROM vung_trong WHERE mavung = ?";
        $deleteStmt = $this->db->conn->prepare($deleteQuery);
        
        if ($deleteStmt->execute([$MaVung])) {
            return ["status" => "success", "message" => "Xóa vùng trồng thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể xóa vùng trồng"];
        }
    }
}