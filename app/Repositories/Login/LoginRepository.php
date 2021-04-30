<?php

require_once __DIR__ . '/../../../database/Database.php';
require_once 'LoginInterface.php';
require __DIR__ . '/../../../vendor/autoload.php';

use \Firebase\JWT\JWT;

class LoginRepository extends Database implements LoginInterface
{
    private $table;
    private $database;
    private $secretKey = "JWT_HTTP_SECRET_KEY";
    private $issuerClaim = "JWT_HTTP_ISSUER"; // this can be the servername
    private $audienceClaim = "JWT_HTTP_AUDIENCE";
    private $issuedatClaim;
    private $notbeforeClaim;
    private $expireClaim;

    public function __construct($table)
    {
        $this->table = $table;
        $this->database = $this->getConnection();
    }

    private function setIssuedAt()
    {
        $this->issuedatClaim = time();
        return $this->issuedatClaim;
    }

    private function getIssuedAt()
    {
        return $this->setIssuedAt();
    }

    private function setExpiredAt()
    {
        $issue = $this->getIssuedAt();
        $this->expireClaim = $issue + (60 * 60);
        return $this->expireClaim;
    }

    private function getExpiredAt()
    {
        return $this->setExpiredAt();
    }

    private function setNotBeforeAt()
    {
        $issue = $this->getIssuedAt();
        $this->notbeforeClaim = $issue + 10;
        return $this->notbeforeClaim;
    }

    private function getNotBeforeAt()
    {
        return $this->setNotBeforeAt();
    }

    public function isUserExists($email)
    {
        $query = "SELECT * FROM $this->table  WHERE email = :email";
        $stmt = $this->database->prepare($query);
        $stmt->execute(['email' => $email]);
        $count = $stmt->rowCount();
        if ($count > 0) {
            return $stmt->fetch();
        }
        return null;
    }

    private function getTokenData($user)
    {
        return [
            "iss" => $this->issuerClaim,
            "aud" => $this->audienceClaim,
            "iat" => $this->getIssuedAt(),
            "exp" => $this->getExpiredAt(),
            "data" => ["id" => $user['id'], "email" => $user['email']]
        ];
    }

    public function verifyPasswordAndGenerateToken($user, $password)
    {
        if (password_verify($password, $user['password'])) {
            $token = $this->getTokenData($user);
            $jwt = JWT::encode($token, $this->secretKey);
            return [
                "success" => true,
                "message" => "Successful login.",
                "token" => $jwt,
                "expire_at" => $token['exp'],
                "user" => [
                    "name" => $user['name'],
                    "email" => $user['email'],
                    'is_admin' => $user['is_admin'] ? true : false
                ]
            ];
        }
        return null;
    }

    public function login(array $credentials)
    {
        $user = $this->isUserExists($credentials['email']);

        if (empty($user)) {
            return ["success" => false, "message" => "No user found", 'status' => 404];
        }

        $response = $this->verifyPasswordAndGenerateToken($user, $credentials['password']);
        if (empty($response)) {
            return ["success" => false, "message" => "Credentials Does Not Match.", 'status' => 401];
        }

        return $response;
    }

    public function logout()
    {
        if (!array_key_exists('HTTP_AUTHORIZATION', $_SERVER)) {
            return ['success' => false, 'message' => 'Unauthorized Access', 'status' => 401];
        }
        return ['success' => false, 'message' => 'Logout Successful', 'status' => 200];
    }
}