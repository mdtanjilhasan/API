<?php

require_once __DIR__.'/../../sanitizer/ProductSanitizer.php';
require_once __DIR__.'/../Repositories/CRUD/CRUDRepository.php';

class ProductsController extends ProductSanitizer
{
    private $instance;

    public function __construct()
    {
        $this->instance = new CRUDRepository($this->getTable());
        $result = $this->instance->tokenIsValid();
        if (!$result['success']) {
            http_response_code($result['status']);
            die(json_encode($result));
        }
    }

    public function getAll()
    {
        $data = $this->instance->all();
        echo json_encode($data);
    }

    public function store(array $request)
    {
        $request = $this->validation($request);
        $request['sku'] = uniqid();
        $response = $this->instance->create($request);
        if (!$response['success']) {
            http_response_code($response['status']);
            die(json_encode($response));
        }
        http_response_code(200);
        echo json_encode($response);
    }

    public function show($id)
    {
        $product = $this->instance->find($id);
        if (!$product['success']) {
            http_response_code($product['status']);
            die(json_encode($product));
        }
        http_response_code(200);
        echo json_encode($product);
    }

    public function destroy($id)
    {
        $response = $this->instance->delete($id);
        if (!$response['success']) {
            http_response_code(400);
        } else {
            http_response_code(200);
        }
        die(json_encode($response));
    }
}