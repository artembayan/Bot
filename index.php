<?ob_start();?> <!--Создание буфера для заголовков (костыль?) -->
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="style.css">
</head>

<body>


<br/>

<div class="container">
<ul class="nav nav-tabs" id="MyTabs">
  <li class="nav-item">
    <a class="nav-link active" data-toggle="tab" href="#Products">Продукты</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#Services">Услуги</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#Staff">Сотрудники</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#Courses">Курсы</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#Tracking">Отслеживанеи заказов</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#Working_hours">Режим работы</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#Requisites">Реквизиты</a>
  </li>
</ul>
<br/>
</div>

<?php
include('ConnectDB.php');
include('Validating.php');
function redirect_to($new_location) {//функция для отмены повторной отправки формы
header("Location: " . $new_location);//(редирект)
exit();
}

?> 

<div class="tab-content" id="Tabs">
  <div class="tab-pane active container" id="Products"><?php include('Products.php'); //Подключение файла с готовыми изделиями?></div>
  <div class="tab-pane container" id="Services"><?php include('Services.php'); //Подключение файла с улугами ?></div>
  <div class="tab-pane container" id="Staff"><?php include('Staff.php'); //Подключение файла с сотрудниками ?></div>
  <div class="tab-pane container" id="Courses"><?php include('Courses.php'); //Подключение файла со курсами ?></div>
  <div class="tab-pane container" id="Tracking"><?php include('Tracking.php'); // Подключение файла с отслеживанием заказов ?></div>
  <div class="tab-pane container" id="Working_hours"><?php include('Working_hours.php'); // Подключение файла с режимом работы ?></div>
  <div class="tab-pane container" id="Requisites"><?php include('Requisites.php'); // Подключение файла с реквизитами ?></div>



</body>
</html>