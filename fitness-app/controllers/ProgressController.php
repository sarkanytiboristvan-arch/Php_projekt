<?php

/**
 * ProgressController
 * Handles body measurements and progress tracking
 */
class ProgressController extends BaseController
{
    /**
     * List all progress entries
     */
    public function list(): void
    {
        $this->requireAuth();
        
        $userId = $this->getUserId();
        $entries = $this->model->getByUserId($userId);
        $weightChange = $this->model->getWeightChange($userId);

        $this->render('progress/index', [
            'entries' => $entries,
            'weightChange' => $weightChange,
            'flash' => $this->getFlash()
        ]);
    }

    /**
     * Show create progress entry form
     */
    public function create(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $weight = (float)($_POST['weight'] ?? 0);
            $bodyFat = !empty($_POST['body_fat']) ? (float)$_POST['body_fat'] : null;
            $chest = !empty($_POST['chest']) ? (float)$_POST['chest'] : null;
            $waist = !empty($_POST['waist']) ? (float)$_POST['waist'] : null;
            $hips = !empty($_POST['hips']) ? (float)$_POST['hips'] : null;
            $notes = trim($_POST['notes'] ?? '');

            $errors = [];

            if ($weight <= 0) {
                $errors[] = 'Weight is required and must be greater than 0';
            }

            if (empty($errors)) {
                if ($this->model->create($this->getUserId(), $weight, $bodyFat, $chest, $waist, $hips, $notes)) {
                    $this->redirect('progress_list', 'Progress entry added successfully!');
                } else {
                    $errors[] = 'Failed to add progress entry';
                }
            }

            $this->render('progress/create', [
                'errors' => $errors,
                'weight' => $weight,
                'bodyFat' => $bodyFat,
                'chest' => $chest,
                'waist' => $waist,
                'hips' => $hips,
                'notes' => $notes
            ]);
            return;
        }

        $this->render('progress/create', ['errors' => []]);
    }

    /**
     * Show progress charts and statistics
     */
    public function charts(): void
    {
        $this->requireAuth();
        
        $userId = $this->getUserId();
        $progressData = $this->model->getProgressData($userId, 90);

        $chartData = [
            'dates' => [],
            'weight' => [],
            'bodyFat' => [],
            'waist' => []
        ];

        if ($progressData) {
            while ($row = $progressData->fetch_assoc()) {
                $chartData['dates'][] = $row['measurement_date'];
                $chartData['weight'][] = $row['weight'];
                $chartData['bodyFat'][] = $row['body_fat'] ?? 0;
                $chartData['waist'][] = $row['waist'] ?? 0;
            }
        }

        $this->render('progress/charts', [
            'chartData' => $chartData,
            'flash' => $this->getFlash()
        ]);
    }
}
