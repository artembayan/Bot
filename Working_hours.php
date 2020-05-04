<?php
//Валидация переменных
if($_POST["hours"]) {

    $hours = clean($_POST["hours"]);

    if (empty($_POST["hours"])) {
        $msg = "Введите корректный режим работы";
    }
    else {
        //Если это запрос на обновление, то обновляем
        if (isset($_GET['red_hoursid'])) {//ОСТАВИТЬ ИЛИ ПОМЕНЯТЬ НА !empty
            $id = trim($_GET['red_hoursid']);
            $sql = "UPDATE `working_hours` SET hours=? WHERE hours_ID=?";
            $query = $pdo->prepare($sql);
            $query->execute(array($hours, $id));
            redirect_to('/index.php');
        } else {//Если НЕ запрос на обновление, то добавляем новую запись
            $sql = ("INSERT INTO working_hours (hours) VALUES (:hours)");
            $params = [':hours' => $hours];
            $query = $pdo->prepare($sql);
            $query->execute($params);
            redirect_to('/index.php');
        }
    }
}

    if (isset($_GET['del_hoursid'])) {//Удалем уже существующую запись
    $id = trim($_GET['del_hoursid']); 
    $sql = "DELETE FROM working_hours WHERE hours_ID=?";
    $query = $pdo->prepare($sql);
    $query->execute(array($id));
    redirect_to('/index.php');
    }

    /*if (isset($_GET['red_hoursid'])) {// Передаем данные редактируемого товара в поля
    $id = trim($_GET['red_hoursid']);
    $sql = ("SELECT hours FROM working_hours WHERE hours_ID=?");
    $query = $pdo->prepare($sql);
    $query->execute(array($id));
    $hour = $query->fetch();
    }*/
?>
<div>
<p><b>Режим работы ЦМИТ</b></p>
   <form action="" method="post">
    <table>
      <tr>
        <td><textarea type="text" id="hour" name="hours" size="2" placeholder="Режим работы" class="form-control"></textarea>
        </td>
                <!--<script type="text/javascript">document.getElementById('hour').value = "<?= isset($_GET['red_hoursid']) ? $hour['hours'] : ''; ?>";</script>-->
         <td colspan="2"><input type="submit" class="btn btn-success" value="OK"></td>
      </tr>
    </table>
  </form>
  <table class="table table-bordered" border='1'>
    <thead>
    <tr>
      <th>Режим работы</th>
      <th width="10%">Удаление</th>
      <!--<th width="10%">Редактирование</th>-->
    </tr>
  </thead>
    <br/>
<?php
    echo $msg;
      $sql = $pdo->query('SELECT hours_ID, hours FROM working_hours');
      while ($result = $sql->fetch()) {//Заполнение полей таблицы данными из БД
        echo '<tr>' .
             "<td>{$result['hours']}</td>" .
             "<td><a style=\"text-decoration: none;\" href='?del_hoursid={$result['hours_ID']}'><button class=\"btn btn-outline-danger\" style=\"display: flex; margin: auto;\">Удалить</button></a></td>" .
             //"<td><a  style=\"text-decoration: none;\" href='?red_hoursid={$result['hours_ID']}'><button class=\"btn btn-outline-info\" style=\"display: flex; margin: auto;\">Изменить</button></a></td>" .
             '</tr>';
      }
?>
  </table>
<br/>
</div>