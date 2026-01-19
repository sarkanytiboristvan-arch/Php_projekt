<?php include 'views/layouts/header.php'; ?>
<div class="container">
    <div class="page-header">
        <h1>Edzéstervek</h1>
        <a href="index.php?action=plan_create" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Új terv</a>
    </div>
    <?php if ($flash): ?><div class="alert alert-<?php echo $flash['type']; ?>"><?php echo htmlspecialchars($flash['message']); ?></div><?php endif; ?>
    <h2>Saját terveim</h2>
    <div class="plans-grid">
        <?php if ($plans && $plans->num_rows > 0): ?>
            <?php while ($plan = $plans->fetch_assoc()): ?>
            <div class="plan-card">
                <h3><?php echo htmlspecialchars($plan['name']); ?></h3>
                <p><?php echo htmlspecialchars($plan['description']); ?></p>
                <div class="plan-meta">
                    <span>🔸 <?php echo $plan['duration_weeks']; ?> hét</span>
                    <span>🔸 <?php echo htmlspecialchars($plan['difficulty']); ?></span>
                </div>
                <a href="index.php?action=plan_show&id=<?php echo $plan['id']; ?>" class="btn btn-sm">Részletek</a>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="empty-state">Még nincsenek saját terveid. Hozz létre egyet vagy válassz a sablonok közül!</p>
        <?php endif; ?>
    </div>
    <?php if ($templates && $templates->num_rows > 0): ?>
    <h2>Sablon tervek</h2>
    <div class="plans-grid">
        <?php while ($template = $templates->fetch_assoc()): ?>
        <div class="plan-card">
            <h3><?php echo htmlspecialchars($template['name']); ?></h3>
            <p><?php echo htmlspecialchars($template['description']); ?></p>
            <div class="plan-meta">
                <span>🔸 <?php echo $template['duration_weeks']; ?> hét</span>
                <span>🔸 <?php echo htmlspecialchars($template['difficulty']); ?></span>
            </div>
            <a href="index.php?action=plan_clone&id=<?php echo $template['id']; ?>" class="btn btn-sm">Másolás</a>
        </div>
        <?php endwhile; ?>
    </div>
    <?php endif; ?>
</div>
<?php include 'views/layouts/footer.php'; ?>
