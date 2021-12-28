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
     * Sanitises Username.
     *
     * @param string $tainted_user_name
     * @return mixed|string
     */
    public function validateUserName(string $tainted_user_name) : string
    {
        $cleaned_user_name = '';

        if (!empty($tainted_user_name)
            && strlen($tainted_user_name) <= 30) {
            $cleaned_user_name = filter_var(
                $tainted_user_name,
                FILTER_SANITIZE_STRING,
                FILTER_FLAG_NO_ENCODE_QUOTES
            );
        }

        return $cleaned_user_name;
    }
}
