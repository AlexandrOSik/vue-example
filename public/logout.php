<?php

require('utils/connection.php');
require('models/User.php');

if (!isset($_COOKIE['AuthToken'])) {
    echo '{"success":false}';
    die();
}

// Куки HTTP-only запрещают забирать куку с помощью JS
setcookie('AuthToken', $token, -1, "/", "");

echo json_encode([
    'success' => true
], JSON_PRETTY_PRINT);

?>
