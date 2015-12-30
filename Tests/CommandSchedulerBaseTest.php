<?php
/**
 * Base test class
 */

namespace JMose\CommandSchedulerBundle\Tests;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class CommandSchedulerBaseTest extends WebTestCase
{
    /**
     * prepare test environment
     */
    protected function setUp()
    {

        $this->dropDatabase(); // remove database just to be safe

        // (re)create database
        self::runCommand('doctrine:database:create');
        // setup database schema
        self::runCommand('doctrine:schema:update',
            array(
                '--force' => true
            )
        );
        // no need to load fixtures here, they will be loaded be each test on demand
    }

    /**
     * Tests completed, clean up
     */
    protected function tearDown()
    {
        $this->dropDatabase();

        parent::tearDown();
    }

    /**
     * drop database
     */
    private function dropDatabase()
    {
        self::runCommand('doctrine:database:drop',
            array(
                '--force' => true
            )
        );
    }
}
