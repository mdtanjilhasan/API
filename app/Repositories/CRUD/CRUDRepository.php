<?php

require_once 'database\Database.php';
require_once 'app\Repositories\CRUD\CRUDInterface.php';

class CRUDRepository extends Database implements CRUDInterface
{
    protected $table;
    protected $connection;

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
            return $stmt->fetchAll();
        } catch (PDOException $exception) {
            die($exception->getMessage());
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
            return json_encode(['success' => true, 'message' => 'Data Inserted Successfully']);
        } catch (PDOException $exception) {
            die($exception->getMessage());
        }
    }

    // update record in the database
    public function update($id, array $data)
    {
        $record = $this->find($id);
        return $record->update($data);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->table->destroy($id);
    }

    // show the record with the given id
    public function find($id)
    {
        try {
            $sql = "select * from $this->table where id = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute(['id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $exception) {
            die($exception->getMessage());
        }
    }
}