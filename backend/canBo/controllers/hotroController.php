<?php
require_once __DIR__ . '/../models/hotroModel.php';

class HoTroController {
    private $model;

    public function __construct() {
        $this->model = new HoTroModel();
    }

    public function getInfoHoTro() {


        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }

        $userData = $this->model->getInfoHoTro();

        return ["status" => "success", "data" => $userData];
    }
    public function updateInfoHoTro() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }

        $result = $this->model->updateInfoHoTro(
            $data['MaHoTro'] ?? "",
            $data['NgayHoTro'] ?? "",
            $data['NoiDung'] ?? "",
            $data['CanBoHoTro'] ?? "",
            $data['MaNongHo'] ?? "",
            $data['MaVung'] ?? ""
        );
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Cập nhật thành công"];
        }
        return $result;
    }

    public function addInfoHoTro() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }

        $result = $this->model->addInfoHoTro(
            $data['NgayHoTro'] ?? "",
            $data['NoiDung'] ?? "",
            $data['CanBoHoTro'] ?? "",
            $data['MaNongHo'] ?? "",
            $data['MaVung'] ?? ""
        );
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Thêm hỗ trợ thành công"];
        }
        return $result;
    }

    public function deleteInfoHoTro() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data || empty($data['MaHoTro'])) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }

        $result = $this->model->deleteInfoHoTro($data['MaHoTro']);
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Xóa hỗ trợ thành công"];
        }
        return $result;
    }
}