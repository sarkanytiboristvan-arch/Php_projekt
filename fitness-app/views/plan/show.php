<?php include 'views/layouts/header.php'; ?>
<div class="container">
    <div class="page-header">
        <h1><?php echo htmlspecialchars($plan['name']); ?></h1>
        <a href="index.php?action=plan_list" class="btn btn-secondary">← Vissza</a>
    </div>
    <div class="card">
        <h2>Leírás</h2>
        <p><?php echo nl2br(htmlspecialchars($plan['description'])); ?></p>
        <h3>Részletek</h3>
        <ul>
            <li><strong>Időtartam:</strong> <?php echo $plan['duration_weeks']; ?> hét</li>
            <li><strong>Nehézség:</strong> <?php echo htmlspecialchars($plan['difficulty']); ?></li>
            <?php if ($plan['goals']): ?>
            <li><strong>Célok:</strong> <?php echo nl2br(htmlspecialchars($plan['goals'])); ?></li>
            <?php endif; ?>
        </ul>
    </div>
</div>
<?php include 'views/layouts/footer.php'; ?>
