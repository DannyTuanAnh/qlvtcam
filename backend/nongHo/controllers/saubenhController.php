<?php

require_once __DIR__ . '/../models/saubenhModel.php';

class SauBenhController {
    private $model;
    
    public function __construct() {
        $this->model = new SauBenhModel();
    }
    
    public function getBaoCaoSauBenh() {
        try {
            if (!isset($_SESSION['MaNguoiDung'])) {
                http_response_code(401);
                return ["status" => "error", "message" => "Chưa đăng nhập"];
            }
            $user_id = $_SESSION['MaNguoiDung'];
            $result = $this->model->getBaoCaoSauBenhByUserID($user_id);
                
            if ($result === false) {
                http_response_code(500);
                return ["status" => "error", "message" => "Lỗi khi lấy báo cáo sau bệnh"];
            }
            return $result;
        } catch (Exception $e) {
            return [
                "status" => "error",
                "message" => "Lỗi controller: " . $e->getMessage()
            ];
        }
}
    public function getSauBenh() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }   
        $userData = $this->model->getAllSauBenh();

        return ["status" => "success", "data" => $userData];
    }
    public function updateSauBenh() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }

        $result = $this->model->updateBaoCaoSauBenh(
            $data['maBaoCao'] ?? "",
            $data['maSau'] ?? "",
            $data['maThua'] ?? "",
            $data['maVu'] ?? "",
            $data['mucDo'] ?? "",
            $data['ngayPhatHien'] ?? "",
            $data['ghiChu'] ?? ""
        );
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Cập nhật thành công"];
        }
        return $result;
    }
    public function xoaBaoCaoSauBenh() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        $maSau = $_POST['MaBaoCao'] ?? null;
        if (!$maSau) {
            return ["status" => "error", "message" => "Mã sâu bệnh không hợp lệ"];
        }

        $result = $this->model->deleteBaoCaoSauBenh($maSau);
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Xóa báo cáo thành công"];
        }
        return $result;
    }
    // Thêm báo cáo sâu bệnh
    public function addBaoCaoSauBenh($maNguoiDung, $ngayPhatHien, $mucDo, $maSau, $maThua, $maVu, $ghiChu = "") {
        if (!isset($_SESSION['MaNguoiDung']) || $_SESSION['MaNguoiDung'] != $maNguoiDung) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập hoặc sai người dùng"];
        }
        $data = [
            'ngayPhatHien' => $ngayPhatHien,
            'mucDo' => $mucDo,
            'maSau' => $maSau,
            'maThua' => $maThua,
            'maVu' => $maVu,
            'ghiChu' => $ghiChu
        ];
        $result = $this->model->addBaoCaoSauBenh($data);
        return $result;
    }
}