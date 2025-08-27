<?php
require_once __DIR__ . '/../models/thuadatModel.php';

class ThuaDatController {
    private $model;

    public function __construct() {
        $this->model = new ThuaDatModel();
    }

    public function getThuaDat() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }

        $user_id = $_SESSION['MaNguoiDung'];
        $userData = $this->model->getThuaDatByID($user_id);

        return ["status" => "success", "data" => $userData];
    }
}