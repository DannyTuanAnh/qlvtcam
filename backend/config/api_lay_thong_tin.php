<?php
require_once "connect.php";
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


// Truy vấn lấy số thửa theo từng vụ mùa
$sql = "
    SELECT vu_mua.id AS vu_mua_id, vu_mua.ten_vu_mua, COUNT(thua_ruong.id) AS so_thua
    FROM vu_mua
    LEFT JOIN thua_ruong ON vu_mua.id = thua_ruong.vu_mua_id
    GROUP BY vu_mua.id, vu_mua.ten_vu_mua
    ORDER BY vu_mua.id
";
$result = $conn->query($sql);

if (!$result) {
    echo json_encode([
        "error" => true,
        "message" => "Lỗi truy vấn: " . $conn->error
    ]);
    exit;
}

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            "vu_mua_id" => $row['vu_mua_id'],
            "ten_vu_mua" => $row['ten_vu_mua'],
            "so_thua" => $row['so_thua']
        ];
    }
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode([]);
}

$conn->close();
?>
