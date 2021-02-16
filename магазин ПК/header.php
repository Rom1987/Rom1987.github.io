<div class="header">
    <form action="index.php" method="GET">
        <center>
            <div class='search_block'>
                <input class="search" name='search' placeholder="Поиск" value="<?= $_GET['search'] ?>" type="search">
                <button class="button_search" name="button_search"> Поиск </button>
            </div>
        </center>
    </form>
    <!-- end поиск -->
    <?
        if ( basename($_SERVER['SCRIPT_NAME']) != 'registration.php' ) {
           // Авторизация
           include('authorization.php');
        }
        ?>
    <a href="index.php"> <img class='header-img' src="jpg/test596505.jpg" alt=""> </a>
</div>