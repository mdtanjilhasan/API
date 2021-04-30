<?php

require_once __DIR__ . '/../database/Sanitizer.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Rakit\Validation\Validator;

abstract class ProductSanitizer extends Sanitizer
{
    private $table = 'products';

    private $fillable = ['name', 'sku', 'description', 'price', 'category_id'];

    protected function getTable()
    {
        return $this->table;
    }

    protected function getFields()
    {
        $fields = ['id'];
        $fields = array_merge($fields, $this->fillable, ['created_at', 'updated_at']);
        return $fields;
    }

    protected function validation(array $request)
    {
        $data = [];
        foreach ($this->fillable as $name) {
            if (array_key_exists($name, $request)) {
                $data[$name] = $this->sanitizeInput($request[$name]);
            }
        }
        return $data;
    }

    protected function formValidation($request)
    {
        $validator = new Validator;
        $validation = $validator->validate($request, [
            'name' => 'required',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'category_id' => 'required|integer',
            'image' => 'required|uploaded_file:0,500K,png,jpeg',
        ]);

        if ($validation->fails()) {
            // handling errors
            $errors = $validation->errors();
            return $errors->firstOfAll();
        }
        return null;
    }
}