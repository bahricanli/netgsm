<?php

namespace NotificationChannels\JetSMS\Test\Events;

use Mockery as M;
use BahriCanli\netgsm\ShortMessage;
use NotificationChannels\netgsm\Events\MessageWasSent;
use BahriCanli\netgsm\Http\Responses\netgsmResponseInterface;

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
        $response = M::mock(netgsmResponseInterface::class);

        $event = new MessageWasSent($shortMessage, $response);

        $this->assertInstanceOf(MessageWasSent::class, $event);
        $this->assertEquals($shortMessage, $event->message);
        $this->assertEquals($response, $event->response);
    }
}
