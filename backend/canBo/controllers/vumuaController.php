<?php
require_once __DIR__ . '/../models/vumuaModel.php';

class VuMuaController {
    private $model;

    public function __construct() {
        $this->model = new VuMuaModel();
    }

    public function getInfoVuMua() {


        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }

        $userData = $this->model->getInfoVuMua();

        return ["status" => "success", "data" => $userData];
    }
    public function updateInfoVuMua() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }

        $result = $this->model->updateInfoVuMua(
            $data['MaVu'] ?? "",
            $data['TenVu'] ?? "",
            $data['NgayBatDau'] ?? "",
            $data['NgayKetThuc'] ?? "",
            $data['MoTa'] ?? ""
        );
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Cập nhật thành công"];
        }
        return $result;
    }

    public function addInfoVuMua() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }

        $result = $this->model->addInfoVuMua(
            $data['TenVu'] ?? "",
            $data['NgayBatDau'] ?? "",
            $data['NgayKetThuc'] ?? "",
            $data['MoTa'] ?? ""
        );
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Thêm vụ mùa thành công"];
        }
        return $result;
    }

    public function deleteInfoVuMua() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data || empty($data['MaVu'])) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }

        $result = $this->model->deleteInfoVuMua($data['MaVu']);
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Xóa vụ mùa thành công"];
        }
        return $result;
    }
}