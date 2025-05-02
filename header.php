<header>
    <div class="header-container">
        <button class="hamburger-menu" aria-label="Menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <div class="nav-menu">
            <div class="nav-menu__section">
                <a href="index.php">
                    <img style="height: 50px;" src="images/logo.png" alt="Logo" class="logo">
                </a>
            </div>

            <div class="nav-menu__section">
                <a class="nav-menu__link" href="index.php">Услуги</a>
                <a class="nav-menu__link" href="aboutUs.php">За нас</a>
            </div>

            <div class="nav-menu__section">
                <?php if ($is_logged_in): ?>
                    <a class="nav-menu__link" href="profile.php">Профил</a>
                    <a class="nav-menu__link" href="logout.php">Изход</a>
                <?php else: ?>
                    <a class="nav-menu__link" href="profile.php">Профил</a>
                    <a class="nav-menu__link" href="login.php">Вход</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<script src="js/header.js"></script>