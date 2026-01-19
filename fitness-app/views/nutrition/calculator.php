<?php include 'views/layouts/header.php'; ?>
<div class="container">
    <div class="page-header">
        <h1>Kalória kalkulátor</h1>
        <a href="index.php?action=nutrition_list" class="btn btn-secondary">← Vissza</a>
    </div>
    <div class="card">
        <h2>Napi kalória szükséglet számítása</h2>
        <form method="POST" class="form">
            <div class="form-row">
                <div class="form-group">
                    <label for="weight">Testsúly (kg) *</label>
                    <input type="number" step="0.1" id="weight" name="weight" required>
                </div>
                <div class="form-group">
                    <label for="height">Magasság (cm) *</label>
                    <input type="number" id="height" name="height" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="age">Életkor *</label>
                    <input type="number" id="age" name="age" required>
                </div>
                <div class="form-group">
                    <label for="gender">Nem *</label>
                    <select id="gender" name="gender" required>
                        <option value="male">Férfi</option>
                        <option value="female">Nő</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="activity">Aktivitási szint *</label>
                <select id="activity" name="activity" required>
                    <option value="1.2">Ülő életmód (kevés vagy nincs sport)</option>
                    <option value="1.375">Enyhe aktivitás (sport 1-3 nap/hét)</option>
                    <option value="1.55">Mérsékelt aktivitás (sport 3-5 nap/hét)</option>
                    <option value="1.725">Aktív (sport 6-7 nap/hét)</option>
                    <option value="1.9">Nagyon aktív (nehéz edzés naponta)</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Számítás</button>
        </form>
        <?php if ($result): ?>
        <div class="calculator-results">
            <h3>Eredmények</h3>
            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-label">BMR (alapanyagcsere)</span>
                    <span class="stat-value"><?php echo $result['bmr']; ?> kcal/nap</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">TDEE (napi kalória szükséglet)</span>
                    <span class="stat-value"><?php echo $result['tdee']; ?> kcal/nap</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Fogyáshoz</span>
                    <span class="stat-value"><?php echo $result['lose']; ?> kcal/nap</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Hízáshoz</span>
                    <span class="stat-value"><?php echo $result['gain']; ?> kcal/nap</span>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php include 'views/layouts/footer.php'; ?>
