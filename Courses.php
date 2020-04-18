<?php
    //Если переменная name передана
    if (isset($_POST["name"])) {//ОСТАВИТЬ ИЛИ ПОМЕНЯТЬ НА !empty
      //Если это запрос на обновление, то обновляем
      if (isset($_GET['red_courseid'])) {//ОСТАВИТЬ ИЛИ ПОМЕНЯТЬ НА !empty
          $id = trim($_GET['red_courseid']); 
          $name = trim($_POST["name"]);
          $price = trim($_POST["price"]);
          $schedule = trim($_POST["schedule"]);
          $teacher = trim($_POST["teacher"]);
          $sql = "UPDATE courses SET name=?, price=?, schedule=?, teacher=?  WHERE course_ID=?";
          $query = $pdo->prepare($sql);
          $query->execute(array($name, $price, $schedule, $teacher, $id));
          redirect_to('/index.php');
      } 

      else {//Если НЕ запрос на обновление, то добавляем новую запись
          $sql = ("INSERT INTO courses (name, price, schedule, teacher) VALUES (:name, :price, :schedule, :teacher)");
          $name = trim($_POST["name"]);
          $price = trim($_POST["price"]);
          $schedule = trim($_POST["schedule"]);
          $teacher = trim($_POST["teacher"]);
          $params = [':name' => $name, ':price' => $price, ':schedule' => $schedule, ':teacher' => $teacher];
          $query = $pdo->prepare($sql);
          $query->execute($params);
          redirect_to('/index.php');
      }

    }

    if (isset($_GET['del_courseid'])) {//Удалем уже существующую запись
    $id = trim($_GET['del_courseid']); 
    $sql = "DELETE FROM courses WHERE course_ID=?";
    $query = $pdo->prepare($sql);
    $query->execute(array($id));
    redirect_to('/index.php');
    }
    //ДОДЕЛАТЬ ЭТО ГОВНО, ЧТОБЫ В ВЫПАДАЮЩИЙ СПИСОК ЗАНОСИЛ ВВЕДЕННЫЕ РАНЕЕ ДАННЫЕ
    if (isset($_GET['red_courseid'])) {// Передаем данные редактируемого товара в поля
    $id = trim($_GET['red_courseid']);
    $sql =  ("SELECT  name, price, schedule, teacher FROM courses WHERE course_ID=?");
    $query = $pdo->prepare($sql);
    $query->execute(array($id));
    $course = $query->fetch(PDO::FETCH_LAZY);
    }
?>

<div>
<p><b>Курсы ЦМИТ</b></p>
   <form action="" method="post">
    <table>
      <tr>
      <td><input type="text" name="name" placeholder="Наименование курса" class="form-control" value="<?= isset($_GET['red_courseid']) ? $course['name'] : ''; ?>"></td>
      </tr>
      <tr>
        <td><input type="text" name="price" size="2" placeholder="Стоимость курса" class="form-control" value="<?= isset($_GET['red_courseid']) ? $course['price'] : ''; ?>">
        </td>   
      </tr>
      <tr>
      <td><textarea type="text" id="course" name="schedule" placeholder="Расписание" class="form-control">
      </textarea></td>
      <script type="text/javascript">document.getElementById('course').value = "<?= isset($_GET['red_courseid']) ? $course['schedule'] : ''; ?>";</script>
      </tr>

    <tr><td>
    <select class="form-control" name="teacher"  size="1" value="<?= isset($_GET['red_courseid']) ? $course['teacher'] : ''; ?>">
    <option disabled>Выберите преподавателя</option>
    <?php 
    $sql = $pdo->query('SELECT staff_ID, FIO FROM staff');
    while($object = $sql->fetch()):?>
    <option value ="<?=$object['staff_ID']?>"><?=$object['FIO']?></option>
    <?php endwhile;?>
    </select></td>
      <td colspan="2"><input type="submit" class="btn btn-success" value="OK"></td></tr>
   </table>
  </form>
  <table class="table table-bordered" border='1'>
    <thead>
    <tr>
      
      <th>Наименование</th>
      <th>Цена</th>
      <th>Расписание</th>
      <th>Преподаватель</th>
      <th width="10%">Удаление</th>
      <th width="10%">Редактирование</th>
    </tr>
  </thead>
    <br>
<?php
      $sql1 = $pdo->query('SELECT * FROM staff RIGHT JOIN courses ON staff.staff_ID=courses.teacher');
      $sql = $pdo->query('SELECT course_ID, name, price, schedule, teacher FROM courses');
      while ($result = $sql1->fetch()) {//Заполнение полей таблицы данными из БД
        echo '<tr>' .
             //"<td>{$result['course_ID']}</td>" .
             "<td>{$result['name']}</td>" .
             "<td>{$result['price']} ₽</td>" .
             "<td>{$result['schedule']}</td>" .
             "<td>{$result['FIO']}</td>" .
             "<td><a style=\"text-decoration: none;\" href='?del_courseid={$result['course_ID']}'><button class=\"btn btn-outline-danger\" style=\"display: flex; margin: auto;\">Удалить</button></a></td>" .
             "<td><a  style=\"text-decoration: none;\" href='?red_courseid={$result['course_ID']}'><button class=\"btn btn-outline-info\" style=\"display: flex; margin: auto;\">Изменить</button></a></td>" .
             '</tr>';
        }
      
?>
  </table>
</br>
</div>