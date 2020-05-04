<?php
    //Валидация переменных
    if($_POST["Name"] || $_POST["Price"]){

        $name = clean($_POST["Name"]);
        $price = clean($_POST["Price"]);

        if (empty($_POST["Name"]) || check_length($_POST["Name"], 30)) {
            $msg = "Введите корректное название";
        }

        elseif (!isset($_POST["Price"]) || check_length($_POST["Price"], 10) || !is_numeric($_POST["Price"])){
            $msg = "Введите корректную цену";
        }

        else{
            //Если это запрос на обновление, то обновляем
            if (isset($_GET['red_id'])) {//ОСТАВИТЬ ИЛИ ПОМЕНЯТЬ НА !empty
                $id = trim($_GET['red_id']);
                $sql = "UPDATE `products` SET name=?, price=?  WHERE product_ID=?";
                $query = $pdo->prepare($sql);
                $query->execute(array($name, $price, $id));
                redirect_to('index.php');
            } else {//Если НЕ запрос на обновление, то добавляем новую запись
                $sql = ("INSERT INTO products (Name, Price) VALUES (:name, :price)");
                $params = [':name' => $name, ':price' => $price];
                $query = $pdo->prepare($sql);
                $result = $query->execute($params);
                redirect_to('index.php');
            }
        }
    }

    if (isset($_GET['del_id'])) {//Удалем уже существующую запись
        $id = trim($_GET['del_id']);
        $sql = "DELETE FROM products WHERE product_ID=?";
        $query = $pdo->prepare($sql);
        $query->execute(array($id));
        redirect_to('index.php');
    }

    if (isset($_GET['red_id'])) {// Передаем данные редактируемого товара в поля
        $id = trim($_GET['red_id']);
        $sql =  ("SELECT product_ID, Name, Price FROM products WHERE product_ID=?");
        $query = $pdo->prepare($sql);
        $query->execute(array($id));
        $product = $query->fetch(PDO::FETCH_LAZY);
    }

    ?>
  <div>
    <p><b>Готовые изделия ЦМИТ</b></p>
        <form action="" method="post">
            <table>
                <tr>

                    <td><input type="text" name="Name" placeholder="Наименование изделия" class="form-control" value="<?= isset($_GET['red_id']) ? $product['Name'] : $name; ?>"></td>
                </tr>
                <tr>
                    <td><input type="text" name="Price" size="2" placeholder="Стоимость изделия" class="form-control" value="<?= isset($_GET['red_id']) ? $product['Price'] : $price; ?>">
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
    <br/>


<?php
    echo $msg;
    $sql = $pdo->query('SELECT `product_ID`, `Name`, `Price` FROM products');
    while ($result = $sql->fetch()) {//Заполнение полей таблицы данными из БД
        echo '<tr>' .
        //"<td>{$result['ID']}</td>" .
        "<td>{$result['Name']}</td>" .
        "<td>{$result['Price']} ₽</td>" .
        "<td><a style=\"text-decoration: none;\" href='?del_id={$result['product_ID']}'><button class=\"btn btn-outline-danger\" style=\"display: flex; margin: auto;\">Удалить</button></a></td>" .
        "<td><a  style=\"text-decoration: none;\" href='?red_id={$result['product_ID']}'><button class=\"btn btn-outline-info\" style=\"display: flex; margin: auto;\">Изменить</button></a></td>" .
        '</tr>';
      }
?>
  </table>
<br/>
</div>
