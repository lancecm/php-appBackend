<?php

namespace app\common\lib;

/**
 * Class Aes
 * @package app\common\lib
 * AES 加密解密
 */
class Aes {
    private $key = null;

    public function __construct()
    {
        $this->key = config('app.aeskey');
    }

    /**
     * @param string $plaintext
     * @return string
     * AES加密
     * 更安全版本见 （由于过长，暂不使用）
     * https://stackoverflow.com/questions/3422759/php-aes-encrypt-decrypt/46872528#46872528
     */
    public function encrypt($plaintext = '') {
        $data = openssl_encrypt($plaintext, 'AES-128-ECB',
            $this->key, OPENSSL_RAW_DATA);
        $data = strtolower(bin2hex($data));
        return $data;
    }

    /**
     * @param $string
     * @param $key
     * @return string
     * AES解密
     */
    public function decrypt($string)
    {
        $decrypted = openssl_decrypt(hex2bin($string), 'AES-128-ECB',
            $this->key, OPENSSL_RAW_DATA);

        return $decrypted;
    }
}