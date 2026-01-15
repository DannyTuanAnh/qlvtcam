<?php
require_once __DIR__ . '/../../config/connect.php';

class ProfileModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getUserById($user_id) {
        $stmt = $this->db->conn->prepare("SELECT 
    nh.MaHo,
    nh.HoTen AS HoTenNongHo,
    nh.GioiTinh,
    nh.NgaySinh,
    nh.DiaChi,
    nh.SoDienThoai AS SDTNongHo,
    nh.Email AS EmailNongHo,
    nh.MaVung,
    nh.avatar,
    COUNT(td.MaThua) AS SoThuadat
FROM 
    quan_ly_nguoi_dung qlnd
JOIN 
    nong_ho nh ON qlnd.MaNguoiDung = nh.MaNguoiDung
LEFT JOIN 
    thua_dat td ON nh.MaHo = td.MaHo
WHERE 
    qlnd.MaNguoiDung = ?
GROUP BY 
    qlnd.MaNguoiDung, nh.MaHo, nh.HoTen, nh.GioiTinh, nh.NgaySinh, nh.DiaChi, nh.SoDienThoai, nh.Email, nh.MaVung, nh.Avatar");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function updateUserById($user_id, $hoTen, $gioiTinh, $ngaySinh, $ap, $xa, $huyen, $tinh, $diaChiFull, $sdt, $email) {
        //1. Lấy mã vùng trồng trước khi update
        $query = $this->db->conn->prepare("
            SELECT MaVung FROM nong_ho 
            WHERE MaNguoiDung = ?
        ");
        $query->execute([$user_id]);
        $row_cu = $query->fetch(PDO::FETCH_ASSOC);
        $maVungCu = $row_cu ? $row_cu['MaVung'] : null;

        // 2. Lấy MaVung từ vung_trong
        $stmt = $this->db->conn->prepare("
            SELECT MaVung FROM vung_trong 
            WHERE DiaChi = ? AND Xa = ? AND Huyen = ? AND Tinh = ?
            LIMIT 1
        ");
        $stmt->execute([$ap, $xa, $huyen, $tinh]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $maVung = $row ? $row['MaVung'] : null;

        if (!$maVung) {
            return ["status" => "error", "message" => "Không tìm thấy vùng trồng phù hợp"];
        }

         // 3. Update nong_ho
        $stmt = $this->db->conn->prepare("
            UPDATE nong_ho nh
            SET nh.DiaChi = ?, nh.MaVung = ?, nh.SoDienThoai = ?, nh.Email = ?, 
                nh.HoTen = ?, nh.GioiTinh = ?, nh.NgaySinh = ?
            WHERE nh.MaNguoiDung = ?
        ");
        $ok = $stmt->execute([$diaChiFull, $maVung, $sdt, $email, $hoTen, $gioiTinh, $ngaySinh, $user_id]);

        // 4. Cập nhật số lượng nông hộ cho vùng trồng mới vừa chọn
        if ($maVungCu !== $maVung) {
            if ($maVungCu) {
                $updateVungCu = $this->db->conn->prepare("UPDATE vung_trong SET SoHoDan = GREATEST(SoHoDan - 1, 0) WHERE MaVung = ?");
                $updateVungCu->execute([$maVungCu]);
            }
            if ($maVung) {
                $updateVungMoi = $this->db->conn->prepare("UPDATE vung_trong SET SoHoDan = SoHoDan + 1 WHERE MaVung = ?");
                $updateVungMoi->execute([$maVung]);
            }
        }

        return $ok ? ["status" => "success"] : ["status" => "error", "message" => "Không thể cập nhật"];
    }

}