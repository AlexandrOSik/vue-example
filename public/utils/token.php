<?php

require('encryption.php');

function create_token($data) {
    return base64_encode(encrypt(json_encode($data)));
}

function parse_token($token) {
    return json_decode(decrypt(base64_decode($token)));
}

?>
