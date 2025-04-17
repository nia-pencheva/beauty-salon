<header>
    <div class="header-container">
        <div class="nav-menu">
            <a href="#">Услуги</a>
            <a href="#">За нас</a>
            <?php if ($is_logged_in): ?>
                <a href="profile.php">Профил</a>
                <a href="logout.php">Изход</a>
            <?php else: ?>
                <a href="profile.php">Профил</a>
                <a href="login.php">Вход</a>
            <?php endif; ?>
        </div>
    </div>
</header>