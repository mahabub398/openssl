<?php
$string = 'It works ? Or not it works ?';
$pass = '1234';
$method = 'aes128';

file_put_contents ('./file.encrypted', openssl_encrypt ($string, $method, $pass));
?>