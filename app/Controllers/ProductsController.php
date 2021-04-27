<?php

require_once __DIR__ . '/../../sanitizer/ProductSanitizer.php';
require_once __DIR__ . '/../Repositories/CRUD/CRUDRepository.php';

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
        $messages = $this->formValidation($request);

        if (!empty($messages)) {
            http_response_code(422);
            die(json_encode(['success' => false, 'messages' => $messages]));
        }

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

    public function edit($id, array $request)
    {
        $messages = $this->formValidation($request);

        if (!empty($messages)) {
            http_response_code(422);
            die(json_encode(['success' => false, 'messages' => $messages]));
        }
        $request = $this->validation($request);
        $response = $this->instance->update($id, $request);
        if (!$response['success']) {
            http_response_code($response['status']);
            die(json_encode($response));
        }
        http_response_code(200);
        echo json_encode($response);
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