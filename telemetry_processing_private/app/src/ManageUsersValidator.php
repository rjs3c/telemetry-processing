<?php
/**
 * ManageUsersValidator.php
 *
 * Provides a wrapper for validation of usernames.
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

namespace TelemProc;

class ManageUsersValidator
{
    public function __construct() {}

    public function __destruct() {}

    /**
     * Sanitises a list of usernames.
     *
     * @param array $tainted_usernames
     * @return array
     */
    public function validateRetrievedUsernames(array $tainted_usernames) : array
    {
        $cleaned_usernames = array();

        foreach ($tainted_usernames as $tainted_username) {
            if (isset($tainted_username['username'])
            && !empty($tainted_username['username'])) {
                array_push($cleaned_usernames, $this->validateUserName($tainted_username['username']));
            }
        }

        return $cleaned_usernames;
    }

    /**
     * Sanitises Username.
     *
     * @param string $tainted_username
     * @return mixed|string
     */
    public function validateUserName(string $tainted_username) : string
    {
        $cleaned_username = '';

        if (!empty($tainted_username)
            && strlen($tainted_username) <= 30) {
            $cleaned_username = filter_var(
                $tainted_username,
                FILTER_SANITIZE_STRING,
                FILTER_FLAG_NO_ENCODE_QUOTES
            );
        }

        return $cleaned_username;
    }
}