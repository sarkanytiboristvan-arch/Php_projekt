<?php include 'views/layouts/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>Üdvözöljük, <?php echo htmlspecialchars($userName); ?>!</h1>
    </div>

    <?php if ($flash): ?>
        <div class="alert alert-<?php echo $flash['type']; ?>">
            <?php echo htmlspecialchars($flash['message']); ?>
        </div>
    <?php endif; ?>

    <div class="dashboard-grid">
        <!-- Today's Summary -->
        <div class="card">
            <h2>Mai összefoglaló</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-label">Kalóriabevitel</span>
                    <span class="stat-value">
                        <?php echo number_format($nutritionStats['total_calories'] ?? 0); ?>
                        <small>/ <?php echo number_format($calorieGoal); ?> kcal</small>
                    </span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Protein</span>
                    <span class="stat-value"><?php echo number_format($nutritionStats['total_protein'] ?? 0, 1); ?>g</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Szénhidrát</span>
                    <span class="stat-value"><?php echo number_format($nutritionStats['total_carbs'] ?? 0, 1); ?>g</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Zsír</span>
                    <span class="stat-value"><?php echo number_format($nutritionStats['total_fats'] ?? 0, 1); ?>g</span>
                </div>
            </div>
        </div>

        <!-- Workout Stats -->
        <div class="card">
            <h2>Edzésstatisztikák</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-label">Összes edzés</span>
                    <span class="stat-value"><?php echo $workoutStats['total_workouts'] ?? 0; ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Összes idő</span>
                    <span class="stat-value"><?php echo number_format($workoutStats['total_duration'] ?? 0); ?> perc</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Elégetett kalória</span>
                    <span class="stat-value"><?php echo number_format($workoutStats['total_calories'] ?? 0); ?> kcal</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Átlagos időtartam</span>
                    <span class="stat-value"><?php echo number_format($workoutStats['avg_duration'] ?? 0); ?> perc</span>
                </div>
            </div>
        </div>

        <!-- Current Progress -->
        <?php if ($latestProgress): ?>
        <div class="card">
            <h2>Aktuális haladás</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-label">Súly</span>
                    <span class="stat-value"><?php echo number_format($latestProgress['weight'], 1); ?> kg</span>
                </div>
                <?php if ($latestProgress['body_fat']): ?>
                <div class="stat-item">
                    <span class="stat-label">Testzsír %</span>
                    <span class="stat-value"><?php echo number_format($latestProgress['body_fat'], 1); ?>%</span>
                </div>
                <?php endif; ?>
                <div class="stat-item">
                    <span class="stat-label">Utolsó mérés</span>
                    <span class="stat-value"><?php echo date('Y-m-d', strtotime($latestProgress['measurement_date'])); ?></span>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Quick Actions -->
        <div class="card">
            <h2>Gyors műveletek</h2>
            <div class="quick-actions">
                <a href="index.php?action=workout_create" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Edzés hozzáadása</a>
                <a href="index.php?action=nutrition_create" class="btn btn-primary"><i class="fa-solid fa-utensils"></i> Étkezés rögzítése</a>
                <a href="index.php?action=progress_create" class="btn btn-primary"><i class="fa-solid fa-chart-line"></i> Haladás mérése</a>
                <a href="index.php?action=calculator" class="btn btn-primary"><i class="fa-solid fa-calculator"></i> Kalória kalkulátor</a>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="recent-activity">
        <div class="card">
            <h2>Legutóbbi edzések</h2>
            <?php if (empty($recentWorkouts)): ?>
                <p class="empty-state">Még nincsenek rögzített edzések.</p>
            <?php else: ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Dátum</th>
                            <th>Típus</th>
                            <th>Időtartam</th>
                            <th>Kalória</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentWorkouts as $workout): ?>
                        <tr>
                            <td><?php echo date('Y-m-d', strtotime($workout['workout_date'])); ?></td>
                            <td><?php echo htmlspecialchars($workout['type']); ?></td>
                            <td><?php echo $workout['duration']; ?> perc</td>
                            <td><?php echo $workout['calories_burned']; ?> kcal</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

        <div class="card">
            <h2>Legutóbbi étkezések</h2>
            <?php if (empty($recentNutrition)): ?>
                <p class="empty-state">Még nincsenek rögzített étkezések.</p>
            <?php else: ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Dátum</th>
                            <th>Étkezés</th>
                            <th>Étel</th>
                            <th>Kalória</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentNutrition as $entry): ?>
                        <tr>
                            <td><?php echo date('Y-m-d', strtotime($entry['meal_date'])); ?></td>
                            <td><?php echo htmlspecialchars($entry['meal_type']); ?></td>
                            <td><?php echo htmlspecialchars($entry['food_name']); ?></td>
                            <td><?php echo $entry['calories']; ?> kcal</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
