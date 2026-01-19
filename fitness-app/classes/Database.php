<?php

/**
 * Database Singleton class
 * Ensures only one database connection exists throughout the application
 */
class Database
{
    private static ?Database $instance = null;
    private mysqli $connection;

    /**
     * Private constructor to prevent direct instantiation
     */
    private function __construct()
    {
        $this->connection = new mysqli(
            DB_HOST,
            DB_USER,
            DB_PASS,
            DB_NAME
        );

        if ($this->connection->connect_error) {
            die('Database connection error: ' . $this->connection->connect_error);
        }

        $this->connection->set_charset(DB_CHARSET);
    }

    /**
     * Get singleton instance
     */
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get mysqli connection
     */
    public function getConnection(): mysqli
    {
        return $this->connection;
    }

    /**
     * Prevent cloning
     */
    public function __clone() {}

    /**
     * Prevent unserialization
     */
    public function __wakeup() {}
}
