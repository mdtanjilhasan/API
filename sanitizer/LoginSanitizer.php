<?php

use Rakit\Validation\Validator;

require_once __DIR__ . '/../database/Sanitizer.php';
require_once __DIR__ . '/../vendor/autoload.php';

abstract class LoginSanitizer extends Sanitizer
{
    protected function sanitizeCredentials($request)
    {
        $email = array_key_exists('email', $request) ? $this->sanitizeInput($request['email']) : null;
        $password = array_key_exists('password', $request) ? $this->sanitizeInput($request['password']) : null;
        if (is_null($email) || is_null($password)) {
            return null;
        }
        return ['email' => $email, 'password' => $password];
    }

    protected function formValidation($request)
    {
        $validator = new Validator;
        $validation = $validator->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validation->fails()) {
            // handling errors
            $errors = $validation->errors();
            return $errors->firstOfAll();
        }
        return null;
    }
}