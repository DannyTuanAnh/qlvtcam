<?php
require_once __DIR__ . '/../../config/connect.php';

class nhatkyModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getNhatKyById($user_id) {
        $stmt = $this->db->conn->prepare("
            SELECT 
                td.MaThua,
                nk.MaNhatKy,
                vm.TenVu,
                nk.ThoiGian,
                nk.LoaiHoatDong,
                nk.NoiDung
            FROM 
                quan_ly_nguoi_dung qlnd
            JOIN 
                nong_ho nh ON qlnd.MaNguoiDung = nh.MaNguoiDung
            JOIN 
                thua_dat td ON nh.MaHo = td.MaHo
            JOIN 
                nhat_ky_canh_tac nk ON td.MaThua = nk.MaThua
            JOIN 
                vu_mua vm ON nk.MaVu = vm.MaVu
            WHERE 
                qlnd.MaNguoiDung = ?
            ORDER BY 
                td.MaThua, nk.ThoiGian;
        ");

        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result(); // GÁN kết quả trả về

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $maThua = $row['MaThua'];
            if (!isset($data[$maThua])) {
                $data[$maThua] = [];
            }
            $data[$maThua][] = $row;
        }

        // Không echo ở model, chỉ return dữ liệu
        return $data;
    }

    
    public function updateNhatKyById($nhatKy_id, $maVu, $thoiGian, $loaiHoatDong, $noiDung) {
    // 1. Lấy MaThua và MaVu từ nhật ký
    $stmt = $this->db->conn->prepare("
        SELECT MaThua, MaVu 
        FROM nhat_ky_canh_tac 
        WHERE MaNhatKy = ?
    ");
    $stmt->bind_param("i", $nhatKy_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $nhatKy = $result->fetch_assoc();
    $stmt->close();

    if (!$nhatKy) {
        return ["status" => "error", "message" => "Không tìm thấy nhật ký"];
    }

    $maThua = $nhatKy['MaThua'];
    $maVuNhatKy = $nhatKy['MaVu'];

    // 2. Kiểm tra xem thửa đất này trong vụ đó đã thu hoạch chưa
    $stmt = $this->db->conn->prepare("
        SELECT * 
        FROM thu_hoach 
        WHERE MaThua = ? AND MaVu = ?
        LIMIT 1
    ");
    $stmt->bind_param("ii", $maThua, $maVuNhatKy);
    $stmt->execute();
    $stmt->store_result();
    $isHarvested = $stmt->num_rows > 0;
    $stmt->close();

    if ($isHarvested) {
        return [
            "status" => "error",
            "message" => "Thửa đất ở đợt này đã được thu hoạch nên không cho chỉnh sửa"
        ];
    }

    // 3. Nếu chưa thu hoạch thì cho update
    $stmt = $this->db->conn->prepare("
        UPDATE nhat_ky_canh_tac
        SET LoaiHoatDong = ?, NoiDung = ?, ThoiGian = ?, MaVu = ?
        WHERE MaNhatKy = ?
    ");
    $stmt->bind_param("sssii", $loaiHoatDong, $noiDung, $thoiGian, $maVu, $nhatKy_id);
    $ok = $stmt->execute();
    $stmt->close();

    return $ok 
        ? ["status" => "success"] 
        : ["status" => "error", "message" => "Không thể cập nhật"];
}


    public function addNhatKy($user_id, $loaiHoatDong, $noiDung, $maThua, $vuMua, $ngayThucHien) {
        // Thêm nhật ký mới
        $stmt = $this->db->conn->prepare("
            INSERT INTO nhat_ky_canh_tac (MaThua, LoaiHoatDong, NoiDung, maVu, MaNguoiNhap, ThoiGian)
            VALUES (?, ?, ?, ?, ?, ?);
        ");
        $stmt->bind_param("issiis", $maThua, $loaiHoatDong, $noiDung, $vuMua, $user_id, $ngayThucHien);
         // ✅ SỬA: Format YYYY-MM-DD HH:mm:ss
        $ok = $stmt->execute();
        $stmt->close();

        return $ok ? ["status" => "success"] : ["status" => "error", "message" => "Không thể thêm nhật ký"];
    }
}