<header>
    <h1>
        <a class="main_title" href="../index.php">Новости дня</a> 
    </h1>
    <div class="block_login">
        <?php if(isset($_SESSION['logged_user'])) { ?>
        Вы вошли как, <?php echo $_SESSION['logged_user']['login']; ?>! 
        <a href="/pages/logout.php" class="logout">Выйти</a>
        <?php }else { ?>
        <a href="/pages/login.php" class="login">Войти</a>
        <a href="/pages/signup.php" class="signup">Регистрация</a>
        <?php 
        } 
        ?>
    </div>
<!-- Navigation menu header -->
    <nav class="navigation_menu_header">
        <a class="navigation_all_news" href='../index.php'>Все новости</a>
        <a class="navigation_world" href='/pages/world.php'>В Мире</a>
        <a class="navigation_Russia" href='/pages/russia.php'>В Росии</a>
        <a class="navigation_town" href='/pages/novosibirsk.php'>В Новосибирске</a>

        <?php 
        if($_SESSION['logged_user']['login'] == 'admin') {
            echo "<a class=\"navigation_admin\" href='/pages/admin.php'>Админка</a>";
        }
        ?>
    </nav>
</header>