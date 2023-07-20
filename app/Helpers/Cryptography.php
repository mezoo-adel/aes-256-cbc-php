<?php

namespace App\Helpers;

class Cryptography
{

    const FILE_ENCRYPTION_CHUNK = 100000;
    const CIPHER_ALGO = 'aes-256-cbc';

    public static function encrypt($source, $dest, $key = 123)
    {
        $ivLenght = openssl_cipher_iv_length(self::CIPHER_ALGO);
        $iv = openssl_random_pseudo_bytes($ivLenght);

        $fpSource = fopen($source, 'rb');
        $fpDest = fopen($dest, 'w');

        fwrite($fpDest, $iv);

        while (!feof($fpSource)) {
            $plaintext = fread($fpSource, $ivLenght * self::FILE_ENCRYPTION_CHUNK);
            $ciphertext = openssl_encrypt($plaintext, self::CIPHER_ALGO, $key, OPENSSL_RAW_DATA, $iv);
            $iv = substr($ciphertext, 0, $ivLenght);

            fwrite($fpDest, $ciphertext);
        }

        fclose($fpSource);
        fclose($fpDest);
    }

    public static function decrypt($source, $dest, $key = 123)
    {
        $ivLenght = openssl_cipher_iv_length(self::CIPHER_ALGO);

        $fpSource = fopen($source, 'rb');
        $fpDest = fopen($dest, 'w');

        $iv = fread($fpSource, $ivLenght);

        while (!feof($fpSource)) {
            $ciphertext = fread($fpSource, $ivLenght * (self::FILE_ENCRYPTION_CHUNK + 1));
            $plaintext = openssl_decrypt($ciphertext, self::CIPHER_ALGO, $key, OPENSSL_RAW_DATA, $iv);
            $iv = substr($plaintext, 0, $ivLenght);

            fwrite($fpDest, $plaintext);
        }

        fclose($fpSource);
        fclose($fpDest);
    }
}
