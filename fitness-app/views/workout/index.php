<?php include 'views/layouts/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>Edzések</h1>
        <a href="index.php?action=workout_create" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Új edzés</a>
    </div>

    <?php if ($flash): ?>
        <div class="alert alert-<?php echo $flash['type']; ?>">
            <?php echo htmlspecialchars($flash['message']); ?>
        </div>
    <?php endif; ?>

    <?php if ($stats): ?>
    <div class="stats-summary">
        <div class="stat-box">
            <h3>Összes edzés</h3>
            <p class="stat-number"><?php echo $stats['total_workouts']; ?></p>
        </div>
        <div class="stat-box">
            <h3>Összes időtartam</h3>
            <p class="stat-number"><?php echo number_format($stats['total_duration']); ?> perc</p>
        </div>
        <div class="stat-box">
            <h3>Elégetett kalória</h3>
            <p class="stat-number"><?php echo number_format($stats['total_calories']); ?> kcal</p>
        </div>
    </div>
    <?php endif; ?>

    <div class="card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Dátum</th>
                    <th>Cím</th>
                    <th>Típus</th>
                    <th>Időtartam</th>
                    <th>Kalória</th>
                    <th>Műveletek</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($workouts && $workouts->num_rows > 0): ?>
                    <?php while ($row = $workouts->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo date('Y-m-d', strtotime($row['workout_date'])); ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['type']); ?></td>
                        <td><?php echo $row['duration']; ?> perc</td>
                        <td><?php echo $row['calories_burned']; ?> kcal</td>
                        <td>
                            <a href="index.php?action=workout_edit&id=<?php echo $row['id']; ?>" class="btn btn-sm">Szerkeszt</a>
                            <a href="index.php?action=workout_delete&id=<?php echo $row['id']; ?>" 
                               class="btn btn-sm btn-danger" 
                               onclick="return confirm('Biztosan törölni szeretnéd?')">Töröl</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="empty-state">Még nincsenek edzések rögzítve.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
