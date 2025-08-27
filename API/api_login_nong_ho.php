<?php
header("Content-Type: application/json");
require_once __DIR__ . '/../backend/nongHo/controllers/loginController.php';

$data = json_decode(file_get_contents("php://input"), true);
$email = $data["email"] ?? "";
$password = $data["password"] ?? "";

$controller = new LoginController();
$response = $controller->handleLogin($email, $password);

echo json_encode($response);