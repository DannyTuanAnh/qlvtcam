<?php
require_once __DIR__ . '/../models/profileModel.php';

class ProfileController {
    private $model;

    public function __construct() {
        $this->model = new ProfileModel();
    }

    public function getProfile() {


        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }

        $user_id = $_SESSION['MaNguoiDung'];
        $userData = $this->model->getUserById($user_id);

        return ["status" => "success", "data" => $userData];
    }

    public function updateProfile() {
   

        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }

        $user_id = $_SESSION['MaNguoiDung'];

        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }

        // Parse địa chỉ JSON
        $diaChiObj = json_decode($data['diaChi'], true);
        if (!$diaChiObj || !isset($diaChiObj['ap'], $diaChiObj['xa'], $diaChiObj['huyen'], $diaChiObj['tinh'])) {
            return ["status" => "error", "message" => "Địa chỉ không đầy đủ"];
        }

        $diaChiFull = $diaChiObj['ap'] . ', Xã ' . $diaChiObj['xa'] . ', Huyện ' . $diaChiObj['huyen'] . ', Tỉnh ' . $diaChiObj['tinh'];

        $result = $this->model->updateUserById(
            $user_id,
            $data['hoTen'],
            $data['gioiTinh'],
            $data['ngaySinh'],
            $diaChiObj['ap'],
            $diaChiObj['xa'],
            $diaChiObj['huyen'],
            $diaChiObj['tinh'],
            $diaChiFull,
            $data['sdt'] ?? "",
            $data['email'] ?? ""
        );

        if ($result["status"] === "success") {
            return ["status" => "success", "message" => "Cập nhật thành công"];
        }
        return $result;
    }
}