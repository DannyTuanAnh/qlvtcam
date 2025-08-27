<?php
require_once __DIR__ . '/config.php';

class connectDB {
    public $conn;

    public function __construct() {
        $this->conn = new mysqli(servername, username, password, database);
        if ($this->conn->connect_error) {
            die(json_encode(["status" => "error", "message" => "Kết nối thất bại: " . $this->conn->connect_error]));
        }
        $this->conn->set_charset("utf8mb4");
    }

    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}