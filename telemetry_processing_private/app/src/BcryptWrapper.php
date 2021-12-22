<?php
/**
 * Wrapper class for the PHP BCrypt library that creates a password hash or compares a un hashed
 * password with a hashed password
 */

namespace TelemProc;

class BcryptWrapper
{

    public function __construct(){}

    public function __destruct(){}

    /**
     * Creates a hash of a given password
     *
     * @param $password_to_hash
     * @return false|string|null
     */
    public function createHashedPassword($password_to_hash)
    {

        $options = array('cost' => BCRYPT_COST);
        $bcrypt_hashed_password = password_hash($password_to_hash, BCRYPT_ALGO, $options);

        return $bcrypt_hashed_password;
    }

    /**
     * Compares a given un hashed password with a given hashed password. Returns true if they are the same and
     * false otherwise
     *
     * @param $given_password
     * @param $stored_password
     * @return bool
     */
    public function authenticatePassword($given_password, $stored_password)
    {
        $user_authenticated = false;

        if (password_verify($given_password, $stored_password))
        {
            $user_authenticated = true;
        }

        return $user_authenticated;
    }
}
