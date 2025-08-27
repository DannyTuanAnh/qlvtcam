<?php
require_once __DIR__ . '/../models/caytrongModel.php';

class CayTrongController {
    private $model;

    public function __construct() {
        $this->model = new CayTrongModel();
    }

    public function getInfoCayTrong() {


        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }

        $userData = $this->model->getInfoCayTrong();

        return ["status" => "success", "data" => $userData];
    }
    public function updateInfoCayTrong() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }

        $result = $this->model->updateInfoCayTrong(
            $data['MaGiong'] ?? "",
            $data['TenGiong'] ?? "",
            $data['DacTinh'] ?? "",
            $data['NguonGoc'] ?? ""
        );
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Cập nhật thành công"];
        }
        return $result;
    }

    public function addInfoCayTrong() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }

        $result = $this->model->addInfoCayTrong(
            $data['TenGiong'] ?? "",
            $data['DacTinh'] ?? "",
            $data['NguonGoc'] ?? ""
        );
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Thêm giống cam thành công"];
        }
        return $result;
    }

    public function deleteInfoCayTrong() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data || empty($data['MaGiong'])) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }

        $result = $this->model->deleteInfoCayTrong($data['MaGiong']);
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Xóa giống cam thành công"];
        }
        return $result;
    }
}