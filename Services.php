<?php  
ini_set('display_errors',1);
error_reporting(E_ALL);
    include('ConnectDB.php');
    //Если переменная service_name передана
    if (isset($_POST["service_name"])) {//ОСТАВИТЬ ИЛИ ПОМЕНЯТЬ НА !empty
      //Если это запрос на обновление, то обновляем
      if (isset($_GET['red_serviceid'])) {//ОСТАВИТЬ ИЛИ ПОМЕНЯТЬ НА !empty
          $service_name = trim($_POST["service_name"]);
          $service_price = trim($_POST["service_price"]);
          $id = trim($_GET['red_serviceid']); 
          $sql = "UPDATE services SET service_name=?, service_price=?  WHERE service_ID=?";
          $query = $pdo->prepare($sql);
          $query->execute(array($service_name, $service_price, $id));
          redirect_to('/index.php');
      } 
      else {//Если НЕ запрос на обновление, то добавляем новую запись
          $sql = ("INSERT INTO services (service_name, service_price) VALUES (:service_name, :service_price)");
          $service_name = trim($_POST["service_name"]);
          $service_price = trim($_POST["service_price"]);
          $params = [':service_name' => $service_name, ':service_price'=>$service_price];
          $query = $pdo->prepare($sql);
          $query->execute($params);
          redirect_to('/index.php');
      }

    }

    if (isset($_GET['del_serviceid'])) {//Удалем уже существующую запись
    $id = trim($_GET['del_serviceid']); 
    $sql = "DELETE FROM services WHERE service_ID=?";
    $query = $pdo->prepare($sql);
    $query->execute(array($id));
    redirect_to('/index.php');
    }

    if (isset($_GET['red_serviceid'])) {// Передаем данные редактируемого товара в поля
    $id = trim($_GET['red_serviceid']);
    $sql =  ("SELECT service_ID, service_name, service_price FROM services WHERE service_ID=?");
    $query = $pdo->prepare($sql);
    $query->execute(array($id));
    $service = $query->fetch(PDO::FETCH_LAZY);
    }
?>


<div class="container">
  <p><b>Услуги ЦМИТ</b></p>
   <form action="" method="post">
    <table>
      <tr>

        <td><input type="text" name="service_name" placeholder="Наименование изделия" class="form-control" value="<?= isset($_GET['red_serviceid']) ? $service['service_name'] : ''; ?>"></td>
      </tr>
      <tr>
        <td><input type="text" name="service_price" size="2" placeholder="Стоимость изделия" class="form-control" value="<?= isset($_GET['red_serviceid']) ? $service['service_price'] : ''; ?>">
        </td>
         <td colspan="2"><input type="submit" class="btn btn-success" value="OK"></td>
      </tr>
    </table>
  </form>
 <table class="table table-bordered" border='1'>
    <thead>
    <tr>

      <th>Наименование</th>
      <th>Цена</th>
      <th width="10%">Удаление</th>
      <th width="10%">Редактирование</th>
    </tr>
  </thead>
</br>
<?php
      $sql1 = $pdo->query("SELECT service_ID, service_name, service_price FROM services");
      while ($service_result = $sql1->fetch()) {//Заполнение полей таблицы данными из БД
        echo '<tr>' .
             //"<td>{$service_result['service_ID']}</td>" .
             "<td>{$service_result['service_name']}</td>" .
             "<td>{$service_result['service_price']} ₽</td>" .
             "<td><a style=\"text-decoration: none;\" href='?del_serviceid={$service_result['service_ID']}'><button class=\"btn btn-outline-danger\" style=\"display: flex; margin: auto;\">Удалить</button></a></td>" .
             "<td><a style=\"text-decoration: none;\" href='?red_serviceid={$service_result['service_ID']}'><button class=\"btn btn-outline-info\" style=\"display: flex; margin: auto;\">Изменить</button></a></td>" .
             '</tr>';
      }      
?>
  </table>
  </br>
</div>

