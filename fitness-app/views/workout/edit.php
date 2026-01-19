<?php include 'views/layouts/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>Edzés szerkesztése</h1>
        <a href="index.php?action=workout_list" class="btn btn-secondary">← Vissza</a>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card">
        <form method="POST" class="form">
            <div class="form-group">
                <label for="title">Edzés címe *</label>
                <input type="text" id="title" name="title" 
                       value="<?php echo htmlspecialchars($workout['title']); ?>" required>
            </div>

            <div class="form-group">
                <label for="type">Típus *</label>
                <select id="type" name="type" required>
                    <option value="Kardió" <?php echo $workout['type'] === 'Kardió' ? 'selected' : ''; ?>>Kardió</option>
                    <option value="Erőnléti" <?php echo $workout['type'] === 'Erőnléti' ? 'selected' : ''; ?>>Erőnléti</option>
                    <option value="Yoga" <?php echo $workout['type'] === 'Yoga' ? 'selected' : ''; ?>>Yoga</option>
                    <option value="Crossfit" <?php echo $workout['type'] === 'Crossfit' ? 'selected' : ''; ?>>Crossfit</option>
                    <option value="Futás" <?php echo $workout['type'] === 'Futás' ? 'selected' : ''; ?>>Futás</option>
                    <option value="Úszás" <?php echo $workout['type'] === 'Úszás' ? 'selected' : ''; ?>>Úszás</option>
                    <option value="Kerékpár" <?php echo $workout['type'] === 'Kerékpár' ? 'selected' : ''; ?>>Kerékpár</option>
                    <option value="Egyéb" <?php echo $workout['type'] === 'Egyéb' ? 'selected' : ''; ?>>Egyéb</option>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="duration">Időtartam (perc) *</label>
                    <input type="number" id="duration" name="duration" 
                           value="<?php echo $workout['duration']; ?>" min="1" required>
                </div>

                <div class="form-group">
                    <label for="calories">Elégetett kalória *</label>
                    <input type="number" id="calories" name="calories" 
                           value="<?php echo $workout['calories_burned']; ?>" min="0" required>
                </div>
            </div>

            <div class="form-group">
                <label for="notes">Megjegyzések</label>
                <textarea id="notes" name="notes" rows="4"><?php echo htmlspecialchars($workout['notes']); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Mentés</button>
        </form>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
