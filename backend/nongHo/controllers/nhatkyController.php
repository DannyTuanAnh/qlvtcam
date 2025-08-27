<?php
require_once __DIR__ . '/../models/nhatkyModel.php';

class nhatkyController {
    private $model;

    public function __construct() {
        $this->model = new nhatkyModel();
    }

    public function getNhatKy() {

        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }

        $user_id = $_SESSION['MaNguoiDung'];
        $userData = $this->model->getNhatKyById($user_id);

        return ["status" => "success", "data" => $userData];
    }
    public function updateNhatKy() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }

        $result = $this->model->updateNhatKyById(
            $data['maNhatKy'] ?? "",
            $data['maVu'] ?? "",
            $data['thoiGian'] ?? "",
            $data['loaiHoatDong'] ?? "",
            $data['noiDung'] ?? ""
        );
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Cập nhật thành công"];
        }
        if ($result["status"] === "error") {
            return ["status" => "error", "message" => $result["message"]];
        }
        return $result;
    }
    public function addNhatKy(){
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        $user_id = $_SESSION['MaNguoiDung'];
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }
        $result = $this->model->addNhatKy(
            $user_id,
            $data['loaiHoatDong'] ?? "",
            $data['noiDung'] ?? "",
            $data['maThua'] ?? "",
            $data['vuMua'] ?? "",
            $data['ngayThucHien'] ?? "" 
        );
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Cập nhật thành công"];
        }
        return $result;
    }
}