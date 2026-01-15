<?php
require_once __DIR__ . '/../../config/connect.php';

class LoginModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function checkLogin($email, $password) {
        $stmt = $this->db->conn->prepare("SELECT * FROM quan_ly_nguoi_dung WHERE Email = ? AND MatKhau = ? AND VaiTro = 'nongho'");
        if (!$stmt) {
            die(json_encode(["status" => "error", "message" => "SQL error"]));
        }
        $stmt->execute([$email, $password]); // Ở đây chưa mã hóa password
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return $result; // trả về mảng thông tin user
        }
        return false;
    }
}