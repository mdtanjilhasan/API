<?php

require_once __DIR__ . '/../../../app/Controllers/ProductsController.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header('Access-Control-Allow-Headers: Content-Type, Authorization, Origin, X-Auth_token');

$api = $_SERVER['REQUEST_METHOD'];

if ($api == 'POST') {
    if ($_POST['_method'] != 'PUT') {
        http_response_code(400);
        die('Bad Request');
    }
    $id = intval($_POST['id'] ?? '');

    if (empty($id)) {
        http_response_code(400);
        die('Invalid Request');
    }
    $formData = $_POST + $_FILES;
    $instance = new ProductsController();
    $instance->edit($id, $formData);
    exit();
}

http_response_code(405);
die('Method Not Allowed');