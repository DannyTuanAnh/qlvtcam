<?php
require_once __DIR__ . '/../models/nguoidungModel.php';

class NguoiDungController {
    private $model;

    public function __construct() {
        $this->model = new NguoiDungModel();
    }

    public function getNguoiDung() {


        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }

        $userData = $this->model->getInfoNguoiDung();

        return ["status" => "success", "data" => $userData];
    }
}