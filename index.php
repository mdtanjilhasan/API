<?php

////use database\Database;
//
//require_once 'database/Database.php';
//require_once 'database/Config.php';
////header('Content-Type: application/json');
//$db = new Database('users');
//$obj = new Config();
//
//$id = $obj->sanitizeInput($_GET['id']);
//$single = $db->getSingleEntity($id);
//echo json_encode($single);
////print_r($single);
print_r(password_hash('12345678',PASSWORD_BCRYPT));
