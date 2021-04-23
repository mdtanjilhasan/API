<?php

require_once __DIR__.'/../../sanitizer/ProductSanitizer.php';
require_once __DIR__.'/../Repositories/CRUD/CRUDRepository.php';

class ProductsController extends ProductSanitizer
{
    private $instance;

    public function __construct()
    {
        $this->instance = new CRUDRepository($this->getTable());
    }

    public function getAll()
    {
        $data = $this->instance->all();
        return json_encode($data);
    }

    public function store(array $request)
    {

    }
}