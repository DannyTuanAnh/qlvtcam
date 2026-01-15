<?php
require_once __DIR__ . '/../../config/connect.php';

class ProfileModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getUserById($user_id) {
        $stmt = $this->db->conn->prepare("SELECT 
    nh.maho AS \"MaHo\",
    nh.hoten AS \"HoTenNongHo\",
    nh.gioitinh AS \"GioiTinh\",
    nh.ngaysinh AS \"NgaySinh\",
    nh.diachi AS \"DiaChi\",
    nh.sodienthoai AS \"SDTNongHo\",
    nh.email AS \"EmailNongHo\",
    nh.mavung AS \"MaVung\",
    nh.avatar AS \"avatar\",
    COUNT(td.mathua) AS \"SoThuadat\"
FROM 
    quan_ly_nguoi_dung qlnd
JOIN 
    nong_ho nh ON qlnd.manguoidung = nh.manguoidung
LEFT JOIN 
    thua_dat td ON nh.maho = td.maho
WHERE 
    qlnd.manguoidung = ?
GROUP BY 
    qlnd.manguoidung, nh.maho, nh.hoten, nh.gioitinh, nh.ngaysinh, nh.diachi, nh.sodienthoai, nh.email, nh.mavung, nh.avatar");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function updateUserById($user_id, $hoTen, $gioiTinh, $ngaySinh, $ap, $xa, $huyen, $tinh, $diaChiFull, $sdt, $email) {
        //1. Lấy mã vùng trồng trước khi update
        $query = $this->db->conn->prepare("
            SELECT mavung AS \"MaVung\" FROM nong_ho 
            WHERE manguoidung = ?
        ");
        $query->execute([$user_id]);
        $row_cu = $query->fetch(PDO::FETCH_ASSOC);
        $maVungCu = $row_cu ? $row_cu['MaVung'] : null;

        // 2. Lấy MaVung từ vung_trong
        $stmt = $this->db->conn->prepare("
            SELECT mavung AS \"MaVung\" FROM vung_trong 
            WHERE diachi = ? AND xa = ? AND huyen = ? AND tinh = ?
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
            SET nh.diachi = ?, nh.mavung = ?, nh.sodienthoai = ?, nh.email = ?, 
                nh.hoten = ?, nh.gioitinh = ?, nh.ngaysinh = ?
            WHERE nh.manguoidung = ?
        ");
        $ok = $stmt->execute([$diaChiFull, $maVung, $sdt, $email, $hoTen, $gioiTinh, $ngaySinh, $user_id]);

        // 4. Cập nhật số lượng nông hộ cho vùng trồng mới vừa chọn
        if ($maVungCu !== $maVung) {
            if ($maVungCu) {
                $updateVungCu = $this->db->conn->prepare("UPDATE vung_trong SET sohodan = GREATEST(sohodan - 1, 0) WHERE mavung = ?");
                $updateVungCu->execute([$maVungCu]);
            }
            if ($maVung) {
                $updateVungMoi = $this->db->conn->prepare("UPDATE vung_trong SET sohodan = sohodan + 1 WHERE mavung = ?");
                $updateVungMoi->execute([$maVung]);
            }
        }

        return $ok ? ["status" => "success"] : ["status" => "error", "message" => "Không thể cập nhật"];
    }

}