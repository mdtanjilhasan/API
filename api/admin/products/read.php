<?php

require_once __DIR__.'/../../../app/Controllers/ProductsController.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");

$api = $_SERVER['REQUEST_METHOD'];

if ($api == 'GET')
{
    $id = intval($_GET['id'] ?? '');
    $instance = new ProductsController();
    if (empty($id)) {
        $instance->getAll();
    } else {
        $instance->show($id);
    }
    exit();
}

http_response_code(405);
die('Method Not Allowed');