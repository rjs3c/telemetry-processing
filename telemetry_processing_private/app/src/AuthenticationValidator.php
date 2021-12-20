<?php
/**
 * AuthenticationValidator.php
 *
 * Provides a wrapper to validate user registered and entered information.
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

namespace TelemProc;

class AuthenticationValidator
{
    public function __construct() {}

    public function __destruct() {}

    /**
     * Sanitises and Validates user-entered Email.
     *
     * @param string $tainted_user_email
     * @return string
     */
    public function validateUserEmail(string $tainted_user_email) : string
    {
        $cleaned_user_email = '';

        if (!empty($tainted_user_email)) {
            $cleaned_user_email = filter_var(
                filter_var(
                    $tainted_user_email,
                    FILTER_SANITIZE_EMAIL
                ),
                FILTER_VALIDATE_EMAIL
            );
        }

        return $cleaned_user_email;
    }

    /**
     * Sanitises Username.
     *
     * @param string $tainted_user_name
     * @return mixed|string
     */
    public function validateUserName(string $tainted_user_name) : string
    {
        $cleaned_user_name = '';

        if (!empty($tainted_user_name)
            && strlen($tainted_user_name) <= 32) {
            $cleaned_user_name = filter_var(
                $tainted_user_name,
                FILTER_SANITIZE_STRING,
                FILTER_FLAG_NO_ENCODE_QUOTES
            );
        }

        return $cleaned_user_name;
    }
}