<?php
require_once __DIR__ . '/../models/canhtacModel.php';

class CanhTacController {
    private $model;

    public function __construct() {
        $this->model = new CanhTacModel();
    }

    public function getInfoCanhTac() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }

        $userData = $this->model->getInfoCayTrong();

        return ["status" => "success", "data" => $userData];
    }
    
}