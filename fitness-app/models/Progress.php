<?php

/**
 * Progress Model
 * Handles body measurements and weight tracking
 */
class Progress extends BaseModel
{
    protected string $table = 'progress';

    /**
     * Create a new progress entry
     */
    public function create(int $userId, float $weight, float $bodyFat = null, float $chest = null, float $waist = null, float $hips = null, string $notes = ''): bool
    {
        $sql = "INSERT INTO {$this->table} (user_id, weight, body_fat, chest, waist, hips, notes, measurement_date, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, CURDATE(), NOW())";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('iddddds', $userId, $weight, $bodyFat, $chest, $waist, $hips, $notes);
        return $stmt->execute();
    }

    /**
     * Get all progress entries for a user
     */
    public function getByUserId(int $userId): mysqli_result|false
    {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY measurement_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * Get latest progress entry
     */
    public function getLatest(int $userId): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY measurement_date DESC LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Get progress over time
     */
    public function getProgressData(int $userId, int $days = 30): mysqli_result|false
    {
        $sql = "SELECT 
                    measurement_date,
                    weight,
                    body_fat,
                    chest,
                    waist,
                    hips
                FROM {$this->table} 
                WHERE user_id = ? 
                AND measurement_date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
                ORDER BY measurement_date ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('ii', $userId, $days);
        $stmt->execute();
        
        return $stmt->get_result();
    }

    /**
     * Calculate weight change
     */
    public function getWeightChange(int $userId): ?array
    {
        $sql = "SELECT 
                    (SELECT weight FROM {$this->table} WHERE user_id = ? ORDER BY measurement_date DESC LIMIT 1) as current_weight,
                    (SELECT weight FROM {$this->table} WHERE user_id = ? ORDER BY measurement_date ASC LIMIT 1) as starting_weight";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('ii', $userId, $userId);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_assoc();
    }
}
