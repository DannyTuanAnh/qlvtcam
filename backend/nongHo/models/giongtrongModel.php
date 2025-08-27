<?php
require_once __DIR__ . '/../../config/connect.php';

class giongtrongModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getGiongTrongById($user_id) {
        $stmt = $this->db->conn->prepare("
            SELECT 
            vm.MaVu,
            vm.TenVu,
            td.MaThua,
            td.DienTich,
            td.ViTri,
            gc.TenGiong AS TenCayTrong,
            gt.SoLuongCay,
            gt.NgayTrong,
            gt.MaTrong
        FROM 
            quan_ly_nguoi_dung qlnd
        JOIN 
            nong_ho nh ON qlnd.MaNguoiDung = nh.MaNguoiDung
        JOIN 
            thua_dat td ON nh.MaHo = td.MaHo
        JOIN 
            giong_trong gt ON td.MaThua = gt.MaThua
        JOIN 
            giong_cam gc ON gt.MaGiong = gc.MaGiong
        JOIN 
            vu_mua vm ON gt.MaVu = vm.MaVu
        WHERE 
            qlnd.MaNguoiDung = ?
        ORDER BY 
            vm.MaVu, gt.NgayTrong;

        ");

        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result(); // GÁN kết quả trả về

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $maVu = $row['MaVu'];
            if (!isset($data[$maVu])) {
                $data[$maVu] = [];
            }
            $data[$maVu][] = $row;
        }

        // Không echo ở model, chỉ return dữ liệu
        return $data;
    }

    //Hàm lấy thông tin giống cam
    public function getAllCay() {
        try {
            $query = "SELECT * FROM giong_cam ORDER BY MaGiong";
            
            $stmt = $this->db->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            
            return $data;
            
        } catch (Exception $e) {
            error_log("Error in getAllCay: " . $e->getMessage());
            throw new Exception("Lỗi khi lấy dữ liệu giống cam " . $e->getMessage());
        }
    }

    //Hàm cập nhật thông tin giống trồng
    public function updateGiongTrongByID($maTrong, $maGiong, $maVu, $maThua, $ngayTrong, $soLuongCay) {
        try {

            // Lấy thời gian trồng
    $stmt = $this->db->conn->prepare("SELECT NgayTrong FROM giong_trong WHERE MaTrong = ?");
    $stmt->bind_param("i", $maTrong);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if (!$row) {
        echo json_encode(["status" => "error", "message" => "Không tìm thấy thông tin giống trồng."]);
        exit;
    }

    $thoiGianTrong = $row['NgayTrong'];
    $now = new DateTime();
    $thoiGianTrongDT = new DateTime($thoiGianTrong);
    $interval = $thoiGianTrongDT->diff($now);
    if ($interval->days >= 15 && $thoiGianTrongDT < $now) {
        echo json_encode(["status" => "error", "message" => "Đã quá 15 ngày kể từ thời gian trồng, không thể chỉnh sửa/xóa."]);
        exit;
    }

            $query = "UPDATE giong_trong 
                      SET MaGiong = ?, MaVu = ?, MaThua = ?, NgayTrong = ?, SoLuongCay = ?
                      WHERE MaTrong = ?"; 
            
            $stmt = $this->db->conn->prepare($query);
            $stmt->bind_param("iiisii", $maGiong, $maVu, $maThua, $ngayTrong, $soLuongCay, $maTrong);
            
            if ($stmt->execute()) {
                return [
                    'status' => 'success',
                    'message' => 'Cập nhật thông tin giống trồng thành công'
                ];
            } else {
                throw new Exception("Lỗi execute: " . $stmt->error);
            }
            
        } catch (Exception $e) {
            error_log("Error in updateGiongTrongByID: " . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Lỗi khi cập nhật thông tin giống trồng: ' . $e->getMessage()
            ];
        }
    }

    //Hàm thêm mới giống trồng
    public function addGiongTrong( $maGiong, $maVu, $maThua, $ngayTrong, $soLuongCay) {
        // Thêm thông tin trồng cây mới
        $stmt = $this->db->conn->prepare("
            INSERT INTO giong_trong (MaGiong, MaVu, MaThua, NgayTrong, SoLuongCay)
            VALUES (?, ?, ?, ?, ?);
        ");
        $stmt->bind_param("iiisi", $maGiong, $maVu, $maThua, $ngayTrong, $soLuongCay);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok ? ["status" => "success"] : ["status" => "error", "message" => "Không thể thêm thông tin trồng cây"];
    }

    //Hàm xóa giong trong
    public function deleteGiongTrong($maTrong) {
        try {

    // Lấy thời gian trồng
    $stmt = $this->db->conn->prepare("SELECT NgayTrong FROM giong_trong WHERE MaTrong = ?");
    $stmt->bind_param("i", $maTrong);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    if (!$row) {
        echo json_encode(["status" => "error", "message" => "Không tìm thấy thông tin giống trồng."]);
        exit;
    }

    $thoiGianTrong = $row['NgayTrong'];
    $now = new DateTime();
    $thoiGianTrongDT = new DateTime($thoiGianTrong);
    $interval = $thoiGianTrongDT->diff($now);
    if ($interval->days >= 15 && $thoiGianTrongDT < $now) {
        echo json_encode(["status" => "error", "message" => "Đã quá 15 ngày kể từ thời gian trồng, không thể chỉnh sửa/xóa."]);
        exit;
    }

            $query = "DELETE FROM giong_trong WHERE MaTrong = ?";

            $stmt = $this->db->conn->prepare($query);
            $stmt->bind_param("i", $maTrong);
            
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    return [
                        'status' => 'success',
                        'message' => 'Xóa thông tin trồng cây thành công'
                    ];
                } else {
                    return [
                        'status' => 'error',
                        'message' => 'Không tìm thấy thông tin để xóa'
                    ];
                }
            } else {
                throw new Exception("Lỗi execute: " . $stmt->error);
            }
            
        } catch (Exception $e) {
            error_log("Error in deleteGiongTrong: " . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Lỗi khi xóa thông tin trồng cây: ' . $e->getMessage()
            ];
        }
    }
}