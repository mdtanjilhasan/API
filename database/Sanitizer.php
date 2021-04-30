<?php


class Sanitizer
{
    public function sanitizeInput($data)
    {
        if (empty($data))
            return $data;

        $data = strip_tags($data);
        $data = htmlspecialchars($data);
        $data = stripslashes($data);
        $data = trim($data);
        return $data;
    }
}