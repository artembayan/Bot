<?php    //Если переменная requisites передана
    if (isset($_POST["requisites"])) {//ОСТАВИТЬ ИЛИ ПОМЕНЯТЬ НА !empty
      //Если это запрос на обновление, то обновляем
      if (isset($_GET['red_requisitesid'])) {//ОСТАВИТЬ ИЛИ ПОМЕНЯТЬ НА !empty
          $requisites = trim($_POST["requisites"]);
          $id = trim($_GET['red_requisitesid']); 
          $sql = "UPDATE `requisites` SET requisites=? WHERE req_ID=?";
          $query = $pdo->prepare($sql);
          $query->execute(array($requisites, $id));
          redirect_to('/index.php');
      } 

      else {//Если НЕ запрос на обновление, то добавляем новую запись
          $sql = ("INSERT INTO requisites (requisites) VALUES (:requisites)");
          $requisites = trim($_POST["requisites"]);
          $params = [':requisites' => $requisites];
          $query = $pdo->prepare($sql);
          $query->execute($params);
          redirect_to('/index.php');
      }

    }

    if (isset($_GET['del_requisitesid'])) {//Удалем уже существующую запись
    $id = trim($_GET['del_requisitesid']); 
    $sql = "DELETE FROM requisites WHERE req_ID=?";
    $query = $pdo->prepare($sql);
    $query->execute(array($id));
    redirect_to('/index.php');
    }

   /* if (isset($_GET['red_requisitesid'])) {// Передаем данные редактируемого товара в поля
    $id = trim($_GET['red_requisitesid']);
    $sql =  ("SELECT req_ID, requisites FROM requisites WHERE req_ID=?");
    $query = $pdo->prepare($sql);
    $query->execute(array($id));
    $req = $query->fetch(PDO::FETCH_LAZY);
    }*/
?>

<div>
<p><b>Реквизиты ЦМИТ</b></p>
   <form action="" method="post">
    <table>
      <tr>
        <td>
        <textarea class="form-control" id="req" type="text" name="requisites" size="2" placeholder="Реквизиты" ></textarea>
        </td>
         <td colspan="2"><input type="submit" class="btn btn-success" value="OK"></td>
      </tr>
    </table>
  </form>
  <table class="table table-bordered" border='1'>
    <thead>
    <tr>
      <th>Реквизиты</th>
      <th width="10%">Удаление</th>
      <!--<th width="10%">Редактирование</th>-->
    </tr>
  </thead>
    <br/>
<?php
      $sql = $pdo->query('SELECT req_ID, requisites FROM requisites');
      while ($result = $sql->fetch()) {//Заполнение полей таблицы данными из БД
        echo '<tr>' .
             "<td>{$result['requisites']}</td>" .
             "<td><a style=\"text-decoration: none;\" href='?del_requisitesid={$result['req_ID']}'><button class=\"btn btn-outline-danger\" style=\"display: flex; margin: auto;\">Удалить</button></a></td>" .
             //"<td><a  style=\"text-decoration: none;\" href='?red_requisitesid={$result['req_ID']}'><button class=\"btn btn-outline-info\" style=\"display: flex; margin: auto;\">Изменить</button></a></td>" .
             '</tr>';
      }
?>
  </table>
<br/>
</div>