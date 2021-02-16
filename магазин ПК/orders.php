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
    echo file_get_contents("css/tab_orders.css");
    ?>
  </style>
</head>

<body>
  <!-- Выпадающий список -->
  <?php
  include('menu.php');
  // шапка
  include('header.php');
  include('func_sort.php');
  ?>
  <!-- end Выпадающий список -->

  <form action="orders.php" method="POST">
    <center>
      <?
//admin
if ( $_SESSION['user_nickname']=='admin' and  isset($_SESSION['user_password']) ){
  $link = mysqli_connect("localhost","root","","computer_shop"); ?>

      <p>Сортировка таблицы:</p>
      <select class='sort' name="age">
        <option disabled selected> <?= $_REQUEST['age'] != '' ? $_REQUEST['age'] : 'По умолчанию' ?> </option>
        <option value="ID">ID</option>
        <option value="PC_code">PC_code</option>
        <option value="User_code">User_code</option>
        <option value="Delivery_date">Delivery_date</option>
        <option value="Purchase_date">Purchase_date</option>
      </select>
      <br>
      <button type="submit" name="but_order" value="Сортировать">Сортировать по убыванию</button>
      <br>
      <button type="submit" name="but_order1" value="Сортировать">Сортировать по возрастанию</button>
      <?

     // удаление
  if ( isset($_POST['button']) ){
    // $value это все значения user_code (код пользователя)
    foreach ($_POST['box'] as $value) {
      mysqli_query($link, "DELETE FROM orders WHERE ID='$value';");
    }
  }

  // сортировка
  if ( $_REQUEST['age']=='' ) {
    // постраничный вывод
    if (isset($_GET['page'])){
      $page = $_GET['page'];
    } else {
      $page = 1;
    }
    $limit = 10; //количество строк на одной странице
    $number = ($page * $limit) - $limit;
    $sel="SELECT COUNT(*) FROM `orders`";
    $res_count = mysqli_query($link, $sel);
    $row = mysqli_fetch_row($res_count);
    $total = $row[0];
    $str_pag = ceil($total / $limit);
    $query = mysqli_query($link, "SELECT * FROM `orders` LIMIT $number, $limit");
  } 
  else if ( isset($_POST['but_order']) ) {
    $query = orders_sort('desc'); 
  }
  else if ( isset($_POST['but_order1']) ) {
    $query = orders_sort('asc');
  }

  ?>
      <div style='overflow-x: auto; margin-top: 15px;' class="col col-sm col-md col-lg col-xl mx-auto">
        <table class="col col-sm col-md col-lg col-xl mx-auto" border="0" width="99%">
          <tbody>
            <tr align="CENTER">
              <td>ID</td>
              <td>PC_code</td>
              <td>User_code</td>
              <td>Delivery_date</td>
              <td>Purchase_date</td>
              <td>
                <!--<input type="checkbox" name="ID"/>-->
              </td>
            </tr>
          </tbody>
        </table>

        <? 
  while( $article = mysqli_fetch_assoc($query) ) {
    ?>
        <table class="hov col col-sm col-md col-lg col-xl mx-auto" border="0" width="99%">
          <tbody>
            <tr align="CENTER">
              <td> <?= $article['ID'] ?> </td>
              <td> <?= $article['PC_code'] ?> </td>
              <td> <?= $article['User_code'] ?> </td>
              <td> <?= $article['Delivery_date'] ?> </td>
              <td> <?= $article['Purchase_date'] ?> </td>
              <td><input type="checkbox" class="checkbox" name="box[]" value="<?= $article['ID'] ?>" /></td>
            </tr>
          </tbody>
        </table>
        <? } ?>

        <button name='button' value='button'>Удалить</button> <br>

        <? for ($i = 1; $i <=$str_pag; $i++){?>
        <div class='kvasov-link' style="display: inline;">
          <? echo "<a class='link' href=?page=".$i.">".$i."</a>"; ?>
        </div>
        <?}
      mysqli_close($link);
    } ?>
      </div> <!-- end marg -->
    </center>
  </form>
</body>

</html>