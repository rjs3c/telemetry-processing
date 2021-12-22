<?php


namespace TelemProc;


class RegisterModel
{

    private $doctrine_wrapper;
    private $bcrypt_wrapper;
    private $register_credentials;

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
     * Sets register credentials
     *
     * @param $register_credentials
     */
    public function setRegisterCredentials($register_credentials)
    {
        $this->register_credentials = $register_credentials;
    }

    /**
     * Registers new users. Returns true if registered successfully and false if not.
     * Will not allow multiple accounts of the same username and will return false if attempted.
     *
     * @return bool
     */
    public function register() : bool
    {

        //Check if account with username already exists
        $username = $this->register_credentials['username'];
        $this->doctrine_wrapper->checkIfUsernameAvailable($username);
        $isAvailable = $this->doctrine_wrapper->getQueryResult();

        //Hash password
        if($isAvailable)
        {
            fwrite(STDERR, print_r('is available', TRUE));
            $password = $this->register_credentials['password'];
            $hashed_password = $this->bcrypt_wrapper->createHashedPassword($password);

            //Store new user details
            $this->doctrine_wrapper->storeUserDetails($username, $hashed_password);
            $register_result = $this->doctrine_wrapper->getQueryResult();
        }else
        {
            $register_result = false;
        }

        return $register_result;
    }

}