<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Fitness Tracker'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>
<?php if (isset($_SESSION['user_id'])): ?>
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">
                <a href="index.php?action=home">Fitness Tracker</a>
            </div>
            <ul class="nav-menu">
                <li><a href="index.php?action=home">Dashboard</a></li>
                <li><a href="index.php?action=workout_list">Edzések</a></li>
                <li><a href="index.php?action=nutrition_list">Táplálkozás</a></li>
                <li><a href="index.php?action=progress_list">Haladás</a></li>
                <li><a href="index.php?action=plan_list">Tervek</a></li>
                <li class="user-menu">
                    <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    <a href="index.php?action=logout" class="btn-logout">Kilépés</a>
                </li>
            </ul>
        </div>
    </nav>
<?php endif; ?>

<main class="main-content">