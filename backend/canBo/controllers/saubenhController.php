<?php
require_once __DIR__ . '/../models/saubenhModel.php';

class SauBenhController {
    private $model;

    public function __construct() {
        $this->model = new SauBenhModel();
    }

    public function getInfoSauBenh() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }

        $userData = $this->model->getInfoSauBenh();

        return ["status" => "success", "data" => $userData];
    }
    
}