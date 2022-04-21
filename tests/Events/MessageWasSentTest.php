<?php

namespace NotificationChannels\JetSMS\Test\Events;

use Mockery as M;
use BahriCanli\Corvass\ShortMessage;
use NotificationChannels\Corvass\Events\MessageWasSent;
use BahriCanli\Corvass\Http\Responses\CorvassResponseInterface;

class MessageWasSentTest extends \PHPUnit_Framework_TestCase
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
        $shortMessage = M::mock(ShortMessage::class);
        $response = M::mock(CorvassResponseInterface::class);

        $event = new MessageWasSent($shortMessage, $response);

        $this->assertInstanceOf(MessageWasSent::class, $event);
        $this->assertEquals($shortMessage, $event->message);
        $this->assertEquals($response, $event->response);
    }
}
