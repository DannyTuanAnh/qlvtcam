<?php

require_once __DIR__ . '/../models/thoiTietModel.php';

class ThoiTietController {
    private $model;
    
    public function __construct() {
        $this->model = new ThoiTietModel();
    }
    
    public function getThoiTiet() {
        try {
            if (!isset($_SESSION['MaNguoiDung'])) {
                http_response_code(401);
                return ["status" => "error", "message" => "Chưa đăng nhập"];
            }
            
            $result = $this->model->getThoiTiet();
            
            if ($result['status'] === 'success') {
                if (empty($result['data'])) {
                    return [
                        "status" => "success",
                        "data" => [],
                        "message" => "Chưa có dữ liệu thời tiết"
                    ];
                }
                
                return $result;
            } else {
                return $result;
            }
            
        } catch (Exception $e) {
            return [
                "status" => "error",
                "message" => "Lỗi controller: " . $e->getMessage()
            ];
        }
    }
    public function updateThoiTiet(){
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }

        $result = $this->model->updateThoiTietById(
            $data['maThoiTiet'] ?? "",
            $data['nhietDo'] ?? "",
            $data['doAm'] ?? "",
            $data['luongMua'] ?? "",
            $data['thoiTiet'] ?? "",
            $data['ghiChu'] ?? "",
            $data['thoiGianDo'] ?? ""
        );
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Cập nhật thành công"];
        }
        return $result;
    }

    public function addThoiTiet(){
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }
        $result = $this->model->addThoiTiet(
            $data['maVung'] ?? "",
            $data['nhietDo'] ?? "",
            $data['doAm'] ?? "",
            $data['luongMua'] ?? "",
            $data['thoiTiet'] ?? "",
            $data['ghiChu'] ?? "",
            $data['thoiGianDo'] ?? ""
        );
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Cập nhật thành công"];
        }
        return $result;
    }
}
?>