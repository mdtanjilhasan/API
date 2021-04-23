<?php

interface LoginInterface
{
    public function login(array $credentials);
    public function verifyPasswordAndGenerateToken($user,$password);
    public function isUserExists($email);
}