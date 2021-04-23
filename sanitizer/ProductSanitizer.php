<?php

require_once __DIR__.'/../database/Sanitizer.php';

abstract class ProductSanitizer extends Sanitizer
{
    private $table = 'products';

    protected function getTable()
    {
        return $this->table;
    }
}