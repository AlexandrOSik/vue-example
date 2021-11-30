<?php

// Проверка авторизованности пользователя
require_once('auth.php');

// Соединение
require_once('utils/connection.php');

// Пользователь
require_once('models/User.php');

$db = db_connect();

$stmt = $db->prepare('SELECT * FROM users');

if (!$stmt->execute()) {
    var_dump($stmt->errorInfo());
}
$users = $stmt->fetchAll(PDO::FETCH_CLASS, 'User');

echo json_encode($users, JSON_PRETTY_PRINT);

?>
