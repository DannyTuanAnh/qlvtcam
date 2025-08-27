<?php
require_once __DIR__ . '/../models/thuadatModel.php';

class ThuaDatController {
    private $model;

    public function __construct() {
        $this->model = new ThuaDatModel();
    }

    public function getInfoThuaDat() {


        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }

        $userData = $this->model->getInfoThuaDat();

        return ["status" => "success", "data" => $userData];
    }
    public function updateInfoThuaDat() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }

        $result = $this->model->updateInfoThuaDat(
            $data['MaThua'] ?? "",
            $data['MaHo'] ?? "",
            $data['DienTich'] ?? "",
            $data['LoaiDat'] ?? "",
            $data['ViTri'] ?? ""
        );
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Cập nhật thành công"];
        }
        return $result;
    }

    public function addInfoThuaDat() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }

        $result = $this->model->addInfoThuaDat(
            $data['MaHo'] ?? "",
            $data['DienTich'] ?? "",
            $data['LoaiDat'] ?? "",
            $data['ViTri'] ?? ""
        );
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Thêm thửa đất thành công"];
        }
        return $result;
    }

    public function deleteInfoThuaDat() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data || empty($data['MaThua'])) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }

        $result = $this->model->deleteInfoThuaDat($data['MaThua']);
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Xóa thửa đất thành công"];
        }
        return $result;
    }
}