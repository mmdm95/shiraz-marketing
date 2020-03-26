<?php

namespace HSession\Security\Crypt;


use HSession\Traits\GeneralTrait;

class Crypt implements CryptInterface
{
    use GeneralTrait;

    /**
     * @var $config array
     */
    protected $config = [
        'main_key' => 'Lk5Uz3slx3BrAghS1aaW5AYgWZRV0tIX5eI0yPchFz4=',
        'assured_key' => 'EZ44mFi3TlAey1b2w4Y7lVDuqO+SRxGXsa7nctnr/JmMrA2vN6EJhrvdVZbxaQs5jpSe34X3ejFK/o9+Y5c83w==',
    ];

    /**
     * @see openssl_get_cipher_methods() - PHP build-in function, to see all methods
     */
    protected $encrypt_fst_method = 'aes-256-cbc';
    protected $encrypt_snd_method = 'sha3-512';

    /**
     * @var $has_error bool
     */
    protected $has_error = false;

    /**
     * Encrypt the given $data
     *
     * @param $data
     * @return mixed
     */
    public function encrypt($data)
    {
        if (empty($data)) {
            $this->has_error = true;
            return false;
        }

        // Decode crypt keys
        $first_key = base64_decode($this->config['main_key']);
        $second_key = base64_decode($this->config['assured_key']);

        // Create an IV for encryption
        $iv_length = openssl_cipher_iv_length($this->encrypt_fst_method);
        $iv = openssl_random_pseudo_bytes($iv_length);

        // Encrypt for first time with first crypt key
        $first_encrypted = openssl_encrypt($data, $this->encrypt_fst_method, $first_key, OPENSSL_RAW_DATA, $iv);
        // Encrypt first encryption for second time with second crypt key
        $second_encrypted = hash_hmac($this->encrypt_snd_method, $first_encrypted, $second_key, TRUE);

        // Encode second crypted data to base64 with created IV
        $output = base64_encode($iv . $second_encrypted . $first_encrypted);

        // Return the crypted value
        $this->has_error = false;
        return $output;
    }

    /**
     * Decrypt the given $data.
     * Do exactly opposite of encryption
     *
     * @param string $data
     * @return mixed
     */
    public function decrypt($data)
    {
        if(!is_string($data) || empty($data)) return false;

        // Decode crypt keys
        $first_key = base64_decode($this->config['main_key']);
        $second_key = base64_decode($this->config['assured_key']);

        // Decode base64 coded $data
        $mix = base64_decode($data);

        // Get length of IV from crypt first method
        $iv_length = openssl_cipher_iv_length($this->encrypt_fst_method);

        // Get IV from decoded $data
        $iv = substr($mix, 0, $iv_length);
        // Get second encrypted $data from $mix
        $second_encrypted = substr($mix, $iv_length, 64);
        // Get first encrypted $data from $mix
        $first_encrypted = substr($mix, $iv_length + 64);

        // Decrypt first encrypted $data with first encryption method
        $data = openssl_decrypt($first_encrypted, $this->encrypt_fst_method, $first_key, OPENSSL_RAW_DATA, $iv);
        $second_encrypted_new = hash_hmac($this->encrypt_snd_method, $first_encrypted, $second_key, TRUE);

        // Check if new second encrypted data is equals to previous second encrypted data,
        // then return decrypted data
        if (hash_equals($second_encrypted, $second_encrypted_new)) {
            $this->has_error = false;
            return $data;
        }

        // Otherwise it has modefied
        $this->has_error = true;
        return false;
    }

    /**
     * Use this function after each encryption or decryption to see everything is OK or not.
     * Note: Use this right after any encryption or decryption, because it change!
     *
     * @return bool
     */
    public function hasError()
    {
        return $this->has_error;
    }
}