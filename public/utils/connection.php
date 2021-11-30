<?php

function db_connect() {

    $host = 'localhost';
    $dbname = 'access';
    $user = 'authentificator';
    $pass = 'SomeFantasticPassword';
    
    $db = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT );

    return $db;
}


?>
