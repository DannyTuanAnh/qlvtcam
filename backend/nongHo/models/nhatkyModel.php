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
                td.mathua AS \"MaThua\",
                nk.manhatky AS \"MaNhatKy\",
                vm.tenvu AS \"TenVu\",
                nk.thoigian AS \"ThoiGian\",
                nk.loaihoatdong AS \"LoaiHoatDong\",
                nk.noidung AS \"NoiDung\"
            FROM 
                quan_ly_nguoi_dung qlnd
            JOIN 
                nong_ho nh ON qlnd.manguoidung = nh.manguoidung
            JOIN 
                thua_dat td ON nh.maho = td.maho
            JOIN 
                nhat_ky_canh_tac nk ON td.mathua = nk.mathua
            JOIN 
                vu_mua vm ON nk.mavu = vm.mavu
            WHERE 
                qlnd.manguoidung = ?
            ORDER BY 
                td.mathua, nk.thoigian
        ");

        $stmt->execute([$user_id]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [];

        foreach ($result as $row) {
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
            SELECT mathua AS \"MaThua\", mavu AS \"MaVu\" 
            FROM nhat_ky_canh_tac 
            WHERE manhatky = ?
        ");
        $stmt->execute([$nhatKy_id]);
        $nhatKy = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$nhatKy) {
            return ["status" => "error", "message" => "Không tìm thấy nhật ký"];
        }

        $maThua = $nhatKy['MaThua'];
        $maVuNhatKy = $nhatKy['MaVu'];

        // 2. Kiểm tra xem thửa đất này trong vụ đó đã thu hoạch chưa
        $stmt = $this->db->conn->prepare("
            SELECT * 
            FROM thu_hoach 
            WHERE mathua = ? AND mavu = ?
            LIMIT 1
        ");
        $stmt->execute([$maThua, $maVuNhatKy]);
        $isHarvested = $stmt->rowCount() > 0;

        if ($isHarvested) {
            return [
                "status" => "error",
                "message" => "Thửa đất ở đợt này đã được thu hoạch nên không cho chỉnh sửa"
            ];
        }

        // 3. Nếu chưa thu hoạch thì cho update
        $stmt = $this->db->conn->prepare("
            UPDATE nhat_ky_canh_tac
            SET loaihoatdong = ?, noidung = ?, thoigian = ?, mavu = ?
            WHERE manhatky = ?
        ");
        $ok = $stmt->execute([$loaiHoatDong, $noiDung, $thoiGian, $maVu, $nhatKy_id]);

        return $ok 
            ? ["status" => "success"] 
            : ["status" => "error", "message" => "Không thể cập nhật"];
    }


    public function addNhatKy($user_id, $loaiHoatDong, $noiDung, $maThua, $vuMua, $ngayThucHien) {
        // Thêm nhật ký mới
        $stmt = $this->db->conn->prepare("
            INSERT INTO nhat_ky_canh_tac (mathua, loaihoatdong, noidung, mavu, manguoinhap, thoigian)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $ok = $stmt->execute([$maThua, $loaiHoatDong, $noiDung, $vuMua, $user_id, $ngayThucHien]);
         // ✅ SỬA: Format YYYY-MM-DD HH:mm:ss

        return $ok ? ["status" => "success"] : ["status" => "error", "message" => "Không thể thêm nhật ký"];
    }
}