<?php
/**
 * Tests for command controller
 */

namespace JMose\CommandSchedulerBundle\Tests\Controller;

use JMose\CommandSchedulerBundle\Tests\CommandSchedulerBaseTest;

class CommandControllerTest extends CommandSchedulerBaseTest
{
    /**
     * Test "Create a new command" button.
     */
    public function testInitNewScheduledCommand()
    {
        // load empty command
        $this->loadFixtures(array());

        // get input form
        $client = parent::createClient();
        $crawler = $client->request('GET', '/command-scheduler/detail/commands/new');

        $fields = array(
            'select#scheduled_command_command' => 1, // command select
            'select#scheduled_command_rights' => 1, // user/host select

            // input fields
            '#scheduled_command_name' => 1,
            '#scheduled_command_arguments' => 1,
            '#scheduled_command_cronExpression' => 1,
            '#scheduled_command_logFile' => 1,
            '#scheduled_command_priority' => 1,
            '#scheduled_command_expectedRuntime' => 1,
            '#scheduled_command_executeImmediately' => 1,
            '#scheduled_command_disabled' => 1,
            '#scheduled_command_logExecutions' => 1,

            'a.btn' => 1, // back button
            'button#scheduled_command_save' => 1, // save button

            // cronhelper
            'div#cronhelper' => 1,

            '#cron_minute' => 1,
            '#cron_minute_modulo' => 1,
            '#cron_hour' => 1,
            '#cron_hour_modulo' => 1,
            '#cron_day' => 1,
            '#cron_day_modulo' => 1,
            '#cron_month' => 1,
            '#cron_month_modulo' => 1,
            '#cron_week' => 1,
            '#cron_expression' => 1,
        );

        foreach ($fields as $field => $count) {
            // check for fields
            $this->assertEquals($count, $crawler->filter($field)->count());
        }
    }

    /**
     * Test "Edit a command" action
     */
    public function testInitEditScheduledCommand()
    {
        //DataFixtures create 4 records
        $this->loadFixtures(array(
            'JMose\CommandSchedulerBundle\DataFixtures\ORM\LoadScheduledCommandData'
        ));

        // get form
        $client = parent::createClient();
        $crawler = $client->request('GET', '/command-scheduler/detail/commands/edit/1');

        $fields = array(
            'select#scheduled_command_command' => 1, // command select
            'select#scheduled_command_rights' => 1, // user/host select

            // input fields
            '#scheduled_command_name' => 1,
            '#scheduled_command_arguments' => 1,
            '#scheduled_command_cronExpression' => 1,
            '#scheduled_command_logFile' => 1,
            '#scheduled_command_priority' => 1,
            '#scheduled_command_expectedRuntime' => 1,
            '#scheduled_command_executeImmediately' => 1,
            '#scheduled_command_disabled' => 1,
            '#scheduled_command_logExecutions' => 1,

            'a.btn' => 1, // back button
            'button#scheduled_command_save' => 1, // save button
        );

        foreach ($fields as $field => $count)
            $this->assertEquals($count,
                $crawler->filter($field)->count()
            );

        $buttonCrawlerNode = $crawler->selectButton('Save');
        $form = $buttonCrawlerNode->form();
        $fixtureSet = array(
            'scheduled_command[id]' => "1",
            'scheduled_command[name]' => "one",
            'scheduled_command[command]' => "debug:container",
            'scheduled_command[arguments]' => "--help",
            'scheduled_command[cronExpression]' => "@daily",
            'scheduled_command[logFile]' => "one.log",
            'scheduled_command[priority]' => "100"
        );

        $this->assertArraySubset($fixtureSet, $form->getValues());
    }

//    /**
//     * Test new scheduling creation
//     */
//    public function testNewSave()
//    {
//        $this->loadFixtures(array());
//
//        $client = parent::createClient();
//        $client->followRedirects(true);
//        $crawler = $client->request('GET', '/command-JMose\CommandSchedulerBundle\Tests/detail/new');
//        $buttonCrawlerNode = $crawler->selectButton('Save');
//        $form = $buttonCrawlerNode->form();
//
//        $form->setValues(array(
//            'command_scheduler_detail[name]' => "wtc",
//            'command_scheduler_detail[command]' => "translation:update",
//            'command_scheduler_detail[arguments]' => "--help",
//            'command_scheduler_detail[cronExpression]' => "@daily",
//            'command_scheduler_detail[logFile]' => "wtc.log",
//            'command_scheduler_detail[priority]' => "5"
//        ));
//        $crawler = $client->submit($form);
//
//        $this->assertEquals(1, $crawler->filter('a[href^="/command-JMose\CommandSchedulerBundle\Tests/action/toggle/"]')->count());
//        $this->assertEquals("wtc", trim($crawler->filter('td')->eq(1)->text()));
//    }
//
//    /**
//     * Test "Edit and save a scheduling"
//     */
//    public function testEditSave()
//    {
//        //DataFixtures create 4 records
//        $this->loadFixtures(array(
//            'JMose\CommandSchedulerBundle\Fixtures\ORM\LoadScheduledCommandData'
//        ));
//
//        $client = parent::createClient();
//        $client->followRedirects(true);
//        $crawler = $client->request('GET', '/command-JMose\CommandSchedulerBundle\Tests/detail/edit/1');
//        $buttonCrawlerNode = $crawler->selectButton('Save');
//        $form = $buttonCrawlerNode->form();
//
//        $form->get('command_scheduler_detail[name]')->setValue('edited one');
//        $crawler = $client->submit($form);
//
//        $this->assertEquals(4, $crawler->filter('a[href^="/command-JMose\CommandSchedulerBundle\Tests/action/toggle/"]')->count());
//        $this->assertEquals("edited one", trim($crawler->filter('td')->eq(1)->text()));
//    }

}
