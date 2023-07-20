<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## RUN project locally after git clone git@github.com:mezoo-adel/aes-256-cbc-php.git


- cd  aes-256-cbc-php
- run "composer update"
- cp .env.example .env
- php artisan key:generate
- php artisan serve --port=5080
- finally, explore the project at 127.0.0.1:5080




## Explaination

1. Constants:
   - `FILE_ENCRYPTION_CHUNK`: This constant defines the chunk size in bytes for reading the source file in blocks during encryption. It's set to 100,000 bytes (100KB) in this example.
   - `CIPHER_ALGO`: This constant specifies the encryption algorithm used, which is AES-256-CBC. CBC stands for Cipher Block Chaining, and it is one of the modes of operation for block ciphers like AES.

2. Function Signature:
   ```php
   public static function encrypt($source, $dest, $key)
   ```
   The function `encrypt` is declared as `public` and `static`, meaning it can be accessed without creating an instance of the class. It takes three parameters:
   - `$source`: The path to the source file that needs to be encrypted.
   - `$dest`: The path to the destination file where the encrypted data will be written.
   - `$key`: The encryption key.

3. Initialization Vector (IV) Generation:
   ```php
   $ivLenght = openssl_cipher_iv_length(self::CIPHER_ALGO);
   $iv = openssl_random_pseudo_bytes($ivLenght);
   ```
   The code starts by generating a random Initialization Vector (IV) using `openssl_random_pseudo_bytes()`. The IV is essential for ensuring different ciphertexts are generated for the same plaintext, making the encryption more secure.

4. File Handling:
   ```php
   $fpSource = fopen($source, 'rb');
   $fpDest = fopen($dest, 'w');
   ```
   The code opens the source file and destination file using `fopen()`. The source file is opened in read-binary mode (`'rb'`), and the destination file is opened in write mode (`'w'`). This prepares both files for reading and writing operations, respectively.

5. IV Writing:
   ```php
   fwrite($fpDest, $iv);
   ```
   The IV is written to the destination file using `fwrite()` before the encryption process starts. It ensures the same IV is available during decryption to correctly initialize the encryption algorithm.

6. File Encryption Loop:
   ```php
   while (!feof($fpSource)) {
       $plaintext = fread($fpSource, $ivLenght * self::FILE_ENCRYPTION_CHUNK);
       $ciphertext = openssl_encrypt($plaintext, self::CIPHER_ALGO, $key, OPENSSL_RAW_DATA, $iv);
       $iv = substr($ciphertext, 0, $ivLenght);
       fwrite($fpDest, $ciphertext);
   }
   ```
   Inside the loop, WHILE WE DIDN'T REACH EndOfFile, the source file is read in blocks (`$ivLenght * self::FILE_ENCRYPTION_CHUNK`) using `fread()`. The data read is stored in `$plaintext`.

   The `$plaintext` is then encrypted using `openssl_encrypt()`, with the specified algorithm, the provided `$key`, and the current IV (`$iv`). The resulting ciphertext is stored in `$ciphertext`.

   Since AES in CBC mode requires a unique IV for each block, the last block's ciphertext becomes the new IV for the next block. Therefore, we extract the IV from the first block of the ciphertext using `substr()` and set it to `$iv` for the next iteration.

   The encrypted data (`$ciphertext`) is written to the destination file using `fwrite()` inside the loop, ensuring the entire file is encrypted block by block.

7. Closing File Handles:
   ```php
   fclose($fpSource);
   fclose($fpDest);
   ```
   After the encryption process is complete, both the source and destination file handles are closed using `fclose()`.

In summary, this function uses the AES-256-CBC encryption algorithm to encrypt the contents of a source file block by block and writes the encrypted data to a destination file. The Initialization Vector (IV) is generated randomly and written to the beginning of the destination file to be used during decryption.
