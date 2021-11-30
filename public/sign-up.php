<?php

if (!isset($_POST['usr']) ||
    !isset($_POST['pwd'])) {
    die();
}

require('utils/connection.php');
require('models/User.php');

// Разбираем присланные параметры
$login = $_POST['usr'];
$password = $_POST['pwd'];
// Генерируем случайные 4 байта
$sault = random_bytes(4);
// Считаем хеш от соли + пароля
$hash = hash('SHA512', $sault . $password, false);
// Данные для запоминания
$data = json_encode([
    'ip' => $_SERVER['REMOTE_ADDR'],
    'reg_time' => (new DateTime())->getTimestamp(),
    'token_time' => NULL
]);
// Приводим соль в пригодный вид для вывода
$sault = bin2hex($sault);

// Запрос. Функция UNHEX превращает HEX-строку в бинарные данные 
$query = "INSERT INTO users(login, role_id, sault, password_hash, data) 
                    VALUES(:login, 2, UNHEX(:sault), UNHEX(:hash), :data)";

// Подсоединяемся к базе данных
$db = db_connect();

// Подготавливаем запрос
$stmt = $db->prepare($query);

// В запрос будут подставлены следующие 
// значения на места :login, :sault и т.д.
$params = [
    ':login' => $login,
    ':sault' => $sault,
    ':hash' => $hash,
    ':data' => $data
];

if ($stmt->execute($params)) {
    // Если запрос успешен
    echo json_encode([
        'success' => true
    ]);
} else {
    // Если запрос не успешен
    echo json_encode([
        'success' => false
    ]);
}

?>