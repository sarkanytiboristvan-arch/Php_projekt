<?php

/**
 * WorkoutPlanController
 * Handles workout plan management
 */
class WorkoutPlanController extends BaseController
{
    /**
     * List all workout plans
     */
    public function list(): void
    {
        $this->requireAuth();
        
        $userId = $this->getUserId();
        $plans = $this->model->getByUserId($userId);
        $templates = $this->model->getTemplates();

        $this->render('plan/index', [
            'plans' => $plans,
            'templates' => $templates,
            'flash' => $this->getFlash()
        ]);
    }

    /**
     * Show create workout plan form
     */
    public function create(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $duration = (int)($_POST['duration'] ?? 0);
            $difficulty = $_POST['difficulty'] ?? '';
            $goals = trim($_POST['goals'] ?? '');

            $errors = [];

            if (empty($name)) {
                $errors[] = 'Plan name is required';
            }
            if (empty($description)) {
                $errors[] = 'Description is required';
            }
            if ($duration <= 0) {
                $errors[] = 'Duration must be greater than 0';
            }
            if (empty($difficulty)) {
                $errors[] = 'Difficulty level is required';
            }

            if (empty($errors)) {
                if ($this->model->create($this->getUserId(), $name, $description, $duration, $difficulty, $goals)) {
                    $this->redirect('plan_list', 'Workout plan created successfully!');
                } else {
                    $errors[] = 'Failed to create workout plan';
                }
            }

            $this->render('plan/create', [
                'errors' => $errors,
                'name' => $name,
                'description' => $description,
                'duration' => $duration,
                'difficulty' => $difficulty,
                'goals' => $goals
            ]);
            return;
        }

        $this->render('plan/create', ['errors' => []]);
    }

    /**
     * Show workout plan details
     */
    public function show(): void
    {
        $this->requireAuth();

        $id = (int)($_GET['id'] ?? 0);
        $plan = $this->model->getById($id);

        if (!$plan) {
            $this->redirect('plan_list', 'Plan not found', 'error');
        }

        $this->render('plan/show', [
            'plan' => $plan
        ]);
    }

    /**
     * Clone a template plan
     */
    public function clone(): void
    {
        $this->requireAuth();

        $id = (int)($_GET['id'] ?? 0);
        
        if ($this->model->clonePlan($id, $this->getUserId())) {
            $this->redirect('plan_list', 'Plan cloned successfully!');
        } else {
            $this->redirect('plan_list', 'Failed to clone plan', 'error');
        }
    }
}
