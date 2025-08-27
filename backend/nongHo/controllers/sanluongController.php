<?php
require_once __DIR__ . '/../models/sanluongModel.php';

class sanluongController {
    private $model;

    public function __construct() {
        $this->model = new sanluongModel();
    }

    public function getSanLuong() {

        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }

        $user_id = $_SESSION['MaNguoiDung'];
        $userData = $this->model->getSanLuongById($user_id);

        return ["status" => "success", "data" => $userData];
    }
    public function getThongKeVuMua() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }

        $user_id = $_SESSION['MaNguoiDung'];
        $userData = $this->model->getThongKeVuMuaByID($user_id);

        return ["status" => "success", "data" => $userData];
    }

    public function getNewSanLuong() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }

        $user_id = $_SESSION['MaNguoiDung'];
        $userData = $this->model->newThuHoach($user_id);

        return ["status" => "success", "data" => $userData];
    }
    public function updateThuHoach(){
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }

        $result = $this->model->updateThuHoachById(
            $data['maThua'] ?? "",
            $data['maThuHoach'] ?? "",
            $data['maVu'] ?? "",
            $data['sanLuong'] ?? "",
            $data['chatLuong'] ?? "",
            $data['ghiChu'] ?? "",
            $data['ngayThuHoach'] ?? ""
        );
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Cập nhật thành công"];
        }
        return $result;
    }
    public function addThuHoach(){
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }
        $result = $this->model->addThuHoach(
            $data['maThua'] ?? "",
            $data['vuMua'] ?? "",
            $data['sanLuong'] ?? "",
            $data['chatLuong'] ?? "",
            $data['ghiChu'] ?? ""
        );
        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Cập nhật thành công"];
        }
        return $result;
    }
}