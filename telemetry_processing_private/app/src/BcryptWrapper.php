<?php
/**
 * BcryptWrapper.php
 *
 * Provides a wrapper for <Bcrypt> functionalities.
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

namespace TelemProc;

class BcryptWrapper
{
    /** @var array $bcrypt_settings Contains settings for <Bcrypt>. */
    private array $bcrypt_settings;

    public function __construct()
    {
        $this->bcrypt_settings = array();
    }

    public function __destruct() {}

    /**
     * Sets the settings (bcrypt algorithm and cost) for Bcrypt.
     *
     * @param array $bcrypt_settings
     */
    public function setBcryptSettings(array $bcrypt_settings) : void
    {
        $this->bcrypt_settings = $bcrypt_settings;
    }

    /**
     * Creates a hash of an entered password using password_hash.
     *
     * @param string $password_to_hash
     * @return false|string|null
     */
    public function hashPassword(string $password_to_hash)
    {
        $hashed_password = '';

        if (!empty($password_to_hash)
            && !empty($this->bcrypt_settings)) {
            $bcrypt_algorithm = $this->bcrypt_settings['bcrypt_alg'];
            $options = $this->bcrypt_settings['options'];
            $hashed_password = password_hash($password_to_hash, $bcrypt_algorithm, $options);
        }

        return $hashed_password;
    }

    /**
     * Ensures a supplied and stored hash match.
     *
     * @param string $user_password
     * @param string $stored_user_password
     * @return bool
     */
    public function verifyPassword(string $user_password, string $stored_user_password) : bool
    {
        $user_authenticated = false;

        if (!empty($user_password)
            && !empty($stored_user_password)) {
            $user_authenticated = password_verify($user_password, $stored_user_password);
        }

        return $user_authenticated;
    }
}
