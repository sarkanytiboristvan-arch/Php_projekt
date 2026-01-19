<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR | E_PARSE);

// Database configuration
define('DB_HOST', 'localhost:3307');
define('DB_NAME', 'fitness_tracker');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Application configuration
define('APP_NAME', 'Fitness Tracker');
define('BASE_URL', 'http://localhost/fitness-tracker');

// Session configuration
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 0); // Set to 1 in production with HTTPS
ini_set('session.use_strict_mode', 1);

session_start();
