<?php
require_once __DIR__ . '/../../config/connect.php';

class NongHoModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getInfoNongHo() {
        $stmt = $this->db->conn->prepare("SELECT 
                    nh.MaHo,
                    nh.HoTen,
                    nh.GioiTinh,
                    nh.SoDienThoai,
                    nh.Email,
                    nh.NgaySinh,
                    nh.MaVung,
                    nh.DiaChi,
                    vt.TenVung,
                    COUNT(td.MaThua) as SoThua
                  FROM nong_ho nh
                  LEFT JOIN vung_trong vt ON nh.MaVung = vt.MaVung
                  LEFT JOIN thua_dat td ON nh.MaHo = td.MaHo
                  GROUP BY nh.MaHo, nh.HoTen, nh.GioiTinh, nh.SoDienThoai, nh.Email, nh.NgaySinh, nh.MaVung, nh.DiaChi, vt.TenVung
                  ORDER BY nh.HoTen");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function updateInfoNongHo($maHo, $hoTen, $gioiTinh, $soDienThoai, $email, $ngaySinh, $maVung, $diaChi) {
        $stmt = $this->db->conn->prepare("
            UPDATE nong_ho
            SET 
                HoTen = ?, 
                GioiTinh = ?, 
                SoDienThoai = ?, 
                Email = ?, 
                NgaySinh = ?, 
                MaVung = ?,
                DiaChi = ?
            WHERE 
                MaHo = ?");
        $ok = $stmt->execute([$hoTen, $gioiTinh, $soDienThoai, $email, $ngaySinh, $maVung, $diaChi, $maHo]);
        if ($ok){
            return ["status" => "success", "message" => "Cập nhật nông hộ thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể cập nhật nông hộ"];
        }
    }

    public function addInfoNongHo($hoTen, $sdt, $gioiTinh, $ngaySinh, $tinh, $huyen, $xa, $ap, $email, $pass, $diaChi) {
        // Kiểm tra số điện thoại đã tồn tại chưa
        $checkStmt = $this->db->conn->prepare("SELECT COUNT(*) as count FROM nong_ho WHERE SoDienThoai = ?");
        $checkStmt->execute([$sdt]);
        $result = $checkStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['count'] > 0) {
            return ["status" => "error", "message" => "Số điện thoại đã được sử dụng"];
        }
        //Lấy mã vùng trồng
        $vt = $this->db->conn->prepare("SELECT MaVung FROM vung_trong WHERE DiaChi = ? AND Xa = ? AND Huyen = ? AND Tinh = ?");
        $vt->execute([$ap, $xa, $huyen, $tinh]);
        $vtResult = $vt->fetch(PDO::FETCH_ASSOC);
        $ma_vt = $vtResult ? $vtResult['MaVung'] : null;

        //thêm nông hộ vào bảng người dung
        $qlnd = $this->db->conn->prepare("INSERT INTO quan_ly_nguoi_dung (HoTen, Email, MatKhau, SoDienThoai, VaiTro) VALUES (?,?,?,?,'nongho')");
        $qlnd->execute([$hoTen, $email, $pass, $sdt]);

        //lấy mã người dùng
        $nd = $this->db->conn->prepare("SELECT MaNguoiDung FROM quan_ly_nguoi_dung WHERE Email = ?");
        $nd->execute([$email]);
        $ndResult = $nd->fetch(PDO::FETCH_ASSOC);
        $ma_nd = $ndResult ? $ndResult['MaNguoiDung'] : null;
        
        // Thêm nông hộ mới
        $add = $this->db->conn->prepare("
        INSERT INTO nong_ho (HoTen, GioiTinh, NgaySinh, SoDienThoai, Email, MaVung, DiaChi, MaNguoiDung) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $ok = $add->execute([$hoTen, $gioiTinh, $ngaySinh, $sdt, $email, $ma_vt, $diaChi, $ma_nd]);

        //Cập nhật số lượng nông hộ cho vùng trồng
        if ($ma_vt) {
            $updateVung = $this->db->conn->prepare("UPDATE vung_trong SET SoHoDan = SoHoDan + 1 WHERE MaVung = ?");
            $updateVung->execute([$ma_vt]);
        }

        if ($ok) {
            return ["status" => "success", "message" => "Thêm nông hộ thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể thêm nông hộ"];
        }
    }

    public function deleteInfoNongHo($maHo) {
        // Kiểm tra nông hộ có thửa đất không
        $checkUsageQuery = "SELECT COUNT(*) as thua_count FROM thua_dat WHERE MaHo = ?";
        $checkUsageStmt = $this->db->conn->prepare($checkUsageQuery);
        $checkUsageStmt->execute([$maHo]);
        $usage = $checkUsageStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($usage['thua_count'] > 0) {
            return ["status" => "error", "message" => "Không thể xóa nông hộ đang có thửa đất"];
        }

        //Cập nhật số lượng nông hộ cho vùng trồng (lấy trước khi xóa)
        $vungQuery = "SELECT MaVung FROM nong_ho WHERE MaHo = ?";
        $vungStmt = $this->db->conn->prepare($vungQuery);
        $vungStmt->execute([$maHo]);
        $vungResult = $vungStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($vungResult) {
            $ma_vung = $vungResult['MaVung'];
            $updateVung = $this->db->conn->prepare("UPDATE vung_trong SET SoHoDan = GREATEST(SoHoDan - 1, 0) WHERE MaVung = ?");
            $updateVung->execute([$ma_vung]);
        }

        // Xóa nông hộ
        $deleteQuery = "DELETE FROM nong_ho WHERE MaHo = ?";
        $deleteStmt = $this->db->conn->prepare($deleteQuery);
        
        if ($deleteStmt->execute([$maHo])) {
            return ["status" => "success", "message" => "Xóa nông hộ thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể xóa nông hộ"];
        }
    }
}
?>