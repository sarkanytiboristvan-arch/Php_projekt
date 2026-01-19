<?php

/**
 * WorkoutController
 * Handles workout CRUD operations
 */
class WorkoutController extends BaseController
{
    /**
     * List all workouts
     */
    public function list(): void
    {
        $this->requireAuth();
        
        $userId = $this->getUserId();
        $workouts = $this->model->getByUserId($userId);
        $stats = $this->model->getStatistics($userId);

        $this->render('workout/index', [
            'workouts' => $workouts,
            'stats' => $stats,
            'flash' => $this->getFlash()
        ]);
    }

    /**
     * Show create workout form
     */
    public function create(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $type = $_POST['type'] ?? '';
            $duration = (int)($_POST['duration'] ?? 0);
            $calories = (int)($_POST['calories'] ?? 0);
            $notes = trim($_POST['notes'] ?? '');

            $errors = [];

            if (empty($title)) {
                $errors[] = 'Title is required';
            }
            if (empty($type)) {
                $errors[] = 'Workout type is required';
            }
            if ($duration <= 0) {
                $errors[] = 'Duration must be greater than 0';
            }
            if ($calories < 0) {
                $errors[] = 'Calories cannot be negative';
            }

            if (empty($errors)) {
                if ($this->model->create($this->getUserId(), $title, $type, $duration, $calories, $notes)) {
                    $this->redirect('workout_list', 'Workout added successfully!');
                } else {
                    $errors[] = 'Failed to add workout';
                }
            }

            $this->render('workout/create', [
                'errors' => $errors,
                'title' => $title,
                'type' => $type,
                'duration' => $duration,
                'calories' => $calories,
                'notes' => $notes
            ]);
            return;
        }

        $this->render('workout/create', ['errors' => []]);
    }

    /**
     * Show edit workout form
     */
    public function edit(): void
    {
        $this->requireAuth();

        $id = (int)($_GET['id'] ?? 0);
        $workout = $this->model->getById($id);

        if (!$workout || $workout['user_id'] != $this->getUserId()) {
            $this->redirect('workout_list', 'Workout not found', 'error');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $type = $_POST['type'] ?? '';
            $duration = (int)($_POST['duration'] ?? 0);
            $calories = (int)($_POST['calories'] ?? 0);
            $notes = trim($_POST['notes'] ?? '');

            $errors = [];

            if (empty($title)) {
                $errors[] = 'Title is required';
            }
            if ($duration <= 0) {
                $errors[] = 'Duration must be greater than 0';
            }

            if (empty($errors)) {
                if ($this->model->update($id, $this->getUserId(), $title, $type, $duration, $calories, $notes)) {
                    $this->redirect('workout_list', 'Workout updated successfully!');
                } else {
                    $errors[] = 'Failed to update workout';
                }
            }

            $workout = array_merge($workout, $_POST);
        }

        $this->render('workout/edit', [
            'workout' => $workout,
            'errors' => $errors ?? []
        ]);
    }

    /**
     * Delete workout
     */
    public function delete(): void
    {
        $this->requireAuth();

        $id = (int)($_GET['id'] ?? 0);
        $workout = $this->model->getById($id);

        if (!$workout || $workout['user_id'] != $this->getUserId()) {
            $this->redirect('workout_list', 'Workout not found', 'error');
        }

        if ($this->model->delete($id)) {
            $this->redirect('workout_list', 'Workout deleted successfully!');
        } else {
            $this->redirect('workout_list', 'Failed to delete workout', 'error');
        }
    }
}
