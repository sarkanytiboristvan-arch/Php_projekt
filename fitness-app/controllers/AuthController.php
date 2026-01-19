<?php

/**
 * AuthController
 * Handles user authentication (login, register, logout)
 */
class AuthController extends BaseController
{
    /**
     * Show login form
     */
    public function login(): void
    {
        // If already logged in, redirect to dashboard
        if (isset($_SESSION['user_id'])) {
            $this->redirect('home');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $error = 'Please fill in all fields';
            } else {
                $user = $this->model->verify($email, $password);
                
                if ($user) {
                    // Set session variables
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_email'] = $user['email'];
                    
                    // Set cookie for "remember me" functionality
                    if (isset($_POST['remember'])) {
                        setcookie('user_email', $email, time() + (86400 * 30), '/'); // 30 days
                    }
                    
                    $this->redirect('home', 'Welcome back, ' . htmlspecialchars($user['name']) . '!');
                } else {
                    $error = 'Invalid email or password';
                }
            }
        }

        $rememberedEmail = $_COOKIE['user_email'] ?? '';
        $this->render('auth/login', [
            'error' => $error ?? null,
            'rememberedEmail' => $rememberedEmail
        ]);
    }

    /**
     * Show registration form
     */
    public function register(): void
    {
        // If already logged in, redirect to dashboard
        if (isset($_SESSION['user_id'])) {
            $this->redirect('home');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            $errors = [];

            if (empty($name) || empty($email) || empty($password)) {
                $errors[] = 'Please fill in all fields';
            }

            if ($password !== $confirmPassword) {
                $errors[] = 'Passwords do not match';
            }

            if (strlen($password) < 6) {
                $errors[] = 'Password must be at least 6 characters';
            }

            if ($this->model->emailExists($email)) {
                $errors[] = 'Email already registered';
            }

            if (empty($errors)) {
                if ($this->model->create($name, $email, $password)) {
                    $this->redirect('login', 'Registration successful! Please login.');
                } else {
                    $errors[] = 'Registration failed. Please try again.';
                }
            }
        }

        $this->render('auth/register', [
            'errors' => $errors ?? [],
            'name' => $name ?? '',
            'email' => $email ?? ''
        ]);
    }

    /**
     * Logout user
     */
    public function logout(): void
    {
        // Destroy session
        session_destroy();
        
        // Clear cookie
        setcookie('user_email', '', time() - 3600, '/');
        
        header('Location: index.php?action=login');
        exit;
    }
}
