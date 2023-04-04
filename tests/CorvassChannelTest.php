<?php

namespace NotificationChannels\netgsm\Test;

use Exception;
use Mockery as M;
use NotificationChannels\netgsm\netgsm;
use Illuminate\Notifications\Notification;
use NotificationChannels\netgsm\netgsmChannel;
use BahriCanli\netgsm\Http\Responses\netgsmResponseInterface;
use NotificationChannels\netgsm\Exceptions\CouldNotSendNotification;

class netgsmChannelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var netgsmChannel
     */
    private $channel;

    /**
     * @var netgsmResponseInterface
     */
    private $responseInterface;

    public function setUp()
    {
        parent::setUp();

        $this->channel = new netgsmChannel();
        $this->responseInterface = M::mock(netgsmResponseInterface::class);
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function test_it_sends_notification()
    {
        netgsm::shouldReceive('sendShortMessage')
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
        return [netgsmChannel::class];
    }

    public function tonetgsm($notifiable)
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
