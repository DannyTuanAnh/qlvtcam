<?php
require_once __DIR__ . '/../../config/connect.php';

class ThoiTietModel {
    private $db;
    
    public function __construct() {
        $this->db = new connectDB();
    }
    
    public function getThoiTiet() {
        try {
            $query = "SELECT tt.mathoitiet AS \"MaThoiTiet\",
                             tt.ngaydo AS \"NgayDo\",
                             tt.nhietdo AS \"NhietDo\",
                             tt.doam AS \"DoAm\",
                             tt.luongmua AS \"LuongMua\",
                             tt.thoitiet AS \"ThoiTiet\",
                             tt.ghichu AS \"GhiChu\",
                             tt.mavung AS \"MaVung\",
                             vt.mavung AS \"MaVung\",
                             vt.huyen AS \"Huyen\"
                      FROM thoi_tiet tt 
                      INNER JOIN vung_trong vt ON tt.mavung = vt.mavung 
                      ORDER BY tt.ngaydo DESC";
            
            $stmt = $this->db->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $data = [];
            foreach ($result as $row) {
                $maVung = $row['MaVung'];
                if (!isset($data[$maVung])) {
                    $data[$maVung] = [];
                }
                $data[$maVung][] = [
                    'MaThoiTiet' => $row['MaThoiTiet'],
                    'NgayDo' => $row['NgayDo'],
                    'NhietDo' => $row['NhietDo'],
                    'DoAm' => $row['DoAm'],
                    'LuongMua' => $row['LuongMua'],
                    'ThoiTiet' => $row['ThoiTiet'],
                    'GhiChu' => $row['GhiChu'],
                    'Huyen' => $row['Huyen'] 
                ];
            }
            
            return [
                "status" => "success",
                "data" => $data
            ];
            
        } catch (Exception $e) {
            return [
                "status" => "error",
                "message" => "Lỗi truy vấn: " . $e->getMessage()
            ];
        }
    }
    public function updateThoiTietById($maThoiTiet, $nhietDo,$doAm,$luongMua,$thoiTiet,$ghiChu, $thoiGianDo) {

        // Lấy thời gian đo
        $stmt = $this->db->conn->prepare("SELECT ngaydo AS \"NgayDo\" FROM thoi_tiet WHERE mathoitiet = ?");
        $stmt->execute([$maThoiTiet]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            echo json_encode(["status" => "error", "message" => "Không tìm thấy thông tin thời tiết."]);
            exit;
        }

        $thoiGianDo = $row['NgayDo'];
        $now = new DateTime();
        $thoiGianDoDT = new DateTime($thoiGianDo);
        $diffSeconds = $now->getTimestamp() - $thoiGianDoDT->getTimestamp();
        if ($diffSeconds >= 86400) { // 24h = 86400 giây
            echo json_encode(["status" => "error", "message" => "Đã quá 24h kể từ thời gian đo, không thể chỉnh sửa/xóa."]);
            exit;
        }

        // Update nhật ký
        $stmt = $this->db->conn->prepare("
        UPDATE thoi_tiet
        SET nhietdo = ?, doam = ?, luongmua = ?, thoitiet = ?, ghichu = ?, ngaydo = ?
        WHERE mathoitiet = ?
        ");
        $ok = $stmt->execute([$nhietDo, $doAm, $luongMua, $thoiTiet, $ghiChu, $thoiGianDo, $maThoiTiet]);

        return $ok ? ["status" => "success"] : ["status" => "error", "message" => "Không thể cập nhật"];
    }
    
    public function addThoiTiet($maVung, $nhietDo, $doAm, $luongMua, $thoiTiet, $ghiChu, $thoiGianDo) {
        // Thêm nhật ký mới
        $stmt = $this->db->conn->prepare("
            INSERT INTO thoi_tiet (mavung, nhietdo, doam, luongmua, thoitiet, ghichu, ngaydo)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $ok = $stmt->execute([$maVung, $nhietDo, $doAm, $luongMua, $thoiTiet, $ghiChu, $thoiGianDo]);

        return $ok ? ["status" => "success"] : ["status" => "error", "message" => "Không thể thêm nhật ký"];
    }
    
}
?>