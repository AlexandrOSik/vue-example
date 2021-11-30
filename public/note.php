<?php

// Проверка авторизованности пользователя
require_once('auth.php');

// Соединение
require_once('utils/connection.php');

// Пользователь
require_once('models/Note.php');

/**
 * Серверу пришёл некорректный запрос,
 * например неверные вещи
 * @param $headers - HTTP заголовки, которые нужно добавить
 */
function bad_request($headers = []) {
    header('HTTP/1.1 400 Bad Request');
    header('Content-Type: application/json; charset=UTF-8');
    foreach ($headers as $header => $value) {
        header("$header: $value");
    }
    die();
}

// $token определён в auth.php
$db = db_connect();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Выбрать все заметки
    $stmt = $db->prepare('SELECT * FROM notes WHERE user_id=:user_id');
    $stmt->execute([':user_id' => $token->user_id]);
    $notes = $stmt->fetchAll(PDO::FETCH_CLASS, 'Note');

    header('HTTP/1.1 200 Ok');
    header('Content-Type: application/json');
    echo json_encode($notes);
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Добавить новую заметку

    if ($_SERVER["CONTENT_TYPE"] !== 'application/json') {
        // Некорректный запрос
        bad_request();
    }

    // Если запрос с заголовком Content-Type: application/json
    // то вытаскивать параметры POST запроса нужно так
    $request_body = file_get_contents("php://input");
    $args = json_decode($request_body, true);

    if (!isset($args['body'])) {
        bad_request();
    }

    $body = $args['body'];
    $stmt = $db->prepare('INSERT INTO notes(user_id, body) VALUES (:user_id, :body)');

    if ($stmt->execute([
        ':user_id' => $token->user_id,
        ':body' => $body
    ])) {
        // Сообщаем, что объект был создан
        header('HTTP/1.1 201 Creater');
        header('Content-Type: application/json; charset=UTF-8');
        header('Location: /note.php');
    } else {
        // Сообщаем, что произошла ошибка
        header('HTTP/1.1 500 Internal Server Error');
        header('Content-Type: text/plane; charset=UTF-8');
        echo var_dump($stmt->errorInfo());
    }
}


?>