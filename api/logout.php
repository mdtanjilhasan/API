<?php

require_once __DIR__ . '/../app/Controllers/LoginController.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header('Access-Control-Allow-Headers: Content-Type, Authorization, Origin, X-Auth_token');

$api = $_SERVER['REQUEST_METHOD'];

if ($api == 'POST') {
    if (!array_key_exists('HTTP_AUTHORIZATION', $_SERVER)) {
        die('no header found');
    }
    $instance = new LoginController();
    $instance->userLogout();
    exit();
}

http_response_code(405);
die('Method Not Allowed');