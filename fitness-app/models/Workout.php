<?php

/**
 * Workout Model
 * Handles workout tracking and management
 */
class Workout extends BaseModel
{
    protected string $table = 'workouts';

    /**
     * Create a new workout
     */
    public function create(int $userId, string $title, string $type, int $duration, int $caloriesBurned, string $notes = ''): bool
    {
        $sql = "INSERT INTO {$this->table} (user_id, title, type, duration, calories_burned, notes, workout_date, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, CURDATE(), NOW())";
        return $this->executeQuery($sql, 'ississ', $userId, $title, $type, $duration, $caloriesBurned, $notes);
    }

    /**
     * Get all workouts for a user
     */
    public function getByUserId(int $userId): mysqli_result|false
    {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY workout_date DESC, created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * Update workout
     */
    public function update(int $id, int $userId, string $title, string $type, int $duration, int $caloriesBurned, string $notes = ''): bool
    {
        $sql = "UPDATE {$this->table} 
                SET title = ?, type = ?, duration = ?, calories_burned = ?, notes = ? 
                WHERE id = ? AND user_id = ?";
        return $this->executeQuery($sql, 'ssiisii', $title, $type, $duration, $caloriesBurned, $notes, $id, $userId);
    }

    /**
     * Get workout statistics for user
     */
    public function getStatistics(int $userId): ?array
    {
        $sql = "SELECT 
                    COUNT(*) as total_workouts,
                    SUM(duration) as total_duration,
                    SUM(calories_burned) as total_calories,
                    AVG(duration) as avg_duration,
                    AVG(calories_burned) as avg_calories
                FROM {$this->table} 
                WHERE user_id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * Get weekly workout data
     */
    public function getWeeklyData(int $userId): mysqli_result|false
    {
        $sql = "SELECT 
                    DATE(workout_date) as date,
                    COUNT(*) as workout_count,
                    SUM(duration) as total_duration,
                    SUM(calories_burned) as total_calories
                FROM {$this->table} 
                WHERE user_id = ? 
                AND workout_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                GROUP BY DATE(workout_date)
                ORDER BY date";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        
        return $stmt->get_result();
    }
}
