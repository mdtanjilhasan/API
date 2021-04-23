<?php

require_once __DIR__.'/../app/Controllers/LoginController.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

$api = $_SERVER['REQUEST_METHOD'];

if ($api == 'POST')
{
    $instance = new LoginController();
    $instance->userLogin($_REQUEST);
    exit();
}

http_response_code(405);
die('Method Not Allowed');