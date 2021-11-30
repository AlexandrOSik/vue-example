<?php

require('utils/connection.php');
require('models/User.php');

if (!isset($_POST['usr']) || 
    !isset($_POST['pwd'])) {
    header("HTTP/1.1 401");
    echo '{"success":false,"code":0}';
    die();
}

$login = $_POST['usr'];
$password = $_POST['pwd'];

$db = db_connect();
$stmt = $db->prepare("SELECT * FROM users WHERE login=:login");
$stmt->setFetchMode(PDO::FETCH_CLASS, 'User', []);
if (!$stmt->execute([":login" => $login])) {
    echo '{"success":false,"code":5}';
    die();
}

$user = $stmt->fetch();
if (!$user) {
    header("HTTP/1.1 403");
    echo '{"success":false,"code":1}';
    die();
}

if (hash("sha512", hex2bin($user->sault) . $password, false) != $user->password_hash) {
    header("HTTP/1.1 403");
    echo '{"success":false,"code":2}';
    die();
}

require('utils/token.php');

$login_time = (new DateTime())->getTimestamp();
$token = create_token([
    "ip" => $_SERVER['REMOTE_ADDR'],
    "user_id" => $user->id,
    "role" => $user->id,
    'login_time' => $login_time
]);

$query = "INSERT INTO users(login, role_id, sault, password_hash, data) 
                VALUES(:login, 2, UNHEX(:sault), UNHEX(:hash), :data)";

// Куки HTTP-only запрещают забирать куку с помощью JS
setcookie('AuthToken', $token);

echo json_encode([
    'success' => true,
    // Если ещё где-то планируется использовать, например в мобильном приложении 
    'token' => $token 
], JSON_PRETTY_PRINT);

?>
