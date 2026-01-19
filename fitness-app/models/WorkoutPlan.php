<?php

/**
 * WorkoutPlan Model
 * Handles workout plans and templates
 */
class WorkoutPlan extends BaseModel
{
    protected string $table = 'workout_plans';

    /**
     * Create a new workout plan
     */
    public function create(int $userId, string $name, string $description, int $duration, string $difficulty, string $goals): bool
    {
        $sql = "INSERT INTO {$this->table} (user_id, name, description, duration_weeks, difficulty, goals, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        return $this->executeQuery($sql, 'ississ', $userId, $name, $description, $duration, $difficulty, $goals);
    }

    /**
     * Get all workout plans for a user
     */
    public function getByUserId(int $userId): mysqli_result|false
    {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        return $stmt->get_result();
    }

    /**
     * Get all public/template workout plans
     */
    public function getTemplates(): mysqli_result|false
    {
        $sql = "SELECT * FROM {$this->table} WHERE is_template = 1 ORDER BY name ASC";
        return $this->db->query($sql);
    }

    /**
     * Update workout plan
     */
    public function update(int $id, int $userId, string $name, string $description, int $duration, string $difficulty, string $goals): bool
    {
        $sql = "UPDATE {$this->table} 
                SET name = ?, description = ?, duration_weeks = ?, difficulty = ?, goals = ? 
                WHERE id = ? AND user_id = ?";
        return $this->executeQuery($sql, 'ssissii', $name, $description, $duration, $difficulty, $goals, $id, $userId);
    }

    /**
     * Clone a template plan for user
     */
    public function clonePlan(int $planId, int $userId): bool
    {
        $plan = $this->getById($planId);
        if (!$plan) {
            return false;
        }

        return $this->create(
            $userId,
            $plan['name'] . ' (Copy)',
            $plan['description'],
            $plan['duration_weeks'],
            $plan['difficulty'],
            $plan['goals']
        );
    }
}
