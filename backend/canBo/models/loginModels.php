<?php
require_once __DIR__ . '/../../config/connect.php';

class LoginModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function checkLogin($email, $password) {
        $stmt = $this->db->conn->prepare("SELECT qlnd.*, cb.MaCanBo
FROM quan_ly_nguoi_dung qlnd
LEFT JOIN canbo_kt cb 
    ON cb.MaNguoiDung = qlnd.MaNguoiDung
WHERE qlnd.Email = ? 
  AND qlnd.MatKhau = ? 
  AND qlnd.VaiTro = 'canbo';");
        $stmt->bind_param("ss", $email, $password); // Ở đây chưa mã hóa password
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // trả về mảng thông tin user
    }
    return false;
    }
}