<?php include 'views/layouts/header.php'; ?>
<div class="container">
    <div class="page-header">
        <h1>Étkezés szerkesztése</h1>
        <a href="index.php?action=nutrition_list" class="btn btn-secondary">← Vissza</a>
    </div>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <ul><?php foreach ($errors as $error): ?><li><?php echo htmlspecialchars($error); ?></li><?php endforeach; ?></ul>
        </div>
    <?php endif; ?>
    <div class="card">
        <form method="POST" class="form">
            <div class="form-group">
                <label for="meal_type">Étkezés típusa *</label>
                <select id="meal_type" name="meal_type" required>
                    <option value="Reggeli" <?php echo $entry['meal_type'] === 'Reggeli' ? 'selected' : ''; ?>>Reggeli</option>
                    <option value="Tízórai" <?php echo $entry['meal_type'] === 'Tízórai' ? 'selected' : ''; ?>>Tízórai</option>
                    <option value="Ebéd" <?php echo $entry['meal_type'] === 'Ebéd' ? 'selected' : ''; ?>>Ebéd</option>
                    <option value="Uzsonna" <?php echo $entry['meal_type'] === 'Uzsonna' ? 'selected' : ''; ?>>Uzsonna</option>
                    <option value="Vacsora" <?php echo $entry['meal_type'] === 'Vacsora' ? 'selected' : ''; ?>>Vacsora</option>
                    <option value="Snack" <?php echo $entry['meal_type'] === 'Snack' ? 'selected' : ''; ?>>Snack</option>
                </select>
            </div>
            <div class="form-group">
                <label for="food_name">Étel neve *</label>
                <input type="text" id="food_name" name="food_name" value="<?php echo htmlspecialchars($entry['food_name']); ?>" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="calories">Kalória (kcal) *</label>
                    <input type="number" id="calories" name="calories" value="<?php echo $entry['calories']; ?>" min="1" required>
                </div>
                <div class="form-group">
                    <label for="protein">Protein (g)</label>
                    <input type="number" step="0.1" id="protein" name="protein" value="<?php echo $entry['protein']; ?>" min="0">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="carbs">Szénhidrát (g)</label>
                    <input type="number" step="0.1" id="carbs" name="carbs" value="<?php echo $entry['carbs']; ?>" min="0">
                </div>
                <div class="form-group">
                    <label for="fats">Zsír (g)</label>
                    <input type="number" step="0.1" id="fats" name="fats" value="<?php echo $entry['fats']; ?>" min="0">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Mentés</button>
        </form>
    </div>
</div>
<?php include 'views/layouts/footer.php'; ?>
