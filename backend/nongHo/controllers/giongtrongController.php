<?php
require_once __DIR__ . '/../models/giongtrongModel.php';

class giongtrongController {
    private $model;

    public function __construct() {
        $this->model = new giongtrongModel();
    }

    public function getGiongTrong() {

        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }

        $user_id = $_SESSION['MaNguoiDung'];
        $userData = $this->model->getGiongTrongById($user_id);

        return ["status" => "success", "data" => $userData];
    }

    public function getGiongCay() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }   
        $userData = $this->model->getAllCay();

        return ["status" => "success", "data" => $userData];
    }

    public function updateGiongTrong() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }

        $result = $this->model->updateGiongTrongById(
            $data['maTrong'] ?? "",
            $data['maGiong'] ?? "",
            $data['maVu'] ?? "",
            $data['maThua'] ?? "",
            $data['ngayTrong'] ?? "",
            $data['soLuongCay'] ?? ""
        );
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Cập nhật thành công"];
        }
        return $result;
    }

    public function addGiongTrong(){
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        $user_id = $_SESSION['MaNguoiDung'];
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }
        $result = $this->model->addGiongTrong(
            $data['maGiong'] ?? "",
            $data['maVu'] ?? "",
            $data['maThua'] ?? "",
            $data['ngayTrong'] ?? "",
            $data['soLuongCay'] ?? "" 
        );
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Cập nhật thành công"];
        }
        return $result;
    }

    public function xoaGiongTrong() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        $maTrong = $_POST['MaTrong'] ?? null;
        if (!$maTrong) {
            return ["status" => "error", "message" => "Mã giống trồng không hợp lệ"];
        }

        $result = $this->model->deleteGiongTrong($maTrong);
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Xóa báo cáo thành công"];
        }
        return $result;
    }
}