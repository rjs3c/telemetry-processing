<?php declare(strict_types=1);
/**
 * SessionWrapperTest.php
 *
 * Tests session management using the SessionWrapper.
 * Tests:
 * - Successful setting of a session variable.
 * - Successful retrieval of previously set session variable.
 * - Successful unsetting of previously set session variable.
 *
 * @package telemetry_processing
 *
 * @author James Brass
 * @author Mo Aziz
 * @author Ryan Instrell
 */

use PHPUnit\Framework\TestCase;
use TelemProc\SessionWrapper;

final class SessionWrapperTest extends TestCase
{
    /**
     * @test For storing data. Expected output is true.
     * Fails if value isn't found in $_SESSION.
     */
    public function testSetSessionVar()
    {
        $session_wrapper = new SessionWrapper();

        $result = $session_wrapper->setSessionVar('user', 'username');
        $this->assertTrue($result);
    }

    /**
     * @test For retrieving data. Expected output is 'username'.
     * Fails if value doesn't equal the one stored in $_SESSION.
     */
    public function testGetSessionVar()
    {
        $session_wrapper = new SessionWrapper();

        $result = $session_wrapper->getSessionVar('user');
        $this->assertEquals('username', $result);
    }

    /**
     * @test For unsetting session data. Expected output is true.
     * Fails if data in $_SESSION cannot be unset.
     */
    public function testUnsetSessionVar()
    {
        $session_wrapper = new SessionWrapper();

        $result = $session_wrapper->unsetSessionVar('user');
        $this->assertTrue($result);
    }
}
