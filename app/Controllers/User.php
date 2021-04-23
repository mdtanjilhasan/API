<?php

require_once 'app\Repository\Repository.php';
require_once 'database\Config.php';

class User
{
    private $instance;
    private $sanitizer;

    public function __construct()
    {
        $this->instance = new Repository('users');
        $this->sanitizer = new Config();
    }

    private function validation($data)
    {
        $filteredData = [];
        foreach ($data as $key => $value) {
            $filteredData[$key] = $this->sanitizer->sanitizeInput($value);
        }
        return $filteredData;
    }

    public function getAll()
    {
        return $this->instance->all();
    }

    public function show($id)
    {
        $id = $this->sanitizer->sanitizeInput($id);
        return $this->instance->find($id);
    }

    public function store($data)
    {
        $data = $this->validation($data);
        $this->instance->create($data);
    }
}