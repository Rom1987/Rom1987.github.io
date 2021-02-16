<?php
session_start();
if (isset($_POST['exit'])) {
  session_unset();
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="bootstrap-4.5.3-dist/css/bootstrap.min.css">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <style>
    <?php
    echo file_get_contents("css/style.css");
    echo file_get_contents("css/registration.css");
    ?>
  </style>
</head>

<body>

  <!-- Выпадающий список -->
  <?php
  include('menu.php');
  // шапка
  include('header.php');
  ?>
  <!-- end Выпадающий список -->
  <center>
    <div class='block_registration'>

      <?
$link = mysqli_connect("localhost","root","","computer_shop");
mysqli_query($link, "SET NAMES 'utf-8'");

if (!$link) {
  die("Connection failed: " . mysqli_connect_error());
}
  
/*Регистрация*/
$PC_name = $_POST['PC_name'];
$Characteristic =$_POST['Characteristic'];
$Category = $_POST['Category'];
$IMG = $_POST['IMG'];
$Price = $_POST['Price'];
$Quantity = $_POST['Quantity'];

// проверка на наличие ошибок
if( isset($_POST['registration_button']) ) {
  $errors = array();

  if( empty($_POST['PC_name']) ) { 
    $errors[] = 'Введите имя ПК!';
  }

  if( empty($_POST['Characteristic']) ) { 
    $errors[] = 'Введите характеристику!';
  }
  
  if( empty($_POST['Category']) ) { 
    $errors[] = 'Введите категория!';
  }

  if( empty($_POST['IMG']) ) { 
    $errors[] = 'Введите адрес картинки!';
  }

  if( empty($_POST['Price']) ) {
    $errors[] = 'Введите цену!';
  }

  if( empty($_POST['Quantity']) ) { 
    $errors[] = 'Введите количество!';
  }

  // если нет ошибок то регистрируем
  if ( empty($errors) ) {
    $sql ="INSERT INTO pc (PC_name, Characteristic, Category, IMG, Price, Quantity)
    VALUES ('$PC_name', '$Characteristic', '$Category', '$IMG', '$Price', '$Quantity')";
    mysqli_query($link, $sql);

    ?>
      <div style="display:inline-block; color:lime;">
        Вы зарегистрировали ПК
      </div>
      <? 
  mysqli_close($link);
  }
  else { ?>
      <!-- array_shift() - извлекает первый элемент массива. -->
      <div style="color: red;">
        <? echo (array_shift($errors)) ?>
      </div> <br>
      <? }
}

// Форма регистрации ПК
include ('PC_form_registration.php');

if( password_verify($_POST['password1'], $hashadmin) or password_verify($_POST['password1'], $hash) ) {?>
      <div> <a class="link" href="?exit">Выход</a> </div>
      <?}?>


      <div>
        <a class="link" href="BD_PC.php"> Таблица компьютеров </a> <br>
      </div>
    </div> <!-- end block_registration -->
  </center>
</body>

</html>