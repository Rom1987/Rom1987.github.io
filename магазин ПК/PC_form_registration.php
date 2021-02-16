<form action="PC_registration.php" method="POST">

  <table>
    <tr>
      <td>Имя ПК:</td>
      <td><input type="text" name="PC_name" value="<?php echo @$_POST['PC_name']; ?>"></td>
      <td></td>
    </tr>

    <tr>
      <td>Характеристика:</td>
      <td><input type="text" name="Characteristic" value="<?php echo @$_POST['Characteristic']; ?>"></td>
    </tr>

    <tr>
      <td>Категория:</td>
      <td>
        <!-- Выпадающий список -->
        <section>
          <select class='PC_form_category' name="Category">
            <option value="Игровой">Игровой</option>
            <option value="Средний">Средний</option>
            <option value="Бюджетный">Бюджетный</option>
          </select>
        </section>
        <!-- end Выпадающий список -->
      </td>
      <td></td>
    </tr>

    <tr>
      <td>Картинка:</td>
      <td><input type="text" name="IMG" value="<?php echo @$_POST['IMG']; ?>"></td>
      <td></td>
    </tr>

    <tr>
      <td>Цена:</td>
      <td><input type="number" name="Price" value="<?php echo @$_POST['Price']; ?>"></td>
      <td></td>
    </tr>

    <tr>
      <td>Количество:</td>
      <td><input type="number" name="Quantity" value="<?php echo @$_POST['Quantity']; ?>"></td>
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