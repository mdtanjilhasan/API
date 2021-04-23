<?php

require_once 'app\Controllers\User.php';
header("Content-Type: application/json; charset=UTF-8");
$api = $_SERVER['REQUEST_METHOD'];

$user = new User();
if ($api == 'GET') {
    $id = intval($_GET['id'] ?? '');
    if ($id > 0) {
        $data = $user->show($id);
    } else {
        $data = $user->getAll();
    }
    echo json_encode($data);
}

if ($api == 'POST')
{
    $user->store($_REQUEST);
}
