<?php

require_once __DIR__ . '/../database/Sanitizer.php';

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

    public function validation(array $request)
    {
        $data = [];
        foreach ($this->fillable as $name) {
            if (array_key_exists($name, $request)) {
                $data[$name] = $this->sanitizeInput($request[$name]);
            }
        }
        return $data;
    }
}