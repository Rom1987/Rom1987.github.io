<?php
session_start();
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
    echo file_get_contents("css/tab.css");
    ?>
  </style>
</head>

<body>
  <?php
  // меню
  include('menu.php');
  // шапка
  include('header.php');
  // функция сортировки
  include('func_sort.php');
  ?>
  <form action="BD_users.php" method="POST">
    <center>
      <?
if ( $_SESSION['user_nickname']=='admin' and  isset($_SESSION['user_password']) ) {

  $link = mysqli_connect("localhost","root","","computer_shop"); ?>
      <p>Сортировка таблицы:</p>
      <select class='sort' name="age">
        <option disabled selected> <?= $_REQUEST['age'] != '' ? $_REQUEST['age'] : 'По умолчанию' ?> </option>
        <option value="ID">ID</option>
        <option value="L_F_S">L_F_S</option>
        <option value="Address">Address</option>
        <option value="Date_of_Birth">Date_of_Birth</option>
        <option value="Phone">Phone</option>
        <option value="User_code">User_code</option>
      </select>
      <br>
      <button type="submit" name="but_order" value="Сортировать">Сортировать по убыванию</button>
      <br>
      <button type="submit" name="but_order1" value="Сортировать">Сортировать по возрастанию</button>
      <?
  // выбор checkbox
  if ( !empty($_POST['button']) ){
    // $value это все значения user_code (код пользователя)
    foreach ($_POST['box'] as $value) {
      mysqli_query($link, "DELETE FROM orders WHERE User_code='$value';");
      mysqli_query($link, "DELETE FROM Accounts WHERE ID='$value';");
      mysqli_query($link, "DELETE FROM Users WHERE ID='$value';");
    }
    echo mysqli_error($link);
  }

  
  // сортировка
  if ( $_REQUEST['age']=='' ) {
    // постраничный вывод
    if ( isset($_GET['page']) ) {
      $page = $_GET['page'];
    } else {
      $page = 1;
    }
    $limit = 10; //количество строк на одной странице
    $number = ($page * $limit) - $limit;
    $sel="SELECT COUNT(*) FROM `users`";
    $res_count = mysqli_query($link, $sel);
    $row = mysqli_fetch_row($res_count);
    $total = $row[0];
    $str_pag = ceil($total / $limit);
    $query = mysqli_query($link, "SELECT * FROM `users` LIMIT $number, $limit");
  } 
  else if ( isset($_POST['but_order']) ) {
    $query = user_sort('desc'); 
  }
  else if ( isset($_POST['but_order1']) ) {
    $query = user_sort('asc');
  }
    ?>
      <div style="margin-top: 15px;" class="col col-sm col-md col-lg col-xl mx-auto">
        <table class="col col-sm col-md col-lg col-xl mx-auto" border="0" width="99%">
          <tbody>
            <tr style='background-color: transparent;' align="CENTER">
              <td>ID</td>
              <td>L_F_S</td>
              <td>Address</td>
              <td>Date_of_Birth</td>
              <td>Phone</td>
              <td>User_code</td>
              <td>
                <!--<input type="checkbox" name="ID"/>-->
              </td>
            </tr>
          </tbody>
        </table>
        <? 
    while( $article = mysqli_fetch_assoc($query) ) {
      ?>
        <table class="hov col col-sm col-md col-lg col-xl mx-auto" style='background-color: transparent;' border="0" width="99%">
          <tbody>
            <tr style='background-color: transparent;' align="CENTER">
              <td><?= $article['ID'] ?></td>
              <td><?= $article['L_F_S'] ?></td>
              <td><?= $article['Address'] ?></td>
              <td><?= $article['Date_of_Birth'] ?></td>
              <td><?= $article['Phone'] ?></td>
              <td><?= $article['User_code'] ?></td>
              <td><input type="checkbox" class="checkbox" name="box[]" value="<?= $article['User_code'] ?>" /></td>
            </tr>
          </tbody>
        </table>
        <?}?>

        <button name='button' value='button'>Удалить</button>
        <br>
        <? for ($i = 1; $i <=$str_pag; $i++) {?>
        <div class='kvasov-link' style="display: inline;">
          <? echo "<a class='link' href=?page=".$i.">".$i."</a>"; ?>
        </div>
        <?}?>
      </div> <!-- end marg -->
      <?    mysqli_close($link);       
    } ?>

    </center>
  </form>
</body>

</html>