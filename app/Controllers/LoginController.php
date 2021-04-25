<?php

require_once __DIR__.'/../Repositories/Login/LoginRepository.php';
require_once __DIR__.'/../../sanitizer/LoginSanitizer.php';

class LoginController extends LoginSanitizer
{
    private $table = 'users';
    private $instance;

    public function __construct()
    {
        $this->instance = new LoginRepository($this->table);
    }

    public function userLogin($credentials)
    {
        $messages = $this->formValidation($credentials);

        if (!empty($messages)) {
            http_response_code(422);
            die(json_encode(['success' => false, 'messages' => $messages]));
        }

        $credentials = $this->sanitizeCredentials($credentials);
        if (is_null($credentials)) {
            http_response_code(400);
            die(json_encode(['success' => false, 'message' => 'Oops! Something Went Wrong']));
        }
        $response = $this->instance->login($credentials);
        if (!$response['success']) {
            http_response_code($response['status']);
            unset($response['status']);
            die(json_encode($response));
        }
        http_response_code(200);
        echo json_encode($response);
    }

    public function decode()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJKV1RfSFRUUF9JU1NVRVIiLCJhdWQiOiJKV1RfSFRUUF9BVURJRU5DRSIsImlhdCI6MTYxOTE5ODc2NiwibmJmIjoxNjE5MTk4Nzc2LCJleHAiOjE2MTkxOTg4MjYsImRhdGEiOnsiaWQiOjEsImVtYWlsIjoiYWRtaW5AZ21haWwuY29tIn19.ldw4DRKoVafNNd8wrk7-LQFdYcGS3oA58TBxinR8wqQ';
        $this->instance->checkValidToken($token);
    }
}