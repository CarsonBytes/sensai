<?php
//$key should have been previously generated in a cryptographically safe way, like openssl_random_pseudo_bytes
//$key = openssl_random_pseudo_bytes(1);
$key = 'test';

$cipher = "aes-128-gcm";

//$ivlen = openssl_cipher_iv_length($cipher);
//$iv = openssl_random_pseudo_bytes($ivlen);
$iv = $cipher;

$array = array('test'=>true, 'fasdf'=>'fsdfsd');
$tag=null;
$plaintext = json_encode($array);
if (in_array($cipher, openssl_get_cipher_methods())) {
    $ciphertext = openssl_encrypt($plaintext, $cipher, $key, $options = 0,  $iv, $tag);

    echo '<pre>';
    var_dump($ciphertext);
    var_dump($tag);
    echo '</pre>';
    $tag=null;

    //store $cipher, $iv, and $tag for decryption later
    $original_plaintext = openssl_decrypt($ciphertext, $cipher, $key, $options = 0, $iv, $tag);
    echo $original_plaintext . "<br>";
}
echo '<pre>';
var_dump(json_decode($original_plaintext));
var_dump($tag);
echo '</pre>';
die();