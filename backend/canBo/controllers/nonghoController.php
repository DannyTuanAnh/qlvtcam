<?php
require_once __DIR__ . '/../models/nonghoModel.php';

class NongHoController {
    private $model;

    public function __construct() {
        $this->model = new NongHoModel();
    }

    public function getInfoNongHo() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }

        $userData = $this->model->getInfoNongHo();
        return ["status" => "success", "data" => $userData];
    }

    public function updateInfoNongHo() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }

        // Validate dữ liệu
        if (empty($data['MaHo'])) {
            return ["status" => "error", "message" => "Mã nông hộ không được để trống"];
        }
        if (empty($data['HoTen'])) {
            return ["status" => "error", "message" => "Họ tên không được để trống"];
        }
        if (empty($data['SoDienThoai'])) {
            return ["status" => "error", "message" => "Số điện thoại không được để trống"];
        }
        if (empty($data['MaVung'])) {
            return ["status" => "error", "message" => "Vùng trồng không được để trống"];
        }

        $result = $this->model->updateInfoNongHo(
            $data['MaHo'],
            $data['HoTen'],
            $data['GioiTinh'] ?? 'Nam',
            $data['SoDienThoai'],
            $data['Email'] ?? null,
            $data['NgaySinh'] ?? null,
            $data['MaVung'],
            $data['DiaChi'] ?? ""
        );
        
        return $result;
    }

    public function addInfoNongHo() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data) {
            return ["status" => "error", "message" => "Dữ liệu không hợp lệ"];
        }

        // Validate dữ liệu
        if (empty($data['hoTen'])) {
            return ["status" => "error", "message" => "Họ tên không được để trống"];
        }
        if (empty($data['sdt'])) {
            return ["status" => "error", "message" => "Số điện thoại không được để trống"];
        }
        if (empty($data['gioiTinh'])) {
            return ["status" => "error", "message" => "Giới tính không được để trống"];
        }
        if (empty($data['ngaySinh'])) {
            return ["status" => "error", "message" => "Ngày sinh không được để trống"];
        }
        if (empty($data['tinh'])) {
            return ["status" => "error", "message" => "Tỉnh không được để trống"];
        }
        if (empty($data['huyen'])) {
            return ["status" => "error", "message" => "Huyện không được để trống"];
        }
        if (empty($data['xa'])) {
            return ["status" => "error", "message" => "Xã không được để trống"];
        }
        if (empty($data['ap'])) {
            return ["status" => "error", "message" => "Ấp không được để trống"];
        }
        if (empty($data['email'])) {
            return ["status" => "error", "message" => "Email không được để trống"];
        }
        if (empty($data['pass'])) {
            return ["status" => "error", "message" => "Mật khẩu không được để trống"];
        }
        if (empty($data['diaChi'])) {
            $diaChi = $data['ap'] . ', Xã ' . $data['xa'] . ', Huyện ' . $data['huyen'] . ', Tỉnh ' . $data['tinh'];
        }
        else {
            $diaChi = $data['diaChi'] . ', ' .  $data['ap'] . ', Xã' . $data['xa'] . ', Huyện' . $data['huyen'] . ', Tỉnh' . $data['tinh'];
        }

        $result = $this->model->addInfoNongHo(
            $data['hoTen'],
            $data['sdt'],
            $data['gioiTinh'],
            $data['ngaySinh'],
            $data['tinh'],
            $data['huyen'],
            $data['xa'],
            $data['ap'],
            $data['email'],
            $data['pass'],
            $diaChi ?? ""
        );
            
        return $result;
    }

    public function deleteInfoNongHo() {
        if (!isset($_SESSION['MaNguoiDung'])) {
            http_response_code(401);
            return ["status" => "error", "message" => "Chưa đăng nhập"];
        }
        
        $data = json_decode(file_get_contents("php://input"), true);
        if (!$data || empty($data['MaHo'])) {
            return ["status" => "error", "message" => "Mã nông hộ không được để trống"];
        }

        $result = $this->model->deleteInfoNongHo($data['MaHo']);
        return $result;
    }
}
?>