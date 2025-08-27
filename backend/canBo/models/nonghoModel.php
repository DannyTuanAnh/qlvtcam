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
                  GROUP BY nh.MaHo
                  ORDER BY nh.HoTen;");
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
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
        $stmt->bind_param("sssssisi", $hoTen, $gioiTinh, $soDienThoai, $email, $ngaySinh, $maVung, $diaChi, $maHo);
        $ok = $stmt->execute();
        $stmt->close();
        if ($ok){
            return ["status" => "success", "message" => "Cập nhật nông hộ thành công"];
        } else {
            return ["status" => "error", "message" => "Không thể cập nhật nông hộ"];
        }
    }

    public function addInfoNongHo($hoTen, $sdt, $gioiTinh, $ngaySinh, $tinh, $huyen, $xa, $ap, $email, $pass, $diaChi) {
        // Kiểm tra số điện thoại đã tồn tại chưa
        $checkStmt = $this->db->conn->prepare("SELECT COUNT(*) as count FROM nong_ho WHERE SoDienThoai = ?");
        $checkStmt->bind_param("s", $sdt);
        $checkStmt->execute();
        $result = $checkStmt->get_result()->fetch_assoc();
        $checkStmt->close();
        
        if ($result['count'] > 0) {
            return ["status" => "error", "message" => "Số điện thoại đã được sử dụng"];
        }
        //Lấy mã vùng trồng
        $vt = $this->db->conn->prepare("Select MaVung from vung_trong where DiaChi = ? and Xa = ? and Huyen = ? and Tinh = ?");
        $vt->bind_param("ssss", $ap, $xa, $huyen, $tinh);
        $vt->execute();
        $vtResult = $vt->get_result()->fetch_assoc();
        $vt->close();
        $ma_vt = $vtResult ? $vtResult['MaVung'] : null;

        //thêm nông hộ vào bảng người dung
        $qlnd = $this->db->conn->prepare("insert into quan_ly_nguoi_dung (HoTen, Email, MatKhau, SoDienThoai, VaiTro) values (?,?,?,?,'nongho')");
        $qlnd->bind_param("ssss", $hoTen, $email, $pass, $sdt);
        $qlnd->execute();
        $qlnd->close();

        //lấy mã người dùng
        $nd = $this->db->conn->prepare("select MaNguoiDung from quan_ly_nguoi_dung where Email = ?");
        $nd->bind_param("s", $email);
        $nd->execute();
        $ndResult = $nd->get_result()->fetch_assoc();
        $nd->close();
        $ma_nd = $ndResult ? $ndResult['MaNguoiDung'] : null;
        // Thêm nông hộ mới
        $add = $this->db->conn->prepare("
        insert into nong_ho (HoTen, GioiTinh, NgaySinh, SoDienThoai, Email, MaVung, DiaChi, MaNguoiDung) 
        values (?, ?, ?, ?, ?, ?, ?, ?)");
        $add->bind_param("sssssisi", $hoTen, $gioiTinh ,$ngaySinh, $sdt, $email,  $ma_vt, $diaChi, $ma_nd);
        $ok = $add->execute();
        $add->close();

        //Cập nhật số lượng nông hộ cho vùng trồng
        if ($ma_vt) {
            $updateVung = $this->db->conn->prepare("UPDATE vung_trong SET SoHoDan = SoHoDan + 1 WHERE MaVung = ?");
            $updateVung->bind_param("i", $ma_vt);
            $updateVung->execute();
            $updateVung->close();
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
        $checkUsageStmt->bind_param("i", $maHo);
        $checkUsageStmt->execute();
        $usage = $checkUsageStmt->get_result()->fetch_assoc();
        $checkUsageStmt->close();
        
        if ($usage['thua_count'] > 0) {
            return ["status" => "error", "message" => "Không thể xóa nông hộ đang có thửa đất"];
        }

        // Xóa nông hộ
        $deleteQuery = "DELETE FROM nong_ho WHERE MaHo = ?";
        $deleteStmt = $this->db->conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $maHo);

        //Cập nhật số lượng nông hộ cho vùng trồng
        $vungQuery = "SELECT MaVung FROM nong_ho WHERE MaHo = ?";
        $vungStmt = $this->db->conn->prepare($vungQuery);
        $vungStmt->bind_param("i", $maHo);
        $vungStmt->execute();
        $vungResult = $vungStmt->get_result()->fetch_assoc();
        $vungStmt->close();
        if ($vungResult) {
            $ma_vung = $vungResult['MaVung'];
            $updateVung = $this->db->conn->prepare("UPDATE vung_trong SET SoHoDan = GREATEST(SoHoDan - 1, 0) WHERE MaVung = ?");
            $updateVung->bind_param("i", $ma_vung);
            $updateVung->execute();
            $updateVung->close();
        }
        
        if ($deleteStmt->execute()) {
            $deleteStmt->close();
            return ["status" => "success", "message" => "Xóa nông hộ thành công"];
        } else {
            $deleteStmt->close();
            return ["status" => "error", "message" => "Không thể xóa nông hộ"];
        }
    }
}
?>