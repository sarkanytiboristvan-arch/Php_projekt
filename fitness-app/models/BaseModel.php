<?php

/**
 * BaseModel abstract class
 * Provides common CRUD operations for all models
 */
abstract class BaseModel
{
    protected mysqli $db;
    protected string $table;

    public function __construct(Database $database)
    {
        $this->db = $database->getConnection();
    }

    /**
     * Get all records
     */
    public function getAll(): mysqli_result|false
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        return $this->db->query($sql);
    }

    /**
     * Get record by ID
     */
    public function getById(int $id): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Delete record by ID
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $id);

        return $stmt->execute();
    }

    /**
     * Execute a prepared statement with parameters
     */
    protected function executeQuery(string $sql, string $types, ...$params): bool
    {
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param($types, ...$params);
        return $stmt->execute();
    }

    /**
     * Get last inserted ID
     */
    protected function getLastInsertId(): int
    {
        return $this->db->insert_id;
    }
}
