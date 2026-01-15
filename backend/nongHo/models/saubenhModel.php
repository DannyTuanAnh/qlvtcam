<?php
require_once __DIR__ . '/../../config/connect.php';

class SauBenhModel {
    private $db;
    
    public function __construct() {
        $this->db = new connectDB();
    }
    
    public function getBaoCaoSauBenhByUserID($user_id) {
        try {
            $query = "SELECT 
                        bc.MaBaoCao,
                        bc.NgayPhatHien,
                        bc.MucDo,
                        bc.MaSau,
                        bc.MaThua,
                        bc.MaVu,
                        bc.GhiChu,
                        sau.TenSauBenh,
                        sau.TrieuChung,
                        sau.BienPhapXuLy,
                        td.LoaiDat,
                        td.DienTich,
                        td.ViTri,
                        vu.TenVu
                      FROM phat_hien_sau bc
                      INNER JOIN thua_dat td ON bc.MaThua = td.MaThua
                      INNER JOIN nong_ho nh ON td.MaHo = nh.MaHo
                      INNER JOIN quan_ly_nguoi_dung qlnd ON nh.MaNguoiDung = qlnd.MaNguoiDung
                      LEFT JOIN sau_benh sau ON bc.MaSau = sau.MaSau
                      LEFT JOIN vu_mua vu ON bc.MaVu = vu.MaVu
                      WHERE qlnd.MaNguoiDung = ?
                      ORDER BY bc.NgayPhatHien DESC";
            
            $stmt = $this->db->conn->prepare($query);
            $stmt->execute([$user_id]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            //Nhóm theo MaThua 
            $data = [];
            foreach ($result as $row) {
                $maThua = $row['MaThua'];
                if (!isset($data[$maThua])) {
                    $data[$maThua] = [];
                }
                $data[$maThua][] = [
                    'MaBaoCao' => $row['MaBaoCao'],
                    'NgayPhatHien' => $row['NgayPhatHien'],
                    'MucDo' => $row['MucDo'],
                    'MaSau' => $row['MaSau'],
                    'TenSauBenh' => $row['TenSauBenh'],
                    'TrieuChung' => $row['TrieuChung'],
                    'BienPhapXuLy' => $row['BienPhapXuLy'],
                    'MaThua' => $row['MaThua'],
                    'LoaiDat' => $row['LoaiDat'],
                    'DienTich' => $row['DienTich'],
                    'ViTri' => $row['ViTri'],
                    'MaVu' => $row['MaVu'],
                    'TenVu' => $row['TenVu'],
                    'GhiChu' => $row['GhiChu']
                ];
            }
            
            return [
            'status' => 'success',
            'data' => $data,
            'message' => 'Lấy dữ liệu thành công'
        ];
            
        } catch (Exception $e) {
            error_log("Error in getBaoCaoSauBenhByUserID: " . $e->getMessage());
            throw new Exception("Lỗi khi lấy dữ liệu báo cáo sâu bệnh: " . $e->getMessage());
        }
    }
    
    //Hàm thêm báo cáo sâu bệnh
    public function addBaoCaoSauBenh($data) {
        try {
            $query = "INSERT INTO phat_hien_sau (NgayPhatHien, MucDo, MaSau, MaThua, MaVu, GhiChu) 
                      VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->conn->prepare($query);
            if ($stmt->execute([
                $data['ngayPhatHien'],
                $data['mucDo'], 
                $data['maSau'],
                $data['maThua'],
                $data['maVu'],
                $data['ghiChu']
            ])) {
                return [
                    'status' => 'success',
                    'message' => 'Thêm báo cáo sâu bệnh thành công',
                    'maBaoCao' => $this->db->conn->lastInsertId()
                ];
            } else {
                throw new Exception("Lỗi execute");
            }
        } catch (Exception $e) {
            error_log("Error in addBaoCaoSauBenh: " . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Lỗi khi thêm báo cáo sâu bệnh: ' . $e->getMessage()
            ];
        }
    }
    
    //Hàm cập nhật báo cáo sâu bệnh
    public function updateBaoCaoSauBenh($maBaoCao, $maSau, $maThua, $maVu, $mucDo, $ngayPhatHien, $ghiChu) {
        try {
            // Lấy thời gian phát hiện
            $stmt = $this->db->conn->prepare("SELECT NgayPhatHien FROM phat_hien_sau WHERE MaBaoCao = ?");
            $stmt->execute([$maBaoCao]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                echo json_encode(["status" => "error", "message" => "Không tìm thấy thông tin phát hiện sâu."]);
                exit;
            }

            $thoiGianPhatHien = $row['NgayPhatHien'];
            $now = new DateTime();
            $thoiGianPhatHienDT = new DateTime($thoiGianPhatHien);
            $interval = $thoiGianPhatHienDT->diff($now);
            if ($interval->days >= 15 && $thoiGianPhatHienDT < $now) {
                echo json_encode(["status" => "error", "message" => "Đã quá 15 ngày kể từ thời gian phát hiện sâu, không thể chỉnh sửa/xóa."]);
                exit;
            }

            $query = "UPDATE phat_hien_sau 
                      SET NgayPhatHien = ?, MucDo = ?, MaSau = ?, MaThua = ?, MaVu = ?, GhiChu = ?
                      WHERE MaBaoCao = ?";
            
            $stmt = $this->db->conn->prepare($query);
            
            if ($stmt->execute([$ngayPhatHien, $mucDo, $maSau, $maThua, $maVu, $ghiChu, $maBaoCao])) {
                return [
                    'status' => 'success',
                    'message' => 'Cập nhật báo cáo sâu bệnh thành công'
                ];
            } else {
                throw new Exception("Lỗi execute");
            }
            
        } catch (Exception $e) {
            error_log("Error in updateBaoCaoSauBenh: " . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Lỗi khi cập nhật báo cáo sâu bệnh: ' . $e->getMessage()
            ];
        }
    }
    
    //Hàm xóa báo cáo sâu bệnh
    public function deleteBaoCaoSauBenh($maBaoCao) {
        try {
            // Lấy thời gian phát hiện
            $stmt = $this->db->conn->prepare("SELECT NgayPhatHien FROM phat_hien_sau WHERE MaBaoCao = ?");
            $stmt->execute([$maBaoCao]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
                echo json_encode(["status" => "error", "message" => "Không tìm thấy thông tin phát hiện sâu."]);
                exit;
            }

            $thoiGianPhatHien = $row['NgayPhatHien'];
            $now = new DateTime();
            $thoiGianPhatHienDT = new DateTime($thoiGianPhatHien);
            $interval = $thoiGianPhatHienDT->diff($now);
            if ($interval->days >= 15 && $thoiGianPhatHienDT < $now) {
                echo json_encode(["status" => "error", "message" => "Đã quá 15 ngày kể từ thời gian phát hiện sâu, không thể chỉnh sửa/xóa."]);
                exit;
            }

            $query = "DELETE FROM phat_hien_sau WHERE MaBaoCao = ?";
            
            $stmt = $this->db->conn->prepare($query);
            
            if ($stmt->execute([$maBaoCao])) {
                if ($stmt->rowCount() > 0) {
                    return [
                        'status' => 'success',
                        'message' => 'Xóa báo cáo sâu bệnh thành công'
                    ];
                } else {
                    return [
                        'status' => 'error',
                        'message' => 'Không tìm thấy báo cáo để xóa'
                    ];
                }
            } else {
                throw new Exception("Lỗi execute");
            }
            
        } catch (Exception $e) {
            error_log("Error in deleteBaoCaoSauBenh: " . $e->getMessage());
            return [
                'status' => 'error',
                'message' => 'Lỗi khi xóa báo cáo sâu bệnh: ' . $e->getMessage()
            ];
        }
    }
    
    //Hàm lấy thông tin sâu bệnh
    public function getAllSauBenh() {
        try {
            $query = "SELECT MaSau, TenSauBenh, TrieuChung, BienPhapXuLy FROM sau_benh ORDER BY MaSau";
            
            $stmt = $this->db->conn->prepare($query);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $data;
            
        } catch (Exception $e) {
            error_log("Error in getAllSauBenh: " . $e->getMessage());
            throw new Exception("Lỗi khi lấy dữ liệu sâu bệnh: " . $e->getMessage());
        }
    }
    
}
?>