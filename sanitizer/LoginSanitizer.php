<?php

require_once __DIR__.'/../database/Sanitizer.php';

abstract class LoginSanitizer extends Sanitizer
{
    protected function sanitizeCredentials($request)
    {
        $object = new Sanitizer();
        $email = array_key_exists('email',$request) ? $object->sanitizeInput($request['email']) : null;
        $password = array_key_exists('password',$request) ? $object->sanitizeInput($request['password']) : null;
        if (is_null($email) || is_null($password)) {
            return null;
        }
        return ['email' => $email, 'password' => $password];
    }
}