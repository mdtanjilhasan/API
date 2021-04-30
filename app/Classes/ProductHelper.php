<?php

require_once __DIR__ . '/../../database/Database.php';
require __DIR__ . '/../../vendor/autoload.php';

use Firebase\JWT\JWT;

class ProductHelper extends Database
{
    private $connection;
    private $table = 'products';

    public function __construct()
    {
        $this->connection = $this->getConnection();
    }

    private function getImageData($image)
    {
		$targetDirectory = __DIR__."/../../public/products/";
		$name = md5(basename($image["name"]));
		$imageFileType = strtolower(pathinfo(basename($image["name"]),PATHINFO_EXTENSION));
		$targetFile = $targetDirectory . $name . '.' .$imageFileType;
		$serverPath = 'public/products/' . $name . '.' .$imageFileType;
		return ['targetFile' => $targetFile, 'serverPath' => $serverPath];
    }

    private function uploadAndGetPath($image)
    {
    	$check = getimagesize($image["tmp_name"]); // $uploadOk = ($check !== false);
		if (!$check) {
			return ['success' => true, 'message' => 'Invalid File Uploaded'];
		}
		$data = $this->getImageData($image);

		if (file_exists($data['targetFile'])) {
			return ['success' => true, 'message' => 'File already exists'];
		}

		if (move_uploaded_file($image["tmp_name"], $data['targetFile'])) {			
			return ['success' => true, 'path' => $data['serverPath']];
		} else {
			return ['success' => false, 'path' => null];
		}
    }

	private function getImagePath($image)
	{
		$data = $this->uploadAndGetPath($image);
		if (array_key_exists('path',$data) && !empty($data['path'])) {
			return $data['path'];
		}
		return null;
	}

	private function getSql($id, $path, $table, $update)
	{
		$data = ['product_id' => $id, 'path' => $path, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')];
        $keys = implode(',', array_keys($data));
        $values = implode(',', array_map(function ($value) {
            return ':' . $value;
        }, array_keys($data)));
        if ($update) {
            unset($data['created_at']);
            unset($data['product_id']);
            $keys = array_map(function ($value) {
                return $value . ' = :' . $value;
            }, array_keys($data));
            $values = implode(',', array_filter($keys));
            $sql = "UPDATE $table SET $values WHERE product_id = :product_id";
            $data['product_id'] = $id;
        } else {
            $sql = "INSERT INTO $table ($keys) VALUES ($values)";
        }
        return ['sql' => $sql, 'data' => $data];
	}

	public function uploadImage($id, $table, $image, $update = false)
    {
        try {
        	$path = $this->getImagePath($image);

        	if (empty($path)) {
        		return ['success' => false, 'message' => 'Image Upload Failed'];
        	}

        	$sql = $this->getSql($id, $path, $table,$update);
            
            $stmt = $this->connection->prepare($sql['sql']);
            $stmt->execute($sql['data']);
            return ['success' => true, 'message' => 'Image Upload Successful'];
        } catch (PDOException $exception) {
            return ['success' => false, 'message' => 'Image Upload Failed'];
        }
    }

    public function getImage($productId)
    {
        try {
            $sql = "SELECT * FROM product_images WHERE product_id = $productId";            
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count > 0) {
                $data = $stmt->fetchAll();
            } else {
                $data = $stmt->fetch();
            }
            return ['success' => true, 'data' => $data];
        } catch (PDOException $exception) {
            return ['success' => false, 'message' => null];
        }
    }
}