<?php

require_once __DIR__.'/../../../app/Controllers/ProductsController.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$api = $_SERVER['REQUEST_METHOD'];

if ($api == 'POST')
{
    if ($_REQUEST['_method'] != 'PUT') {
        http_response_code(400);
        die('Bad Request');
    }
    $id = intval($_REQUEST['id'] ?? '');
    if (empty($id)) {
        http_response_code(400);
        die('Invalid Request');
    }
    $instance = new ProductsController();
    $instance->edit($id, $_POST + $_FILES);
    exit();
}

http_response_code(405);
die('Method Not Allowed');