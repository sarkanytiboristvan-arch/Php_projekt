<?php

/**
 * NutritionController
 * Handles nutrition and meal tracking
 */
class NutritionController extends BaseController
{
    /**
     * List all nutrition entries
     */
    public function list(): void
    {
        $this->requireAuth();
        
        $userId = $this->getUserId();
        $entries = $this->model->getByUserId($userId);
        $dailyStats = $this->model->getDailyStats($userId);

        $this->render('nutrition/index', [
            'entries' => $entries,
            'dailyStats' => $dailyStats,
            'flash' => $this->getFlash()
        ]);
    }

    /**
     * Show create nutrition entry form
     */
    public function create(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mealType = $_POST['meal_type'] ?? '';
            $foodName = trim($_POST['food_name'] ?? '');
            $calories = (int)($_POST['calories'] ?? 0);
            $protein = (float)($_POST['protein'] ?? 0);
            $carbs = (float)($_POST['carbs'] ?? 0);
            $fats = (float)($_POST['fats'] ?? 0);

            $errors = [];

            if (empty($mealType)) {
                $errors[] = 'Meal type is required';
            }
            if (empty($foodName)) {
                $errors[] = 'Food name is required';
            }
            if ($calories <= 0) {
                $errors[] = 'Calories must be greater than 0';
            }

            if (empty($errors)) {
                if ($this->model->create($this->getUserId(), $mealType, $foodName, $calories, $protein, $carbs, $fats)) {
                    $this->redirect('nutrition_list', 'Meal added successfully!');
                } else {
                    $errors[] = 'Failed to add meal';
                }
            }

            $this->render('nutrition/create', [
                'errors' => $errors,
                'mealType' => $mealType,
                'foodName' => $foodName,
                'calories' => $calories,
                'protein' => $protein,
                'carbs' => $carbs,
                'fats' => $fats
            ]);
            return;
        }

        $this->render('nutrition/create', ['errors' => []]);
    }

    /**
     * Show edit nutrition entry form
     */
    public function edit(): void
    {
        $this->requireAuth();

        $id = (int)($_GET['id'] ?? 0);
        $entry = $this->model->getById($id);

        if (!$entry || $entry['user_id'] != $this->getUserId()) {
            $this->redirect('nutrition_list', 'Entry not found', 'error');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mealType = $_POST['meal_type'] ?? '';
            $foodName = trim($_POST['food_name'] ?? '');
            $calories = (int)($_POST['calories'] ?? 0);
            $protein = (float)($_POST['protein'] ?? 0);
            $carbs = (float)($_POST['carbs'] ?? 0);
            $fats = (float)($_POST['fats'] ?? 0);

            $errors = [];

            if (empty($foodName)) {
                $errors[] = 'Food name is required';
            }
            if ($calories <= 0) {
                $errors[] = 'Calories must be greater than 0';
            }

            if (empty($errors)) {
                if ($this->model->update($id, $this->getUserId(), $mealType, $foodName, $calories, $protein, $carbs, $fats)) {
                    $this->redirect('nutrition_list', 'Meal updated successfully!');
                } else {
                    $errors[] = 'Failed to update meal';
                }
            }

            $entry = array_merge($entry, $_POST);
        }

        $this->render('nutrition/edit', [
            'entry' => $entry,
            'errors' => $errors ?? []
        ]);
    }

    /**
     * Delete nutrition entry
     */
    public function delete(): void
    {
        $this->requireAuth();

        $id = (int)($_GET['id'] ?? 0);
        $entry = $this->model->getById($id);

        if (!$entry || $entry['user_id'] != $this->getUserId()) {
            $this->redirect('nutrition_list', 'Entry not found', 'error');
        }

        if ($this->model->delete($id)) {
            $this->redirect('nutrition_list', 'Meal deleted successfully!');
        } else {
            $this->redirect('nutrition_list', 'Failed to delete meal', 'error');
        }
    }

    /**
     * Show calorie calculator
     */
    public function calculator(): void
    {
        $this->requireAuth();

        $result = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $weight = (float)($_POST['weight'] ?? 0);
            $height = (float)($_POST['height'] ?? 0);
            $age = (int)($_POST['age'] ?? 0);
            $gender = $_POST['gender'] ?? 'male';
            $activity = $_POST['activity'] ?? '1.2';

            if ($weight > 0 && $height > 0 && $age > 0) {
                // Mifflin-St Jeor Equation
                if ($gender === 'male') {
                    $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age) + 5;
                } else {
                    $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age) - 161;
                }

                $tdee = $bmr * (float)$activity;

                $result = [
                    'bmr' => round($bmr),
                    'tdee' => round($tdee),
                    'lose' => round($tdee - 500),
                    'gain' => round($tdee + 500)
                ];
            }
        }

        $this->render('nutrition/calculator', [
            'result' => $result
        ]);
    }
}
