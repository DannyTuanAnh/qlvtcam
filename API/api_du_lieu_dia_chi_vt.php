<?php
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Credentials: true');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

require_once __DIR__ . '/../backend/config/connect.php';

try {
    $conn = new connectDB();
    $sql = "SELECT Tinh, Huyen, Xa, DiaChi FROM vung_trong";
    $result = $conn->conn->query($sql);

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $tinh = $row['Tinh'];
        $huyen = $row['Huyen'];
        $xa = $row['Xa'];
        // Tách ấp từ trường DiaChi nếu có, hoặc để trống
        $apArr = [];
        if (!empty($row['DiaChi'])) {
            // Tìm các phần bắt đầu bằng "Ấp"
            $parts = explode(',', $row['DiaChi']);
            foreach ($parts as $part) {
                $part = trim($part);
                if (strpos($part, 'Ấp') === 0) {
                    $apArr[] = $part;
                }
            }
        }
        // Xây dựng cấu trúc lồng
        if (!isset($data[$tinh])) $data[$tinh] = [];
        if (!isset($data[$tinh][$huyen])) $data[$tinh][$huyen] = [];
        if (!isset($data[$tinh][$huyen][$xa])) $data[$tinh][$huyen][$xa] = [];
        $data[$tinh][$huyen][$xa] = array_unique(array_merge($data[$tinh][$huyen][$xa], $apArr));
    }

    echo json_encode([
        'status' => 'success',
        'data' => $data
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Lỗi server: ' . $e->getMessage()
    ]);
}