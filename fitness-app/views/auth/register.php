<?php include 'views/layouts/header.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <h1>Regisztráció</h1>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" class="auth-form">
            <div class="form-group">
                <label for="name">Teljes név</label>
                <input type="text" id="name" name="name" 
                       value="<?php echo htmlspecialchars($name ?? ''); ?>" 
                       required>
            </div>

            <div class="form-group">
                <label for="email">Email cím</label>
                <input type="email" id="email" name="email" 
                       value="<?php echo htmlspecialchars($email ?? ''); ?>" 
                       required>
            </div>

            <div class="form-group">
                <label for="password">Jelszó (min. 6 karakter)</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="confirm_password">Jelszó megerősítése</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Regisztráció</button>
        </form>

        <p class="auth-footer">
            Már van fiókod? <a href="index.php?action=login">Jelentkezz be itt!</a>
        </p>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>
