<?php
/**
 * LoginModel.php
 *
 * Allows users to login if and only if their credentials are in the database
 * Test:
 * - Logs in user with correct credentials
 * - Doesnt log in user with incorrect credentials.
 */


namespace TelemProc;

class LoginModel
{

    private $doctrine_wrapper;
    private $bcrypt_wrapper;
    private $login_credentials;
    private $login_result;

    public function __construct()
    {
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

    /**
     * Sets <Doctrine> wrapper
     *
     * @param $doctrine_wrapper
     */
    public function setDoctrineWrapper($doctrine_wrapper)
    {
        $this->doctrine_wrapper = $doctrine_wrapper;
    }

    /**
     * Sets <Bcrypt> wrapper
     *
     * @param $bcrypt_wrapper
     */
    public function setBcryptWrapper($bcrypt_wrapper)
    {
        $this->bcrypt_wrapper = $bcrypt_wrapper;
    }

    /**
     * Sets login credentials
     *
     * @param $login_credentials
     */
    public function setLoginCredentials($login_credentials)
    {
        $this->login_credentials = $login_credentials;
    }

    public function getLoginResult() : bool
    {
        return $this->login_result;
    }

    /**
     * Logs in a user. Returns true if logged in successfully and false otherwise.
     *
     * @return bool
     */
    public function login() : void
    {
        $login_result = false;

        //fetch password for given username
        $username = $this->login_credentials['username'];
        if(!empty($username)) {
            $this->doctrine_wrapper->fetchUserPassword($username);
            $query_result = $this->doctrine_wrapper->getQueryResult();

            if (!empty($query_result)) {
                $fetched_password = $query_result[0]['password'];

                //check if password is equal to given password
                $given_password = $this->login_credentials['password'];
                $login_result = $this->bcrypt_wrapper->authenticatePassword($given_password, $fetched_password);
            }
        }
        $this->login_result = $login_result;
    }

}