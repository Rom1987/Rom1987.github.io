<form action="registration.php" method="POST">

  <table>
    <tr>
      <td>Никнейм:</td>
      <td><input type="text" name="user_nickname" value="<?php echo @$_POST['user_nickname']; ?>"></td>
      <td></td>
    </tr>

    <tr>
      <td>Пароль:</td>
      <td><input type="password" name="user_password" value="<?php echo @$_POST['user_password']; ?>"></td>
    </tr>

    <tr>
      <td>Повторите пароль:</td>
      <td><input type="password" name="user_password_again" value="<?php echo @$_POST['user_password_again']; ?>"></td>
      <td></td>
    </tr>

    <tr>
      <td colspan=3 style="height:20px;"></td>
    </tr>

    <tr>
      <td>Фамилия:</td>
      <td><input type="text" name="user_lname" value="<?php echo @$_POST['user_lname']; ?>"></td>
      <td></td>
    </tr>

    <tr>
      <td>Имя:</td>
      <td><input type="text" name="user_fname" value="<?php echo @$_POST['user_fname']; ?>"></td>
      <td></td>
    </tr>

    <tr>
      <td>Отчество:</td>
      <td><input type="text" name="user_sname" value="<?php echo @$_POST['user_sname']; ?>"></td>
      <td></td>
    </tr>

    <tr>
      <td>Адрес проживания:</td>
      <td><input type="text" name="user_address" value="<?php echo @$_POST['user_address']; ?>"></td>
      <td></td>
    </tr>

    <tr>
      <td>Дата рождения:</td>
      <td><input type="date" class="user_date" name="user_date" value="<?php echo @$_POST['user_date']; ?>"></td>
      <td></td>
    </tr>

    <tr>
      <td>Контактный телефон:</td>
      <td><input type="number" name="user_phone" value="<?php echo @$_POST['user_phone']; ?>"></td>
      <td></td>
    </tr>

    <tr>
      <td colspan=3>
        <br>
        <center>
          <button type="submit" name="registration_button" value="Зарегистрироваться">Зарегистрироваться</button>
        </center>
      </td>
    </tr>

  </table>

</form>