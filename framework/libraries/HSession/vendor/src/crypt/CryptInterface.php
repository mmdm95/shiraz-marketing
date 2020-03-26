<?php

namespace HSession\Security\Crypt;


interface CryptInterface
{
    /**
     * Encrypt the given $data
     *
     * @param $data
     * @return mixed
     */
    public function encrypt($data);

    /**
     * Decrypt the given $data
     *
     * @param $data
     * @return mixed
     */
    public function decrypt($data);
}