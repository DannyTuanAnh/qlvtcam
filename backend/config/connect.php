<?php
require_once __DIR__ . '/config.php';

class connectDB {
    public $conn;

    public function __construct() {
        try {
            $dsn = "pgsql:host=" . DB_HOST .
                   ";port=" . DB_PORT .
                   ";dbname=" . DB_NAME;

            $this->conn = new PDO(
                $dsn,
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );

        } catch (PDOException $e) {
            die(json_encode([
                "status" => "error",
                "message" => "Kết nối PostgreSQL thất bại: " . $e->getMessage()
            ]));
        }
    }

    public function __destruct() {
        $this->conn = null;
    }
}