<?php
//Валидация переменных
if($_POST["employee"] || $_POST["service"] || $_POST["status"] || $_POST["ready_date"]) {

    $employee = clean($_POST["employee"]);
    $service = clean($_POST["service"]);
    $status = clean($_POST["status"]);
    $ready_date = clean($_POST["ready_date"]);

    if (empty($_POST["status"])) {
        $msg = "Введите корректный статус заказа";
    } elseif (!isset($_POST["ready_date"]) || check_length($_POST["ready_date"], 11)) {
        $msg = "Введите корректную дату выполнения заказа";
    } else {
        //Если это запрос на обновление, то обновляем
        if (isset($_GET['red_trackid'])) {//ОСТАВИТЬ ИЛИ ПОМЕНЯТЬ НА !empty
            $id = trim($_GET['red_trackid']);
            $sql = "UPDATE tracking SET service=?, employee=?, status=?, ready_date=? WHERE order_ID=?";
            $query = $pdo->prepare($sql);
            $query->execute(array($service, $employee, $status, $ready_date, $id));
            redirect_to('/index.php');
        }
        else {//Если НЕ запрос на обновление, то добавляем новую запись
            $sql = ("INSERT INTO tracking (service, employee, status, ready_date) VALUES (:service, :employee, :status, :ready_date)");
            $params = [':service' => $service, ':employee' => $employee, ':status' => $status, ':ready_date' => $ready_date];
            $query = $pdo->prepare($sql);
            $query->execute($params);
            redirect_to('/index.php');
        }
    }
}
    if (isset($_GET['del_trackid'])) {//Удалем уже существующую запись
    $id = trim($_GET['del_trackid']); 
    $sql = "DELETE FROM tracking WHERE order_ID=?";
    $query = $pdo->prepare($sql);
    $query->execute(array($id));
    redirect_to('/index.php');
    }

    if (isset($_GET['red_trackid'])) {// Передаем данные редактируемого товара в поля
    $id = trim($_GET['red_trackid']);
    $sql =  ("SELECT order_ID, service, employee, status, ready_date FROM tracking WHERE order_ID=?");
    $query = $pdo->prepare($sql);
    $query->execute(array($id));
    $track = $query->fetch(PDO::FETCH_LAZY);
    }
?>

<div>
<p><b>Отслеживание заказа</b></p>
   <form action="" method="post">

    <table>
      <tr>
      <td><input type="text" name="status" placeholder="Статус" class="form-control" value="<?= isset($_GET['red_trackid']) ? $track['status'] : $status; ?>"></td>
      </tr>
      <tr>
      <td><input type="date" name="ready_date" placeholder="Дата готовности ГГГГ-ММ-ДД" class="form-control" value="<?= isset($_GET['red_trackid']) ? $track['ready_date'] : $ready_date; ?>"></td>
      </tr>
    <tr>
    <td><select class="form-control" name="employee" size="1" value="<?= isset($_GET['red_trackid']) ? $track['employee'] : $employee; ?>">
      <option disabled>Выберите исполнителя</option>
      <?php 
      $sql = $pdo->query('SELECT staff_ID, FIO FROM staff');
      while($object = $sql->fetch()):?>
      <option value ="<?=$object['staff_ID']?>"><?=$object['FIO']?></option>
      <?php endwhile;?>
    </select>
    </td></tr>
    <tr>
    <td colspan="2"><select class="form-control" name="service" size="1"> value="<?= isset($_GET['red_trackid']) ? $track['service'] : ''; ?>">
      <option disabled>Выберите услугу</option>
      <?php 
      $sql1 = $pdo->query('SELECT service_ID, service_name FROM services');
      while($object1 = $sql1->fetch()):?>
      <option value ="<?=$object1['service_ID']?>"><?=$object1['service_name']?></option>
      <?php endwhile;?>
      </select>
    </td>
    <td colspan=""><input type="submit" class="btn btn-success" value="OK"></td></tr>
  </table>
  </form>

  <table class="table table-bordered" border='1'>
    <thead>
    <tr>
      <th width="10%">Номер заказа</th>
      <th align="center">Наименование услуги</th>
      <th >Исполнитель</th>
      <th>Статус</th>
      <th>Дата готовности</th>
      <th width="10%">Удаление</th>
      <th width="10%">Редактирование</th>
    </tr>
  </thead>
    <br/>
<?php
    echo $msg;
      $sql = $pdo->query('SELECT * FROM services join tracking ON services.service_ID = tracking.service join staff ON staff.staff_ID = tracking.employee');
      while ($result = $sql->fetch()) {//Заполнение полей таблицы данными из БД
        echo '<tr>' .
             "<td>{$result['order_ID']}</td>" .
             "<td>{$result['service_name']}</td>" .
             "<td>{$result['FIO']}</td>" .
             "<td>{$result['status']}</td>" .
             "<td>{$result['ready_date']}</td>" .
             "<td><a style=\"text-decoration: none;\" href='?del_trackid={$result['order_ID']}'><button class=\"btn btn-outline-danger\" style=\"display: flex; margin: auto;\">Удалить</button></a></td>" .
             "<td><a  style=\"text-decoration: none;\" href='?red_trackid={$result['order_ID']}'><button class=\"btn btn-outline-info\" style=\"display: flex; margin: auto;\">Изменить</button></a></td>" .
             '</tr>';
        }
      
?>
  </table>
<br/>
</div>