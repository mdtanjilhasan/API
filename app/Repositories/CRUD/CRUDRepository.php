<?php

require_once __DIR__ . '/../../../database/Database.php';
require_once 'CRUDInterface.php';
require __DIR__ . '/../../../vendor/autoload.php';

use Firebase\JWT\JWT;

class CRUDRepository extends Database implements CRUDInterface
{
    protected $table;
    protected $connection;
    private $secretKey = "JWT_HTTP_SECRET_KEY";

    // Constructor to bind table
    public function __construct($table)
    {
        $this->table = $table;
        $this->connection = $this->getConnection();
    }

    // Get all entities of table
    public function all()
    {
        try {
            $sql = "SELECT * FROM $this->table";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            return ['success' => true, 'message' => ucfirst($this->table) . ' List', 'data' => $data, 'status' => 200];
        } catch (PDOException $exception) {
            return ['success' => true, 'message' => $exception->getMessage(), 'data' => null, 'status' => 400];
        }
    }

    // create a new record in the database
    public function create(array $data)
    {
        try {
            $data = array_merge($data, ['created_at' => date('Y-m-d h:i:s'), 'updated_at' => date('Y-m-d h:i:s')]);
            $keys = implode(',', array_keys($data));
            $values = implode(',', array_map(function ($value) {
                return ':' . $value;
            }, array_keys($data)));
            $sql = "INSERT INTO $this->table ($keys) VALUES ($values)";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($data);
            return ['success' => true, 'message' => 'Data Inserted Successfully', 'status' => 200];
        } catch (PDOException $exception) {
            return ['success' => false, 'message' => $exception->getMessage(), 'status' => 400];
        }
    }

    // update record in the database
    public function update($id, array $data)
    {
        $this->connection->beginTransaction();
        try {
            $data = array_merge(['id' => $id], $data, ['updated_at' => date('Y-m-d h:i:s')]);
            $keys = array_map(function ($value) {
                if ($value != 'id') {
                    return $value . ' = :' . $value;
                }
            }, array_keys($data));
            $values = implode(',', array_filter($keys));
            $sql = "UPDATE $this->table SET $values WHERE id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($data);
            $this->connection->commit();
            return ['success' => true, 'message' => 'Data Updated Successfully', 'status' => 200];
        } catch (PDOException $exception) {
            $this->connection->rollBack();
            return ['success' => false, 'message' => $exception->getMessage(), 'status' => 400];
        }
    }

    // remove record from the database
    public function delete($id)
    {
        try {
            $sql = "DELETE FROM $this->table where id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute(['id' => $id]);

            return ['success' => true, 'message' => 'Delete Successful'];
        } catch (PDOException $exception) {
            return ['success' => false, 'message' => 'Delete Failed'];
        }
    }

    // show the record with the given id
    public function find($id)
    {
        try {
            $sql = "select * from $this->table where id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute(['id' => $id]);
            $data = $stmt->fetch();
            return ['success' => true, 'message' => ucfirst($this->table) . ' Data', 'data' => $data, 'status' => 200];
        } catch (PDOException $exception) {
            return ['success' => false, 'message' => $exception->getMessage(), 'data' => null, 'status' => 400];
        }
    }

    public function tokenIsValid($flag = true)
    {
        return $this->checkValidToken($flag);
    }

    private function checkValidToken($withPermission)
    {
        try {
            if (!array_key_exists('HTTP_AUTHORIZATION', $_SERVER)) {
                return ['success' => false, 'message' => 'Unauthorized Access', 'status' => 401];
            }
            $token = explode(' ', $_SERVER['HTTP_AUTHORIZATION'])[1];
            $decoded = JWT::decode($token, $this->secretKey, array('HS256'));

            if (!$withPermission) {
                return ['success' => true, 'message' => 'success', 'status' => 200];
            }

            $json = json_encode($decoded);
            $array = json_decode($json, true);
            if ($this->userHasPermission($array['data']['id'])) {
                return ['success' => true, 'message' => 'success', 'status' => 200];
            }
            throw new Exception('Access Denied');
        } catch (Exception $exception) {
            return ['success' => false, 'message' => $exception->getMessage(), 'status' => 403];
        }
    }

    private function userHasPermission($id)
    {
        try {
            $sql = "select * from users where id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute(['id' => $id]);
            $count = $stmt->rowCount();
            if ($count > 0) {
                $data = $stmt->fetch();
                if ($data['is_admin']) {
                    return true;
                }
            }
            throw new Exception();
        } catch (Exception $exception) {
            return false;
        }
    }
}