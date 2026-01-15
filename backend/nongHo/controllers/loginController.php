<?php
require_once __DIR__ . '/../models/loginModels.php';

class LoginController {
    private $model;

    public function __construct() {
        $this->model = new LoginModel();
    }

    public function handleLogin($email, $password) {
        session_start();
        if (empty($email) || empty($password)) {
            return ["status" => "error", "message" => "Vui lòng nhập đầy đủ thông tin"];
        }

        $user = $this->model->checkLogin($email, $password);

        if ($user) {
            // Lưu thông tin cần thiết vào session
            $_SESSION["MaNguoiDung"] = $user["manguoidung"];
            $_SESSION["Email"]       = $user["email"];

            return [
                "status"  => "success",
                "message" => "Đăng nhập thành công"
            ];
        } else {
            return ["status" => "error", "message" => "Sai tài khoản hoặc mật khẩu"];
        }
    }
}