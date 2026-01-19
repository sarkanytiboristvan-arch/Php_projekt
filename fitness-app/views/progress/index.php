<?php include 'views/layouts/header.php'; ?>
<div class="container">
    <div class="page-header">
        <h1>Haladás nyomon követés</h1>
        <div>
            <a href="index.php?action=progress_charts" class="btn btn-primary"><i class="fa-solid fa-chart-simple"></i> Grafikonok</a>
            <a href="index.php?action=progress_create" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Új mérés</a>
        </div>
    </div>
    <?php if ($flash): ?><div class="alert alert-<?php echo $flash['type']; ?>"><?php echo htmlspecialchars($flash['message']); ?></div><?php endif; ?>
    <?php if ($weightChange && $weightChange['current_weight']): ?>
    <div class="stats-summary">
        <div class="stat-box">
            <h3>Jelenlegi súly</h3>
            <p class="stat-number"><?php echo number_format($weightChange['current_weight'], 1); ?> kg</p>
        </div>
        <div class="stat-box">
            <h3>Kezdő súly</h3>
            <p class="stat-number"><?php echo number_format($weightChange['starting_weight'], 1); ?> kg</p>
        </div>
        <div class="stat-box">
            <h3>Változás</h3>
            <p class="stat-number"><?php $diff = $weightChange['current_weight'] - $weightChange['starting_weight']; echo ($diff >= 0 ? '+' : '') . number_format($diff, 1); ?> kg</p>
        </div>
    </div>
    <?php endif; ?>
    <div class="card">
        <table class="data-table">
            <thead><tr><th>Dátum</th><th>Súly</th><th>Testzsír %</th><th>Mellkas</th><th>Derék</th><th>Csípő</th></tr></thead>
            <tbody>
                <?php if ($entries && $entries->num_rows > 0): ?>
                    <?php while ($row = $entries->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo date('Y-m-d', strtotime($row['measurement_date'])); ?></td>
                        <td><?php echo number_format($row['weight'], 1); ?> kg</td>
                        <td><?php echo $row['body_fat'] ? number_format($row['body_fat'], 1) . '%' : '-'; ?></td>
                        <td><?php echo $row['chest'] ? number_format($row['chest'], 1) . ' cm' : '-'; ?></td>
                        <td><?php echo $row['waist'] ? number_format($row['waist'], 1) . ' cm' : '-'; ?></td>
                        <td><?php echo $row['hips'] ? number_format($row['hips'], 1) . ' cm' : '-'; ?></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="empty-state">Még nincsenek mérések rögzítve.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include 'views/layouts/footer.php'; ?>
