<?php
/**
 * Fitness Tracker Application
 * MVC Architecture with REST API support
 * 
 * Entry point for the application
 */

// Load configuration
require_once 'config/database.php';

// Load classes
require_once 'classes/Database.php';
require_once 'classes/Router.php';

// Load base classes
require_once 'models/BaseModel.php';
require_once 'controllers/BaseController.php';

// Load models
require_once 'models/User.php';
require_once 'models/Workout.php';
require_once 'models/Nutrition.php';
require_once 'models/Progress.php';
require_once 'models/WorkoutPlan.php';

// Load controllers
require_once 'controllers/AuthController.php';
require_once 'controllers/DashboardController.php';
require_once 'controllers/WorkoutController.php';
require_once 'controllers/NutritionController.php';
require_once 'controllers/ProgressController.php';
require_once 'controllers/WorkoutPlanController.php';

// Initialize database and router
$database = Database::getInstance();
$router = new Router($database);

// Authentication routes
$router->add('login', AuthController::class, 'login', User::class);
$router->add('register', AuthController::class, 'register', User::class);
$router->add('logout', AuthController::class, 'logout', User::class);

// Dashboard routes
$router->add('home', DashboardController::class, 'home', User::class);

// Workout routes
$router->add('workout_list', WorkoutController::class, 'list', Workout::class);
$router->add('workout_create', WorkoutController::class, 'create', Workout::class);
$router->add('workout_edit', WorkoutController::class, 'edit', Workout::class);
$router->add('workout_delete', WorkoutController::class, 'delete', Workout::class);

// Nutrition routes
$router->add('nutrition_list', NutritionController::class, 'list', Nutrition::class);
$router->add('nutrition_create', NutritionController::class, 'create', Nutrition::class);
$router->add('nutrition_edit', NutritionController::class, 'edit', Nutrition::class);
$router->add('nutrition_delete', NutritionController::class, 'delete', Nutrition::class);
$router->add('calculator', NutritionController::class, 'calculator', Nutrition::class);

// Progress routes
$router->add('progress_list', ProgressController::class, 'list', Progress::class);
$router->add('progress_create', ProgressController::class, 'create', Progress::class);
$router->add('progress_charts', ProgressController::class, 'charts', Progress::class);

// Workout Plan routes
$router->add('plan_list', WorkoutPlanController::class, 'list', WorkoutPlan::class);
$router->add('plan_create', WorkoutPlanController::class, 'create', WorkoutPlan::class);
$router->add('plan_show', WorkoutPlanController::class, 'show', WorkoutPlan::class);
$router->add('plan_clone', WorkoutPlanController::class, 'clone', WorkoutPlan::class);

// Dispatch the request
$router->dispatch();
