<?php

namespace Darkish\WebsiteBundle\Security;

/**
* 
*/
class Mencryptor
{
	
	private $salt = "9kcnrhHGDSLIu987iohoxzchoishd";
    public function encrypt($text)
    {
        return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->salt, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
    }

    public function decrypt($text)
    {
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->salt, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
    }
}
