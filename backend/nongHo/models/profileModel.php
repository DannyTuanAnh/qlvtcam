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
    qlnd.MaNguoiDung, nh.MaHo, nh.Avatar;
");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    public function updateUserById($user_id, $hoTen, $gioiTinh, $ngaySinh, $ap, $xa, $huyen, $tinh, $diaChiFull, $sdt, $email) {
    //1. Lấy mã vùng trồng trước khi update
    $query = $this->db->conn->prepare("
        SELECT MaVung FROM nong_ho 
        WHERE MaNguoiDung = ?
    ");
    $query->bind_param("i", $user_id);
    $query->execute();
    $result_cu = $query->get_result();
    $row_cu = $result_cu->fetch_assoc();
    $maVungCu = $row_cu ? $row_cu['MaVung'] : null;
    $query->close();

    // 2. Lấy MaVung từ vung_trong
    $stmt = $this->db->conn->prepare("
        SELECT MaVung FROM vung_trong 
        WHERE DiaChi = ? AND Xa = ? AND Huyen = ? AND Tinh = ?
        LIMIT 1
    ");
    $stmt->bind_param("ssss", $ap, $xa, $huyen, $tinh);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $maVung = $row ? $row['MaVung'] : null;
    $stmt->close();

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
    $stmt->bind_param("sisssssi", $diaChiFull, $maVung, $sdt, $email, $hoTen, $gioiTinh, $ngaySinh, $user_id);
    $ok = $stmt->execute();
    $stmt->close();

    // 4. Cập nhật số lượng nông hộ cho vùng trồng mới vừa chọn
    if ($maVungCu !== $maVung) {
        if ($maVungCu) {
            $updateVungCu = $this->db->conn->prepare("UPDATE vung_trong SET SoHoDan = GREATEST(SoHoDan - 1, 0) WHERE MaVung = ?");
            $updateVungCu->bind_param("i", $maVungCu);
            $updateVungCu->execute();
            $updateVungCu->close();
        }
        if ($maVung) {
            $updateVungMoi = $this->db->conn->prepare("UPDATE vung_trong SET SoHoDan = SoHoDan + 1 WHERE MaVung = ?");
            $updateVungMoi->bind_param("i", $maVung);
            $updateVungMoi->execute();
            $updateVungMoi->close();
        }
    }

    return $ok ? ["status" => "success"] : ["status" => "error", "message" => "Không thể cập nhật"];
}

}