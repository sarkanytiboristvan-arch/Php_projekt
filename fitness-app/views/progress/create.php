<?php include 'views/layouts/header.php'; ?>
<div class="container">
    <div class="page-header">
        <h1>Új mérés rögzítése</h1>
        <a href="index.php?action=progress_list" class="btn btn-secondary">← Vissza</a>
    </div>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <ul><?php foreach ($errors as $error): ?><li><?php echo htmlspecialchars($error); ?></li><?php endforeach; ?></ul>
        </div>
    <?php endif; ?>
    <div class="card">
        <form method="POST" class="form">
            <div class="form-group">
                <label for="weight">Testsúly (kg) *</label>
                <input type="number" step="0.1" id="weight" name="weight" value="<?php echo $weight ?? ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="body_fat">Testzsír % (opcionális)</label>
                <input type="number" step="0.1" id="body_fat" name="body_fat" value="<?php echo $bodyFat ?? ''; ?>">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="chest">Mellkas (cm)</label>
                    <input type="number" step="0.1" id="chest" name="chest" value="<?php echo $chest ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label for="waist">Derék (cm)</label>
                    <input type="number" step="0.1" id="waist" name="waist" value="<?php echo $waist ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label for="hips">Csípő (cm)</label>
                    <input type="number" step="0.1" id="hips" name="hips" value="<?php echo $hips ?? ''; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="notes">Megjegyzések</label>
                <textarea id="notes" name="notes" rows="4"><?php echo htmlspecialchars($notes ?? ''); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Mentés</button>
        </form>
    </div>
</div>
<?php include 'views/layouts/footer.php'; ?>
