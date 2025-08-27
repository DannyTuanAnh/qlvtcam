<?php
require_once __DIR__ . '/../../config/connect.php';

class ThoiTietModel {
    private $db;
    
    public function __construct() {
        $this->db = new connectDB();
    }
    
    public function getThoiTiet() {
        try {
            $query = "SELECT tt.*, vt.MaVung, vt.Huyen 
                      FROM thoi_tiet tt 
                      INNER JOIN vung_trong vt ON tt.MaVung = vt.MaVung 
                       
                      ORDER BY tt.NgayDo DESC";
            
            $stmt = $this->db->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $data = [];
            while ($row = $result->fetch_assoc()) {
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
    $stmt = $this->db->conn->prepare("SELECT NgayDo FROM thoi_tiet WHERE MaThoiTiet = ?");
    $stmt->bind_param("i", $maThoiTiet);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

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
        SET NhietDo = ?, DoAm = ?, LuongMua = ?, ThoiTiet = ?, GhiChu = ?, NgayDo = ?
        WHERE MaThoiTiet = ?;
        ");
        $stmt->bind_param("dddsssi", $nhietDo, $doAm, $luongMua, $thoiTiet, $ghiChu, $thoiGianDo, $maThoiTiet);
        $ok = $stmt->execute();
        $stmt->close();

    return $ok ? ["status" => "success"] : ["status" => "error", "message" => "Không thể cập nhật"];
    }
    public function addThoiTiet($maVung, $nhietDo, $doAm, $luongMua, $thoiTiet, $ghiChu, $thoiGianDo) {
        // Thêm nhật ký mới
        $stmt = $this->db->conn->prepare("
            INSERT INTO thoi_tiet (MaVung, NhietDo, DoAm, LuongMua, ThoiTiet, GhiChu, NgayDo)
            VALUES (?, ?, ?, ?, ?, ?, ?);
        ");
        $stmt->bind_param("idddsss", $maVung, $nhietDo, $doAm, $luongMua, $thoiTiet, $ghiChu, $thoiGianDo);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok ? ["status" => "success"] : ["status" => "error", "message" => "Không thể thêm nhật ký"];
    }
    
}
?>