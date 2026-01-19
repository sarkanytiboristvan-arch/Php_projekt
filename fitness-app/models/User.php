<?php

/**
 * User Model
 * Handles user authentication and user data
 */
class User extends BaseModel
{
    protected string $table = 'users';

    /**
     * Create a new user
     */
    public function create(string $name, string $email, string $password): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        // Check if email already exists
        if ($this->emailExists($email)) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO {$this->table} (name, email, password, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $this->db->prepare($sql);
        
        if (!$stmt) {
            return false;
        }
        
        $stmt->bind_param('sss', $name, $email, $hashedPassword);
        return $stmt->execute();
    }

    /**
     * Get user by email
     */
    public function getByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Verify user credentials
     */
    public function verify(string $email, string $password): ?array
    {
        $user = $this->getByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return null;
    }

    /**
     * Update user profile
     */
    public function updateProfile(int $userId, string $name, string $email, int $age, string $gender, float $height): bool
    {
        $sql = "UPDATE {$this->table} SET name = ?, email = ?, age = ?, gender = ?, height = ? WHERE id = ?";
        return $this->executeQuery($sql, 'ssissi', $name, $email, $age, $gender, $height, $userId);
    }

    /**
     * Check if email exists
     */
    public function emailExists(string $email): bool
    {
        $sql = "SELECT id FROM {$this->table} WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        
        if (!$stmt) {
            return false;
        }
        
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->num_rows > 0;
    }
}
