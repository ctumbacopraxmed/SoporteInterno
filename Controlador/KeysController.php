<?php
require_once dirname(__DIR__) . '/config/config.php';

class KeysController
{
    public function __construct() {}

    public function encrypt($password)
    {
        $key = hex2bin(APP_ENCRYPTION_KEY);
        $iv = random_bytes(12);
        $ciphertext = openssl_encrypt(
            $password,
            'aes-256-gcm',
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );
        return base64_encode($iv . $tag . $ciphertext);
    }
    public function decrypt($encrypted)
    {
        $key = hex2bin(APP_ENCRYPTION_KEY);
        $data = base64_decode($encrypted, true);
        if ($data === false) {
            return false;
        }
        $ivLength = 12;
        $tagLength = 16;
        $iv = substr($data, 0, $ivLength);
        $tag = substr($data, $ivLength, $tagLength);
        $ciphertext = substr($data, $ivLength + $tagLength);
        $decrypted = openssl_decrypt(
            $ciphertext,
            'aes-256-gcm',
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );
        return $decrypted;
    }
}
