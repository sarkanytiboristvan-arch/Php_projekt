<?php

/**
 * DashboardController
 * Handles the main dashboard and home page
 */
class DashboardController extends BaseController
{
    private Workout $workoutModel;
    private Nutrition $nutritionModel;
    private Progress $progressModel;

    public function __construct($model)
    {
        parent::__construct($model);

        // Initialize additional models needed for dashboard
        $db = Database::getInstance();
        $this->workoutModel = new Workout($db);
        $this->nutritionModel = new Nutrition($db);
        $this->progressModel = new Progress($db);
    }

    /**
     * Show dashboard home page
     */
    public function home(): void
    {
        $this->requireAuth();

        $userId = $this->getUserId();

        // Get workout statistics
        $workoutStats = $this->workoutModel->getStatistics($userId);
        if (!$workoutStats) {
            $workoutStats = [
                'total_workouts' => 0,
                'total_duration' => 0,
                'total_calories' => 0,
                'avg_duration' => 0,
                'avg_calories' => 0
            ];
        }

        // Get daily nutrition stats
        $nutritionStats = $this->nutritionModel->getDailyStats($userId);
        if (!$nutritionStats) {
            $nutritionStats = [
                'total_meals' => 0,
                'total_calories' => 0,
                'total_protein' => 0,
                'total_carbs' => 0,
                'total_fats' => 0
            ];
        }

        // Get latest progress
        $latestProgress = $this->progressModel->getLatest($userId);

        // Get recent workouts
        $recentWorkouts = $this->workoutModel->getByUserId($userId);
        $workoutsArray = [];
        if ($recentWorkouts) {
            while ($row = $recentWorkouts->fetch_assoc()) {
                $workoutsArray[] = $row;
                if (count($workoutsArray) >= 5) break;
            }
        }

        // Get recent nutrition entries
        $recentNutrition = $this->nutritionModel->getByUserId($userId);
        $nutritionArray = [];
        if ($recentNutrition) {
            while ($row = $recentNutrition->fetch_assoc()) {
                $nutritionArray[] = $row;
                if (count($nutritionArray) >= 5) break;
            }
        }

        // Calculate daily calorie goal (simple formula: BMR * activity factor)
        $calorieGoal = 2000; // Default
        if ($latestProgress && isset($latestProgress['weight'])) {
            $weight = $latestProgress['weight'];
            $calorieGoal = round($weight * 24 * 1.2); // Basic calculation
        }

        $this->render('dashboard/home', [
            'userName' => $_SESSION['user_name'] ?? 'Felhasználó',
            'workoutStats' => $workoutStats,
            'nutritionStats' => $nutritionStats,
            'latestProgress' => $latestProgress,
            'recentWorkouts' => $workoutsArray,
            'recentNutrition' => $nutritionArray,
            'calorieGoal' => $calorieGoal,
            'flash' => $this->getFlash()
        ]);
    }
}