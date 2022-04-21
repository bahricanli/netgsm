<?php

namespace NotificationChannels\Corvass\Test;

use Exception;
use Mockery as M;
use NotificationChannels\Corvass\Corvass;
use Illuminate\Notifications\Notification;
use NotificationChannels\Corvass\CorvassChannel;
use BahriCanli\Corvass\Http\Responses\CorvassResponseInterface;
use NotificationChannels\Corvass\Exceptions\CouldNotSendNotification;

class CorvassChannelTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CorvassChannel
     */
    private $channel;

    /**
     * @var CorvassResponseInterface
     */
    private $responseInterface;

    public function setUp()
    {
        parent::setUp();

        $this->channel = new CorvassChannel();
        $this->responseInterface = M::mock(CorvassResponseInterface::class);
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function test_it_sends_notification()
    {
        Corvass::shouldReceive('sendShortMessage')
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
        return [CorvassChannel::class];
    }

    public function toCorvass($notifiable)
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
