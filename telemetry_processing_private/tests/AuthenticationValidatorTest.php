<?php declare(strict_types=1);
/**
 * AuthenticationValidatorTest.php
 *
 * Tests the validation of the AuthenticationValidator.
 * Tests:
 * - Tests that a valid and properly-formed username can be correctly validated.
 * - Tests that an invalid username (with script tags) can be successfully validated.
 * - Tests that an invalid username (that exceeds the 30 character length) can be successfully validated.
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use PHPUnit\Framework\TestCase;
use TelemProc\AuthenticationValidator;

final class AuthenticationValidatorTest extends TestCase
{
    /**
     * @test To identify that a valid username can be validated correctly.
     */
    public function testValidUsernameSuccessfullyValidates()
    {
        $authentication_validator = new AuthenticationValidator();

        $test_valid_username = 'testUsername';

        $this->assertEquals(
          $authentication_validator->validateUserName($test_valid_username),
          $test_valid_username
        );
    }

    /**
     * @test To identify that a username that contains <> tags can be successfully sanitised.
     */
    public function testInvalidUsernameSuccessfullyValidates()
    {
        $authentication_validator = new AuthenticationValidator();

        $test_invalid_username = '<script>testUsername</script>';

        $test_expected_username = 'testUsername';

        $this->assertEquals(
            $authentication_validator->validateUserName($test_invalid_username),
            $test_expected_username
        );
    }

    /**
     * @test To identify that a username which exceeds expected length fails validation appropriately.
     */
    public function testInvalidLengthUsernameSuccessfullyValidates()
    {
        $authentication_validator = new AuthenticationValidator();

        $test_invalid_username = 'testUsernameIsTooLongInLengthToValidateCorrectly';

        $this->assertEquals(
            $authentication_validator->validateUserName($test_invalid_username),
            ''
        );
    }
}