<?php

define('ENCRYPTION_ALGORITHM', 'aes-256-cbc');
define('ENCRYPTION_KEY', hex2bin('edc8e507ffbfae403802208ca4eef02b'));
define('DECRYPTION_KEY', ENCRYPTION_KEY);
define('INITIAL_VECTOR', hex2bin('fc08fdd4e46f57cd47dd89217471fdb4'));

function encrypt($data) {
    return openssl_encrypt($data, ENCRYPTION_ALGORITHM, ENCRYPTION_KEY, 0, INITIAL_VECTOR);
}

function decrypt($data) {
    return openssl_decrypt($data, ENCRYPTION_ALGORITHM, DECRYPTION_KEY, 0, INITIAL_VECTOR);
}

?>
