<?php
    //Если переменная FIO передана
    if (isset($_POST["FIO"])) {//ОСТАВИТЬ ИЛИ ПОМЕНЯТЬ НА !empty
      //Если это запрос на обновление, то обновляем
      if (isset($_GET['red_staffid'])) {//ОСТАВИТЬ ИЛИ ПОМЕНЯТЬ НА !empty
          $id = trim($_GET['red_staffid']);
          $fio = trim($_POST["FIO"]);
          $post = trim($_POST["post"]);
          $email = trim($_POST["email"]);
          $phone = trim($_POST["phone"]);
          $sql = "UPDATE staff SET FIO=?, post=?, email=?, phone=? WHERE staff_ID=?";
          $query = $pdo->prepare($sql);
          $query->execute(array($fio, $post, $email, $phone, $id));
          redirect_to('/index.php');

      } 
      else {//Если НЕ запрос на обновление, то добавляем новую запись
          $sql = ("INSERT INTO staff (FIO, post, email, phone) VALUES (:FIO, :post, :email, :phone)");
          $id = trim($_GET['red_staffid']);
          $fio = trim($_POST["FIO"]);
          $post = trim($_POST["post"]);
          $email = trim($_POST["email"]);
          $phone = trim($_POST["phone"]);
          $params = [':FIO' => $fio, ':post'=>$post, 'email'=>$email, 'phone'=>$phone];
          $query = $pdo->prepare($sql);
          $query->execute($params);
          redirect_to('/index.php');
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
<p><b>Контакты сотрудников ЦМИТ</b></p>
   <form action="" method="post">
    <table>
      <tr>
      	<td><input type="text" name="FIO" placeholder="Фамилия Имя Отчество" class="form-control" value="<?= isset($_GET['red_staffid']) ? $staff['FIO'] : ''; ?>"></td>
      </tr>
      <tr>
        <td><input type="text" name="post" size="2" placeholder="Должность" class="form-control" value="<?= isset($_GET['red_staffid']) ? $staff['post'] : ''; ?>">
        </td>
      </tr>
      <tr>
      	<td><input type="text" name="email" placeholder="E-mail" class="form-control" value="<?= isset($_GET['red_staffid']) ? $staff['email'] : ''; ?>"></td>
      </tr>
      <tr>
      	<td><input type="text" name="phone" placeholder="Номер телефона" class="form-control" value="<?= isset($_GET['red_staffid']) ? $staff['phone'] : ''; ?>"></td>
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
