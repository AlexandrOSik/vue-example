<?php

require('utils/connection.php');
require('models/User.php');

// Если нет куки AuthToken, то всё плохо
if (!isset($_COOKIE['AuthToken'])) {
    header('HTTP/1.1 403 Forbidden');
    die();
}

require('utils/token.php');

$user_ip = $_SERVER['REMOTE_ADDR'];
$token = parse_token($_COOKIE['AuthToken']);

if ($token === NULL || $token->ip !== $user_ip) {
    header('HTTP/1.1 403 Forbiden');
    die();
}

?>