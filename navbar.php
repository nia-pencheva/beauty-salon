<div class="navbar">
    <div>
        <a href="">Услуги</a>
        <a href="">За Нас</a>
    </div>

    <div>
    <?php 
    if(isset($_SESSION['id'])) {
        echo '
                <a href="">Профил</a>
                <a href="logout.php">Изход</a>
            ';
    } else {
        echo '
                <a href="login.php">Вход</a>
                <a href="register.php">Регистрация</a>
            ';
    }
    ?>
    </div>
</div>