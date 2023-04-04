<?php

namespace NotificationChannels\Netgsm\Test;

use Exception;
use Mockery as M;
use NotificationChannels\Netgsm\Netgsm;
use Illuminate\Notifications\Notification;
use NotificationChannels\Netgsm\NetgsmChannel;
use BahriCanli\Netgsm\Http\Responses\NetgsmResponseInterface;
use NotificationChannels\Netgsm\Exceptions\CouldNotSendNotification;

class NetgsmChannelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NetgsmChannel
     */
    private $channel;

    /**
     * @var NetgsmResponseInterface
     */
    private $responseInterface;

    public function setUp()
    {
        parent::setUp();

        $this->channel = new NetgsmChannel();
        $this->responseInterface = M::mock(NetgsmResponseInterface::class);
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function test_it_sends_notification()
    {
        Netgsm::shouldReceive('sendShortMessage')
            ->once()
            ->with('+1234567890', 'foo')
            ->andReturn($this->responseInterface);

        $this->channel->send(new TestNotifiable(), new TestNotification());
    }

    public function test_it_throws_exception_if_no_receiver_provided()
    {
        $e = null;

        try {
            $this->channel->send(new EmptyTestNotifiable(), new TestNotification());
        } catch (Exception $e) {
        }

        $this->assertInstanceOf(CouldNotSendNotification::class, $e);
    }
}

class TestNotifiable
{
    public function routeNotificationFor()
    {
        return '+1234567890';
    }
}

class TestNotification extends Notification
{
    public function via($notifiable)
    {
        return [NetgsmChannel::class];
    }

    public function toNetgsm($notifiable)
    {
        return 'foo';
    }
}

class EmptyTestNotifiable
{
    public function routeNotificationFor()
    {
        return '';
    }
}
