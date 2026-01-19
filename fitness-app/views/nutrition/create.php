<?php include 'views/layouts/header.php'; ?>
<div class="container">
    <div class="page-header">
        <h1>Új étkezés rögzítése</h1>
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
                    <option value="">Válassz</option>
                    <option value="Reggeli">Reggeli</option>
                    <option value="Tízórai">Tízórai</option>
                    <option value="Ebéd">Ebéd</option>
                    <option value="Uzsonna">Uzsonna</option>
                    <option value="Vacsora">Vacsora</option>
                    <option value="Snack">Snack</option>
                </select>
            </div>
            <div class="form-group">
                <label for="food_name">Étel neve *</label>
                <input type="text" id="food_name" name="food_name" value="<?php echo htmlspecialchars($foodName ?? ''); ?>" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="calories">Kalória (kcal) *</label>
                    <input type="number" id="calories" name="calories" value="<?php echo $calories ?? ''; ?>" min="1" required>
                </div>
                <div class="form-group">
                    <label for="protein">Protein (g)</label>
                    <input type="number" step="0.1" id="protein" name="protein" value="<?php echo $protein ?? ''; ?>" min="0">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="carbs">Szénhidrát (g)</label>
                    <input type="number" step="0.1" id="carbs" name="carbs" value="<?php echo $carbs ?? ''; ?>" min="0">
                </div>
                <div class="form-group">
                    <label for="fats">Zsír (g)</label>
                    <input type="number" step="0.1" id="fats" name="fats" value="<?php echo $fats ?? ''; ?>" min="0">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Mentés</button>
        </form>
    </div>
</div>
<?php include 'views/layouts/footer.php'; ?>
