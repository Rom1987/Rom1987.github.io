<?php
session_start();
if (isset($_POST['exit'])) {
  session_unset();
}
?>
<!DOCTYPE html>

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
  <center>
    <!-- Меню -->
    <?php
    include('menu.php');
    // шапка
    include('header.php'); ?>

    <div class='block_registration'>

      <?
$link = mysqli_connect("localhost","root","","computer_shop");
mysqli_query($link, "SET NAMES 'utf-8'");

if (!$link) {
  die("Connection failed: " . mysqli_connect_error());
}
  
/*Регистрация*/
$user_nickname = $_POST['user_nickname'];
$user_password = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
$user_lname = $_POST['user_lname'];
$user_fname = $_POST['user_fname'];
$user_sname = $_POST['user_sname'];
$user_address = $_POST['user_address'];
$user_date = $_POST['user_date'];
$user_phone = $_POST['user_phone'];

// проверка на наличие ошибок
if( isset($_POST['registration_button']) ) {
  $errors = array();

  if( empty($_POST['user_nickname']) ) { 
    $errors[] = 'Введите никнейм!';
  }
  else {
    // подключение БД
    $query=mysqli_query($link, "SELECT * FROM accounts WHERE Nickname='$user_nickname'");
    $mass=mysqli_fetch_assoc($query);
    if ($mass['Nickname']==$_POST['user_nickname']){
      $errors[] = 'Пользователь с таким никнейном существует!';
    }
  }

  if( empty($_POST['user_password']) ) { 
    $errors[] = 'Введите пароль!';
  }
  
  if( empty($_POST['user_password_again']) ) { 
    $errors[] = 'Введите повторный пароль!';
  }

  if ( $_POST['user_password']!=$_POST['user_password_again'] ) {
    $errors[]='Не правильно потверждён пароль!';
  }

  if( empty($_POST['user_lname']) ) { 
    $errors[] = 'Введите фамилию!';
  }

  if( empty($_POST['user_fname']) ) { 
    $errors[] = 'Введите имя!';
  }

  if( empty($_POST['user_sname']) ) { 
    $errors[] = 'Введите отчество!';
  }

  if( empty($_POST['user_address']) ) { 
    $errors[] = 'Введите адрес проживания!';
  }

  if( empty($_POST['user_date']) ) {
    $errors[] = 'Введите дату рождения!';
  }

  if( empty($_POST['user_phone']) ) {
    $errors[] = 'Введите номер телефона!';
  }

  if ( (strlen($_POST['user_phone'])<11 or strlen($_POST['user_phone'])>11) and strlen($_POST['user_phone'])!=0 ) {
    $errors[] = 'Номер телефона должен состоять из 11 цифр';
  }

  // если нет ошибок то регистрируем
  if ( empty($errors) ) {
    $L_F_S = $user_lname.' '.$user_fname.' '.$user_sname;
    $sql ="INSERT INTO accounts (Nickname, Password) VALUES ('$user_nickname', '$user_password')";
    mysqli_query($link, $sql);

    $query = mysqli_query($link, "SELECT ID FROM accounts ORDER BY ID DESC LIMIT 1");
    $count_str_BD = (int)mysqli_fetch_row($query)[0]; // код пользователя

    $sql = "INSERT INTO users (L_F_S, Address, Date_of_Birth, Phone, User_code) VALUES ('$L_F_S',
    '$user_address', '$user_date', '$user_phone', $count_str_BD)";
    mysqli_query($link, $sql);

    $_SESSION['user_nickname']=$user_nickname;
    $_SESSION['user_password']=$user_password;
    ?>
      <div class="col col-sm col-md col-lg col-xl mx-auto" style="color: lime; display:inline-block;">
        <h3>Вы прошли регистрацию</h3>
      </div>
      <? 
  mysqli_close($link);
  }
  else { 
    include ('form_registration.php'); // подключение формы для регистрации
    ?>
      <!-- array_shift() - извлекает первый элемент массива. -->
      <div class="error">
        <? echo (array_shift($errors)) ?>
      </div>
      <? }
}
else {
  include ('form_registration.php'); // подключение формы для регистрации
}

if( password_verify($_POST['password1'], $hashadmin) or password_verify($_POST['password1'], $hash) or 
isset($_SESSION['user_nickname']) or isset($_SESSION['user_password']) ) {?>
      <div> <a class="link" href="?exit">Выход</a> </div>
      <?}?>

    </div> <!-- end block_registration -->
  </center>
</body>

</html>