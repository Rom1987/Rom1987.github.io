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
    echo file_get_contents("css/tab_BD_PC.css");
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

  <form action="BD_PC.php" method="POST">
    <center>
      <?
//admin
if ( $_SESSION['user_nickname']=='admin' and  isset($_SESSION['user_password']) ){
  $link = mysqli_connect("localhost","root","","computer_shop"); ?>

      <p>Сортировка таблицы:</p>
      <select class='sort' name="age">
        <option disabled selected> <?= $_REQUEST['age'] != '' ? $_REQUEST['age'] : 'По умолчанию' ?> </option>
        <option value="ID">ID</option>
        <option value="PC_name">PC_name</option>
        <option value="Characteristic">Characteristic</option>
        <option value="IMG">IMG</option>
        <option value="Category">Category</option>
        <option value="Price">Price</option>
        <option value="Quantity">Quantity</option>
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
      mysqli_query($link, "DELETE FROM pc WHERE ID='$value';");
    }
  }

  // изменение
  if ( isset($_POST['change']) ) {
    foreach ($_POST['box'] as $value) {

      $PC_name_value = 'PC_name'.$value;
      $PC_name = $_POST[$PC_name_value];

      $Characteristic_value = 'Characteristic'.$value;
      $Characteristic = $_POST[$Characteristic_value];

      $IMG_value = 'IMG'.$value;
      $IMG = $_POST[$IMG_value];

      $Category_value = 'Category'.$value;
      $Category = $_POST[$Category_value];
      if ( $Category=='' ) {
        $sql_Category = "SELECT Category FROM `pc` WHERE ID='$value'";
        $Category_result = mysqli_query($link, $sql_Category);
        $Category = mysqli_fetch_assoc($Category_result)['Category'];
      }

      $Price_value = 'Price'.$value;
      $Price = $_POST[$Price_value];

      $Quantity_value = 'Quantity'.$value;
      $Quantity = $_POST[$Quantity_value];

      $update ="UPDATE `pc` SET PC_name='$PC_name', Characteristic='$Characteristic', IMG='$IMG', 
      Category='$Category', Price=$Price, Quantity=$Quantity WHERE ID='$value'";
      mysqli_query($link, $update);
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
    $sel="SELECT COUNT(*) FROM `pc`";
    $res_count = mysqli_query($link, $sel);
    $row = mysqli_fetch_row($res_count);
    $total = $row[0];
    $str_pag = ceil($total / $limit);
    $query = mysqli_query($link, "SELECT * FROM `pc` LIMIT $number, $limit");
  } 
  else if ( isset($_POST['but_order']) ) {
    $query = PC_sort('desc'); 
  }
  else if ( isset($_POST['but_order1']) ) {
    $query = PC_sort('asc');
  }

  ?>
      <div style='overflow-x: auto; margin-top: 15px;' class="col col-sm col-md col-lg col-xl mx-auto">
        <table class="col col-sm col-md col-lg col-xl mx-auto" border="0" width="99%">
          <tbody>
            <tr align="CENTER">
              <td>ID</td>
              <td>PC_name</td>
              <td>Characteristic</td>
              <td>IMG</td>
              <td>Category</td>
              <td>Price</td>
              <td>Quantity</td>
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
              <td><?= $article['ID'] ?></td>
              <td> <textarea class='textarea_PC_name' name="PC_name<?= $article['ID'] ?>" type="text"><?= $article['PC_name'] ?> </textarea> </td>
              <td> <textarea class='textarea_Characteristic' name="Characteristic<?= $article['ID'] ?>" type="text"><?= $article['Characteristic'] ?></textarea> </td>
              <td> <textarea class='textarea_IMG' name="IMG<?= $article['ID'] ?>" type="text"><?= $article['IMG'] ?></textarea> </td>
              <td>
                <select class='Category' name="Category<?= $article['ID'] ?>">
                  <option value="<?= $article['Category'] ?>" disabled selected> <?= $article['Category'] ?> </option>
                  <option value="Игровой"> Игровой </option>
                  <option value="Средний"> Средний </option>
                  <option value="Бюджетный"> Бюджетный </option>
                </select>
              </td>
              <td> <input class='textarea_Price' name="Price<?= $article['ID'] ?>" type="number" value="<?= $article['Price'] ?>" /> </td>
              <td> <input class='textarea_Quantity' name="Quantity<?= $article['ID'] ?>" type="number" value="<?= $article['Quantity'] ?>" /> </td>
              <td><input type="checkbox" class="checkbox" name="box[]" value="<?= $article['ID'] ?>" /></td>
            </tr>
          </tbody>
        </table>
        <? } ?>

        <button name='button' value='button'>Удалить</button> <br>
        <button name='change' value='change'>Изменить</button> <br>
        <a class="link" href="PC_registration.php"> Регистрация ПК </a> <br>

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