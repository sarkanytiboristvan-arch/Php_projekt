<?php include 'views/layouts/header.php'; ?>
    <div class="container">
        <div class="page-header">
            <h1>Táplálkozás</h1>
            <div>
                <a href="index.php?action=calculator" class="btn btn-primary"><i class="fa-solid fa-calculator"></i> Kalória kalkulátor</a>
                <a href="index.php?action=nutrition_create" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Új étkezés</a>
            </div>
        </div>
        <?php if ($flash): ?><div class="alert alert-<?php echo $flash['type']; ?>"><?php echo htmlspecialchars($flash['message']); ?></div><?php endif; ?>
        <?php if ($dailyStats): ?>
            <div class="stats-summary">
                <div class="stat-box"><h3>Mai kalória</h3><p class="stat-number"><?php echo number_format($dailyStats['total_calories']); ?> kcal</p></div>
                <div class="stat-box"><h3>Protein</h3><p class="stat-number"><?php echo number_format($dailyStats['total_protein'], 1); ?>g</p></div>
                <div class="stat-box"><h3>Szénhidrát</h3><p class="stat-number"><?php echo number_format($dailyStats['total_carbs'], 1); ?>g</p></div>
                <div class="stat-box"><h3>Zsír</h3><p class="stat-number"><?php echo number_format($dailyStats['total_fats'], 1); ?>g</p></div>
            </div>
        <?php endif; ?>
        <div class="card">
            <table class="data-table">
                <thead><tr><th>Dátum</th><th>Étkezés</th><th>Étel</th><th>Kalória</th><th>Protein</th><th>Szénhidrát</th><th>Zsír</th><th>Műveletek</th></tr></thead>
                <tbody>
                <?php if ($entries && $entries->num_rows > 0): ?>
                    <?php while ($row = $entries->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo date('Y-m-d', strtotime($row['meal_date'])); ?></td>
                            <td><?php echo htmlspecialchars($row['meal_type']); ?></td>
                            <td><?php echo htmlspecialchars($row['food_name']); ?></td>
                            <td><?php echo $row['calories']; ?> kcal</td>
                            <td><?php echo number_format($row['protein'], 1); ?>g</td>
                            <td><?php echo number_format($row['carbs'], 1); ?>g</td>
                            <td><?php echo number_format($row['fats'], 1); ?>g</td>
                            <td>
                                <a href="index.php?action=nutrition_edit&id=<?php echo $row['id']; ?>" class="btn btn-sm">Szerkeszt</a>
                                <a href="index.php?action=nutrition_delete&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Biztosan törölni szeretnéd?')">Töröl</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="8" class="empty-state">Még nincsenek étkezések rögzítve.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php include 'views/layouts/footer.php'; ?>