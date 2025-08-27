<?php
require_once __DIR__ . '/../models/vungtrongModel.php';

class vungtrongController {
    private $model;

    public function __construct() {
        $this->model = new vungtrongModel();
    }

    public function getInfoVungTrong() {


        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }

        $userData = $this->model->getInfoVungTrong();

        return ["status" => "success", "data" => $userData];
    }
    public function updateInfoVungTrong() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }

        $result = $this->model->updateInfoVungTrong(
            $data['MaVung'] ?? "",
            $data['TenVung'] ?? "",
            $data['DiaChi'] ?? "",
            $data['Tinh'] ?? "",
            $data['Huyen'] ?? "",
            $data['Xa'] ?? "",
            $data['DienTich'] ?? "",
            $data['SoHoDan'] ?? "",
            $data['TrangThai'] ?? "",
            $data['MoTa'] ?? ""
        );
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Cập nhật thành công"];
        }
        return $result;
    }

    public function addInfoVungTrong() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }

        $result = $this->model->addInfoVungTrong(
            $data['TenVung'] ?? "",
            $data['DiaChi'] ?? "",
            $data['Tinh'] ?? "",
            $data['Huyen'] ?? "",
            $data['Xa'] ?? "",
            $data['DienTich'] ?? "",
            $data['SoHoDan'] ?? "",
            $data['TrangThai'] ?? "",
            $data['MoTa'] ?? ""
        );
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Thêm vùng trồng thành công"];
        }
        return $result;
    }

    public function deleteInfoVungTrong() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data || empty($data['MaVung'])) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }

        $result = $this->model->deleteInfoVungTrong($data['MaVung']);
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Xóa vùng trồng thành công"];
        }
        return $result;
    }
}