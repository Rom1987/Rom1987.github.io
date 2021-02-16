<div class='block'>
  <?php
  if (isset($_POST['exit'])) {

    session_unset();
  }
  if (isset($_POST['unpack'])) {

    $errors = array();

    if (empty($_POST['name1'])) {

      $errors[] = 'Введите никнейм!';
    } else {

      $name1 = $_POST['name1'];
      $query = "SELECT * FROM accounts WHERE Nickname='$name1'";
      $result = mysqli_query($link, $query);
      $user = mysqli_fetch_assoc($result);

      if (!empty($user)) {

        $hash_password = $user['Password']; // соленой пароль из БД

      }
    }

    if (empty($_POST['password1'])) {

      $errors[] = 'Введите пароль!';
    } else if (!password_verify($_POST['password1'], $hash_password) or empty($user)) {

      $errors[] = 'Неверно введено имя или пароль!';
    }

    if (empty($errors)) {

      if ($_POST['name1'] == 'admin') { ?>

        <div class="complete"> Добро пожаловать босс </div>
      <?php

      } else { ?>

        <div class="complete"> Вы прошли авторизацию </div>
      <?php

      }
      $_SESSION['user_nickname'] = $name1;
      $_SESSION['user_password'] = $hash_password;
    } else {

      include('authorization.html'); // подключение формы для авторизации 
      ?>
      <div class="error">
        <b>
          <? echo (array_shift($errors)) ?>
        </b>
      </div>

    <?php }
  } else if ($_SESSION['user_nickname'] == 'admin' and isset($_SESSION['user_password'])) { ?>

    <div class="complete"> Добро пожаловать босс </div>
    <?

} else if ( isset($_SESSION['user_nickname']) and $_SESSION['user_nickname']!='admin'
  and isset($_SESSION['user_password'])) { ?>

    <div class="complete"> Вы прошли авторизацию </div>
    <?

} else {

  include ('authorization.html'); // подключение формы для авторизации

} 
if( isset($_SESSION['user_nickname']) and isset($_SESSION['user_password']) ) { ?>
    <form action="" method="POST">
      <center>
        <div> <button type='submit' class="link" name="exit"> Выход </button></div>
      </center>
    </form> <?php

          } ?>
</div>
<!--Конец div class=block-->