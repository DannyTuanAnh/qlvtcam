<?php
require_once __DIR__ . '/../../config/connect.php';

class LoginModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function checkLogin($email, $password) {
        $stmt = $this->db->conn->prepare("select * from quan_ly_nguoi_dung where Email = ? and MatKhau = ? and VaiTro = 'nongho'");
        if (!$stmt) {
            die(json_encode(["status" => "error", "message" => "SQL error: " . $this->db->conn->error]));
        }
        $stmt->bind_param("ss", $email, $password); // Ở đây chưa mã hóa password
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // trả về mảng thông tin user
        }
        return false;
    }
}