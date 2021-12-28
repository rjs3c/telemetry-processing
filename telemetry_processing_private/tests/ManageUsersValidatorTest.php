<?php declare(strict_types=1);
/**
 * ManageUsersValidatorTest.php
 *
 * Tests for the successful validation of usernames.
 * Tests:
 * - Correct validation of valid usernames.
 * - Correct validation of an invalid username (testing if this strips tags and handles empty usernames successfully).
 *
 * @package telemetry_processing
 * @\TelemProc
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use PHPUnit\Framework\TestCase;
use TelemProc\ManageUsersValidator;

final class ManageUsersValidatorTest extends TestCase
{
    /**
     * @test To check if valid usernames can be correctly validated.
     */
    public function testValidatesValidUsernamesCorrectly()
    {
        $manage_users_validator = new ManageUsersValidator();

        $test_usernames_list = array(
            0 => array(
                'username' => 'testUsername1',
            ),
            1 => array(
                'username' => 'testUsername2'
            ),
            2 => array(
                'username' => 'testUsername3'
            )
        );

        $expected_usernames_list = array(
            0 => 'testUsername1',
            1 => 'testUsername2',
            2 => 'testUsername3'
        );

        $this->assertEquals(
            $manage_users_validator->validateRetrievedUsernames($test_usernames_list),
            $expected_usernames_list
        );
    }

    /**
     * @test To identify that a list of invalid usernames can be correctly validated and sanitised.
     */
    public function testValidatesInvalidUsernamesCorrectly()
    {
        $manage_users_validator = new ManageUsersValidator();

        $test_usernames_list = array(
            0 => array(
                'username' => '<script>testUsername1</script>',
            ),
            1 => array(
                'username' => '',
            ),
        );

        $expected_usernames_list = array(
            0 => 'testUsername1'
        );

        $this->assertEquals(
            $manage_users_validator->validateRetrievedUsernames($test_usernames_list),
            $expected_usernames_list
        );
    }
}