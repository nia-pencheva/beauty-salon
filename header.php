<header>
    <div class="header-container">
        <button class="hamburger-menu" aria-label="Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <div class="nav-menu">
            <div class="nav-menu__section">
                <a href="cosmetic_services.php">Услуги</a>
                <a href="aboutUs.php">За нас</a>
            </div>
           

            <div class="nav-menu__section">
                <?php if ($is_logged_in): ?>
                    <a href="profile.php">Профил</a>
                    <a href="logout.php">Изход</a>
                <?php else: ?>
                    <a href="profile.php">Профил</a>
                    <a href="login.php">Вход</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<script src="js/header.js"></script>