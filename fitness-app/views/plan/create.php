<?php include 'views/layouts/header.php'; ?>
<div class="container">
    <div class="page-header">
        <h1>Új edzésterv létrehozása</h1>
        <a href="index.php?action=plan_list" class="btn btn-secondary">← Vissza</a>
    </div>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <ul><?php foreach ($errors as $error): ?><li><?php echo htmlspecialchars($error); ?></li><?php endforeach; ?></ul>
        </div>
    <?php endif; ?>
    <div class="card">
        <form method="POST" class="form">
            <div class="form-group">
                <label for="name">Terv neve *</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Leírás *</label>
                <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($description ?? ''); ?></textarea>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="duration">Időtartam (hét) *</label>
                    <input type="number" id="duration" name="duration" value="<?php echo $duration ?? ''; ?>" min="1" required>
                </div>
                <div class="form-group">
                    <label for="difficulty">Nehézség *</label>
                    <select id="difficulty" name="difficulty" required>
                        <option value="">Válassz</option>
                        <option value="Kezdő">Kezdő</option>
                        <option value="Haladó">Haladó</option>
                        <option value="Professzionális">Professzionális</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="goals">Célok</label>
                <textarea id="goals" name="goals" rows="3"><?php echo htmlspecialchars($goals ?? ''); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Létrehozás</button>
        </form>
    </div>
</div>
<?php include 'views/layouts/footer.php'; ?>
