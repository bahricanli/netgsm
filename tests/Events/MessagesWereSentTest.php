<?php

namespace NotificationChannels\JetSMS\Test\Events;

use Mockery as M;
use BahriCanli\Netgsm\ShortMessageCollection;
use NotificationChannels\Netgsm\Events\MessagesWereSent;
use BahriCanli\Netgsm\Http\Responses\NetgsmResponseInterface;

class MessagesWereSentTest extends \PHPUnit_Framework_TestCase
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
        $response = M::mock(NetgsmResponseInterface::class);

        $event = new MessagesWereSent($shortMessageCollection, $response);

        $this->assertInstanceOf(MessagesWereSent::class, $event);
        $this->assertEquals($shortMessageCollection, $event->messages);
        $this->assertEquals($response, $event->response);
    }
}
