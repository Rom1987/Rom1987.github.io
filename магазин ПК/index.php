<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
  <title>ПКаптер - компьютерный интернет-магазин. Продажа компьютеров и комплектующих с быстрой и бесплатной доставкой</title>
  <meta charset="utf-8">
  <meta name="keywords" content="слабый пк, компьютер, i7, core i3, intel core i5,
    сайт компьютеров, ноутбук, мышка, клавиатура, купить компьютер, системный блок,
    материнская плата, мощный компьютер, купить системный блок, красивые системные блоки, игровые пк, 
    бюджетные пк, настольный компьютер, комплектующие, средние пк">
  <meta name="description" content="Интернет-магазин компьютеров ПКаптер предлагает купить красивый недорогой компьютер
    с быстрой качественной бесплатной доставкой в Москве с топовыми характеристиками и с наклейками в подарок. 
    Лучшая сборка системных блоков для игр.">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="generator" content="HTML5, CSS3, ECMAScript 8, PHP 8, Bootstrap 4.5.3" />
  <link rel="stylesheet" href="bootstrap-4.5.3-dist/css/bootstrap.min.css">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <style>
    <?php
    echo file_get_contents("css/style.css");
    echo file_get_contents("css/test_block_style.css");
    ?>
  </style>
</head>

<body>

  <?php
  $link = mysqli_connect("localhost", "root", "", "computer_shop");
  mysqli_query($link, "SET NAMES 'utf-8'");
  // шапка
  include('header.php'); ?>
  <div class="sidebar">
    <?
  // Меню
  include('menu.php'); 
  ?>

    <!-- Категория ПК -->
    <form action="index.php" method="GET">
      <div class="block_category">
        <button class="category" name="default"> По умолчанию </button>
        <br>
        <button class="category" name="game"> Игровые </button>
        <br>
        <button class="category" name="middle"> Средние </button>
        <br>
        <button class="category" name="budgetary"> Бюджетные </button>
      </div>
    </form>
  </div> <!-- end sidebar -->

  <div class="content">
    <!-- Окошки с ПК -->

    <!-- Объекты из таблицы 'pc' -->
    <div class="post-wrap">
      <?
    if ( isset($_GET['game']) ) {
      $sql_PC = "SELECT * FROM `pc` WHERE  Category='Игровой'";
      $result_select = mysqli_query($link, $sql_PC);
      include('block_pc.php');
    } 
    else if ( isset($_GET['middle']) ) {
      $sql_PC = "SELECT * FROM `pc` WHERE Category='Средний'";
      $result_select = mysqli_query($link, $sql_PC);
      include('block_pc.php');
    }
    else if ( isset($_GET['budgetary']) ) {
      $sql_PC = "SELECT * FROM `pc` WHERE Category='Бюджетный'";
      $result_select = mysqli_query($link, $sql_PC);
      include('block_pc.php');
    }
    else if ( isset($_GET['default']) ) {
      $sql_PC = "SELECT * FROM `pc`";
      $result_select = mysqli_query($link, $sql_PC);
      include('block_pc.php');
      }
    else if ( isset($_GET['button_search']) ) {
      $search = $_GET['search'];
      $sql_PC = "SELECT * FROM `pc` WHERE `PC_name` Like '%$search%'";
      $result_select = mysqli_query($link, $sql_PC);
      include('block_pc.php');
    }
    else {
      $sql_PC = "SELECT * FROM `pc`";
      $result_select = mysqli_query($link, $sql_PC);
      include('block_pc.php');
    }
  ?>
      <center>
        <?
  for ($i = 1; $i <=$str_pag; $i++) { ?>
        <div class='kvasov-link' style="display: inline;">
          <? echo "<a class='link' href=?page=".$i.">".$i."</a>"; ?>
        </div>
        <?
  }?>
      </center>
    </div> <!-- end post-wrap -->

    <?
  mysqli_close($link);
  ?>

  </div>
  <!--end content-->

</body>

</html>