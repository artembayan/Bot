<?ob_start();?> <!--Создание буфера для заголовков (костыль?) -->
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div>
<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
include('ConnectDB.php'); // Подключение БД
include('Products.php'); //Подключение файла с готовыми продуктами
include('Services.php'); //Подключение файла с улугами
include('Staff.php'); //Подключение файла с контактами сотрудников
include('Courses.php'); //Подключение файла со списком курсов
include('Tracking.php'); // Подключение файла с отслеживанием заказов
include('Working_hours.php'); // Подключение файла с режимом работы
include('Requisites.php'); // Подключение файла с реквизитами
?> 
</div>

</body>
</html>