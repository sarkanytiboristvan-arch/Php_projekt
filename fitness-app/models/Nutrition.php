<?php

/**
 * Nutrition Model
 * Handles nutrition tracking and calorie management
 */
class Nutrition extends BaseModel
{
    protected string $table = 'nutrition';

    /**
     * Create a new nutrition entry
     */
    public function create(int $userId, string $mealType, string $foodName, int $calories, float $protein, float $carbs, float $fats): bool
    {
        $sql = "INSERT INTO {$this->table} (user_id, meal_type, food_name, calories, protein, carbs, fats, meal_date, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, CURDATE(), NOW())";
        return $this->executeQuery($sql, 'issiddd', $userId, $mealType, $foodName, $calories, $protein, $carbs, $fats);
    }

    /**
     * Get all nutrition entries for a user
     */
    public function getByUserId(int $userId): mysqli_result|false
    {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY meal_date DESC, created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * Update nutrition entry
     */
    public function update(int $id, int $userId, string $mealType, string $foodName, int $calories, float $protein, float $carbs, float $fats): bool
    {
        $sql = "UPDATE {$this->table} 
                SET meal_type = ?, food_name = ?, calories = ?, protein = ?, carbs = ?, fats = ? 
                WHERE id = ? AND user_id = ?";
        return $this->executeQuery($sql, 'ssidddii', $mealType, $foodName, $calories, $protein, $carbs, $fats, $id, $userId);
    }

    /**
     * Get daily nutrition statistics
     */
    public function getDailyStats(int $userId): ?array
    {
        $sql = "SELECT 
                    COUNT(*) as total_meals,
                    SUM(calories) as total_calories,
                    SUM(protein) as total_protein,
                    SUM(carbs) as total_carbs,
                    SUM(fats) as total_fats
                FROM {$this->table} 
                WHERE user_id = ? AND meal_date = CURDATE()";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * Get weekly nutrition data
     */
    public function getWeeklyData(int $userId): mysqli_result|false
    {
        $sql = "SELECT 
                    DATE(meal_date) as date,
                    SUM(calories) as total_calories,
                    SUM(protein) as total_protein,
                    SUM(carbs) as total_carbs,
                    SUM(fats) as total_fats
                FROM {$this->table} 
                WHERE user_id = ? 
                AND meal_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
                GROUP BY DATE(meal_date)
                ORDER BY date";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        
        return $stmt->get_result();
    }
}
