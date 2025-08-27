<?php
header("Content-Type: application/json");
session_start();

// Xóa toàn bộ biến trong session
unset($_SESSION['MaNguoiDung']);
unset($_SESSION['Email']);

// Hủy session trên server
session_destroy();

// Nếu có cookie session thì xóa luôn (tùy chọn)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

echo json_encode([
    "status" => "success",
    "message" => "Đăng xuất thành công"
]);
exit();