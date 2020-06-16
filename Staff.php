<?php /** @noinspection SqlDialectInspection */
//Валидация переменных
if($_POST["FIO"] || $_POST["post"]) {

    $fio = clean($_POST["FIO"]);
    $post = clean($_POST["post"]);
    $email = clean($_POST["email"]);
    $phone = clean($_POST["phone"]);

    if (empty($_POST["FIO"]) || check_length($_POST["FIO"], 70)) {
        $msg = "Введите корректные ФИО";
    }
    elseif (!isset($_POST["post"]) || check_length($_POST["post"], 50)) {
        $msg = "Введите корректную должность";
    }
    elseif (!empty($_POST["email"]) && (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) || check_length($_POST["post"], 30)){
            $msg = "Введиет корректный E-mail";
    }
    elseif (!empty($_POST["phone"]) && (!validate_phone($_POST["phone"]) || check_length($_POST["post"], 20))){
        $msg = "Введите корректный номер телефона";
    }
    else {
        //Если это запрос на обновление, то обновляем
        if (isset($_GET['red_staffid'])) {//ОСТАВИТЬ ИЛИ ПОМЕНЯТЬ НА !empty
            $id = trim($_GET['red_staffid']);
            $sql = "UPDATE staff SET FIO=?, post=?, email=?, phone=? WHERE staff_ID=?";
            $query = $pdo->prepare($sql);
            $query->execute(array($fio, $post, $email, $phone, $id));
            redirect_to('/index.php');

        } else {//Если НЕ запрос на обновление, то добавляем новую запись
            $sql = ("INSERT INTO staff (FIO, post, email, phone) VALUES (:FIO, :post, :email, :phone)");
            $id = trim($_GET['red_staffid']);
            $params = [':FIO' => $fio, ':post' => $post, 'email' => $email, 'phone' => $phone];
            $query = $pdo->prepare($sql);
            $query->execute($params);
            redirect_to('/index.php');
        }
    }
}

    if (isset($_GET['del_staffid'])) {//Удалем уже существующую запись
    $id = trim($_GET['del_staffid']); 
    $sql = "DELETE FROM staff WHERE staff_ID=?";
    $query = $pdo->prepare($sql);
    $query->execute(array($id));
    redirect_to('/index.php');
    }

    if (isset($_GET['red_staffid'])) {// Передаем данные редактируемого товара в поля
    $id = trim($_GET['red_staffid']);
    $sql =  ("SELECT staff_ID, FIO, post, email, phone FROM staff WHERE staff_ID=?");
    $query = $pdo->prepare($sql);
    $query -> execute(array($id));
    $staff = $query->fetch(PDO::FETCH_LAZY);
    }
?>

<div>
<p><b>Контакты сотрудников ЦМИТ и ЦДОД</b></p>
   <form action="" method="post">
    <table>
      <tr>
      	<td><input type="text" name="FIO" placeholder="Фамилия Имя Отчество" class="form-control" value="<?= isset($_GET['red_staffid']) ? $staff['FIO'] : $fio; ?>"></td>
      </tr>
      <tr>
        <td><input type="text" name="post" size="2" placeholder="Должность" class="form-control" value="<?= isset($_GET['red_staffid']) ? $staff['post'] : $post; ?>">
        </td>
      </tr>
      <tr>
      	<td><input type="text" name="email" placeholder="E-mail" class="form-control" value="<?= isset($_GET['red_staffid']) ? $staff['email'] : $email; ?>"></td>
      </tr>
      <tr>
      	<td><input type="text" name="phone" placeholder="Номер телефона" class="form-control" value="<?= isset($_GET['red_staffid']) ? $staff['phone'] : $phone; ?>"></td>
      	<td colspan="2"><input type="submit" class="btn btn-success" value="OK"></td>
      </tr>

    </table>
  </form>
  <table class="table table-bordered" border='1'>
    <thead>
    <tr>
      
      <th>Фамилия Имя Отчество</th>
      <th>Должность</th>
      <th>E-mail</th>
      <th>Номер телефона</th>
      <th width="10%">Удаление</th>
      <th width="10%">Редактирование</th>
    </tr>
  </thead>
    <br/>
<?php
    echo $msg;
    $sql = $pdo->query('SELECT `staff_ID`, `FIO`, `post`, `email`, `phone` FROM staff');
    while ($result = $sql->fetch()) {//Заполнение полей таблицы данными из БД
      echo '<tr>' .
           //"<td>{$result['staff_ID']}</td>" .
           "<td>{$result['FIO']}</td>" .
           "<td>{$result['post']}</td>" .
           "<td>{$result['email']}</td>" .
           "<td>{$result['phone']}</td>" .
           "<td><a style=\"text-decoration: none;\" href='?del_staffid={$result['staff_ID']}'><button class=\"btn btn-outline-danger\" style=\"display: flex; margin: auto;\">Удалить</button></a></td>" .
           "<td><a style=\"text-decoration: none;\" href='?red_staffid={$result['staff_ID']}'><button class=\"btn btn-outline-info\" style=\"display: flex; margin: auto;\">Изменить</button></a></td>" .
           '</tr>';
    }
?>
  </table>
<br/>
</div>
