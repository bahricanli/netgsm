<?php

namespace NotificationChannels\JetSMS\Test\Events;

use Mockery as M;
use BahriCanli\Netgsm\ShortMessageCollection;
use NotificationChannels\Netgsm\Events\SendingMessages;

class SendingMessagesTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        M::close();

        parent::tearDown();
    }

    public function test_it_constructs()
    {
        $shortMessageCollection = M::mock(ShortMessageCollection::class);

        $event = new SendingMessages($shortMessageCollection);

        $this->assertInstanceOf(SendingMessages::class, $event);
        $this->assertEquals($shortMessageCollection, $event->messages);
    }
}
