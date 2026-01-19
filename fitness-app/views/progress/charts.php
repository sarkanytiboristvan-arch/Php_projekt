<?php include 'views/layouts/header.php'; ?>
<div class="container">
    <div class="page-header">
        <h1>Haladás grafikonok</h1>
        <a href="index.php?action=progress_list" class="btn btn-secondary">← Vissza</a>
    </div>
    <?php if ($flash): ?><div class="alert alert-<?php echo $flash['type']; ?>"><?php echo htmlspecialchars($flash['message']); ?></div><?php endif; ?>
    <div class="card">
        <h2>Súly változása (90 nap)</h2>
        <canvas id="weightChart" width="400" height="200"></canvas>
    </div>
    <div class="card">
        <h2>Testzsír % változása (90 nap)</h2>
        <canvas id="bodyFatChart" width="400" height="200"></canvas>
    </div>
</div>
<script>
const chartData = <?php echo json_encode($chartData); ?>;
</script>
<?php include 'views/layouts/footer.php'; ?>
