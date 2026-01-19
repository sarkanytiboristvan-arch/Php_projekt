<?php include 'views/layouts/header.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <h1>Bejelentkezés</h1>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" class="auth-form">
            <div class="form-group">
                <label for="email">Email cím</label>
                <input type="email" id="email" name="email" 
                       value="<?php echo htmlspecialchars($rememberedEmail); ?>" 
                       required>
            </div>

            <div class="form-group">
                <label for="password">Jelszó</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="remember" value="1">
                    Emlékezz rám
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Belépés</button>
        </form>

        <p class="auth-footer">
            Még nincs fiókod? <a href="index.php?action=register">Regisztrálj itt!</a>
        </p>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
