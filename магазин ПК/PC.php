<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="bootstrap-4.5.3-dist/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PC</title>
    <style>
        <?php
        echo file_get_contents("css/style.css");
        echo file_get_contents("css/test_block_style.css");
        echo file_get_contents("css/img_in_PC.css");
        ?>
    </style>
</head>

<body>

    <?php
    $link = mysqli_connect("localhost", "root", "", "computer_shop");
    mysqli_query($link, "SET NAMES 'utf-8'");

    // шапка
    include('header.php');
    include('menu.php');
    ?>

    <div class='content'>

        <?
    $ID = $_GET['page']; // id ПК

    $sql_PC = "SELECT * FROM `pc` WHERE ID='$ID'";
    $result_PC = mysqli_query($link, $sql_PC);
    $object = mysqli_fetch_object($result_PC);

    // Берём определённый текст для оперделённого заголовка
    preg_match('/Процессор (.*) Оперативная/', $object->Characteristic, $CPU);
    preg_match('/ Оперативная память (.*) Графический адаптер/', $object->Characteristic, $RAM);
    preg_match('/ Графический адаптер (.*) Хранение информации/', $object->Characteristic, $Graphics_adapter);
    preg_match('/ Хранение информации (.*) Коммуникации/', $object->Characteristic, $Data_storage);
    preg_match('/ Коммуникации (.*) Программное обеспечение/', $object->Characteristic, $Communications);
    preg_match('/ Программное обеспечение (.*) Разъемы/', $object->Characteristic, $Software);
    preg_match('/ Разъемы (.*) Корпус/', $object->Characteristic, $Connectors);
    preg_match('/ Корпус (.*) Дополнительно/', $object->Characteristic, $Housing);
    preg_match('/ Дополнительно (.*)/', $object->Characteristic, $Additionally);
    ?>


        <center>

            <!-- Отправление сообщение о покупки на почту -->

            <?
        // session нужна, чтобы работал input и button
        // (а то при нажатии кнопки не видит передаваемые значения и саму кнопку)

        //  если нажата кнопка 'купить'
        if (isset($_GET['buy']) or !empty($_SESSION['buy'])) {
        if (isset($_SESSION['user_nickname']) and isset($_SESSION['user_password'])) { ?>
            <form action="PC.php?page=<?= $ID ?>" method='POST'>
                <div class='pop-up_window'>
                    <p> Введите свой email :) </p>
                    <input type='email' name='to_email' placeholder='email'>
                    <button type='submit' name='email_button'> Потвердить покупку</button>
            </form>
    </div>
    <?
$_SESSION['buy'] = $_GET['buy'];
?>

    <?
if ( isset($_POST['email_button']) ) {

if ( empty($_POST['to_email']) ) { ?>
    <div class="error_password"> Введите email!</div>
    <? } else {
// выполнение заказа

$user_nickname = $_SESSION['user_nickname'];
$user_password = $_SESSION['user_password'];

$sql_accounts = "SELECT ID FROM `accounts` WHERE Nickname='$user_nickname' and Password='$user_password'";
$ID_user_result = mysqli_query($link, $sql_accounts);
$ID_user = mysqli_fetch_assoc($ID_user_result)['ID'];

$Purchase_date = date("Y-m-d");

$Delivery_date = new DateTime();
$Delivery_date->modify("+7 days");
$Delivery_date = $Delivery_date->format("Y-m-d");

$sql = "INSERT INTO orders (PC_code, User_code, Purchase_date, Delivery_date) 
                VALUES ($ID, $ID_user, '$Purchase_date', '$Delivery_date')";

// уменьшаем количество товара
$sql_Quantity = "SELECT Quantity FROM `pc` WHERE ID='$ID'";
$Quantity_result = mysqli_query($link, $sql_Quantity);
$Quantity = mysqli_fetch_assoc($Quantity_result)['Quantity'] - 1;
$buy = "UPDATE `pc` SET Quantity = $Quantity WHERE ID='$ID'";

if ( mysqli_query($link, $sql) and mysqli_query($link, $buy)) {

$message = "Куплен товар: $object->PC_name\r\nНа сумму: $object->Price\r\nСпасибо за покупку!";
$to = $_POST['to_email'];
$from = "test@gmail.com";
$subject = "Совершена покупка на сайте ПКаптер";
$subject = "=?utf-8?B?" . base64_encode($subject) . "?=";
$headers = "From: $from\r\nReply-to: $from\r\nContent-type: text/plain; charset=utf-8\r\n";
mail($to, $subject, $message, $headers);
$_SESSION['buy'] = ''; // удаляем session для покупки
?>
    <div style='color: lime;'> Спасибо за покупку :)</div>
    <?

} else { ?>
    <div style='color: red;'> <?= 'Error: ' . mysqli_error($link) ?> </div>
    <?
}
}

}

} else { ?>
    <div style="color: red;"> Авторизуйтесь!</div>
    <?
}
} ?>

    <!-- Характеристики ПК -->
    <h1>
        <? echo $object->PC_name ?>
    </h1>
    <div class="post-item">
        <div class="post-item-wrap">
            <img class='block_pc_img' src="<?= $object->IMG ?>">
            <div class="post-info">
                <div class="post-meta">
                    <div class="post-date"> <?= $object->Price ?> руб</div>
                    <div class="post-cat"> <?= $object->Category ?> </div>
                </div> <!-- end post-meta -->
            </div> <!-- end post-info -->
        </div> <!-- end post-item-wrap -->
    </div> <!-- end post-item -->

    <h2>Характеристики</h2>
    </center>

    <div class='PC'>

        <h3> Процессор </h3>
        <p>
            <? echo $CPU[1] ?>
        </p>

        <h3> Оперативная память </h3>
        <p>
            <? echo $RAM[1] ?>
        </p>

        <h3> Графический адаптер </h3>
        <p>
            <? echo $Graphics_adapter[1] ?>
        </p>

        <h3> Хранение информации </h3>
        <p>
            <? echo $Data_storage[1] ?>
        </p>

        <h3> Коммуникации </h3>
        <p>
            <? echo $Communications[1] ?>
        </p>

        <h3> Программное обеспечение </h3>
        <p>
            <? echo $Software[1] ?>
        </p>

        <h3> Разъемы </h3>
        <p>
            <? echo $Connectors[1] ?>
        </p>

        <h3> Корпус </h3>
        <p>
            <? echo $Housing[1] ?>
        </p>

        <h3> Дополнительно </h3>
        <p>
            <? echo $Additionally[1] ?>
        </p>

    </div><!-- end PC -->
    <center>
        <a class='link' name='buy' href="?page=<?= $ID ?>&buy=1">Купить</a>
    </center>
    <? mysqli_close($link); ?>
    </div>
    <!--end content -->
</body>

</html>