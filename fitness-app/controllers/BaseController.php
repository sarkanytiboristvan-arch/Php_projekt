<?php

/**
 * BaseController abstract class
 * Provides common functionality for all controllers
 */
abstract class BaseController
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Render a view with data
     */
    protected function render(string $view, array $data = []): void
    {
        extract($data);
        $viewFile = "views/{$view}.php";

        if (!file_exists($viewFile)) {
            die("View file not found: {$viewFile}");
        }

        include $viewFile;
    }

    /**
     * Redirect to another action
     */
    protected function redirect(string $action, ?string $message = null, string $type = 'success'): void
    {
        $url = "index.php?action={$action}";

        if ($message !== null) {
            $_SESSION['flash_message'] = $message;
            $_SESSION['flash_type'] = $type;
        }

        header("Location: {$url}");
        exit;
    }

    /**
     * Check if user is logged in
     */
    protected function requireAuth(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('login', 'Please login to access this page', 'warning');
        }
    }

    /**
     * Get current user ID
     */
    protected function getUserId(): ?int
    {
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Set flash message
     */
    protected function setFlash(string $message, string $type = 'success'): void
    {
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_type'] = $type;
    }

    /**
     * Get and clear flash message
     */
    protected function getFlash(): ?array
    {
        if (isset($_SESSION['flash_message'])) {
            $flash = [
                'message' => $_SESSION['flash_message'],
                'type' => $_SESSION['flash_type'] ?? 'success'
            ];
            unset($_SESSION['flash_message'], $_SESSION['flash_type']);
            return $flash;
        }
        return null;
    }
}
