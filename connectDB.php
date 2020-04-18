<?php
    $host = 'localhost';
    $db   = 'cmit';
    $user = 'root';
    $pass = 'root';
    $charset = 'utf8';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    try {
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    } 
    catch (PDOException $e) {
    die('Подключение не удалось: ' . $e->getMessage());
    }
?>