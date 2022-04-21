<?php

namespace NotificationChannels\Corvass\Events;

use BahriCanli\Corvass\ShortMessageCollection;
use BahriCanli\Corvass\Http\Responses\CorvassResponseInterface;

/**
 * Class MessagesWereSent.
 */
class MessagesWereSent
{
    /**
     * The sms message.
     *
     * @var ShortMessageCollection
     */
    public $messages;

    /**
     * The Api response implementation.
     *
     * @var CorvassResponseInterface
     */
    public $response;

    /**
     * MessageWasSent constructor.
     *
     * @param ShortMessageCollection  $messages
     * @param CorvassResponseInterface $response
     */
    public function __construct(ShortMessageCollection $messages, CorvassResponseInterface $response)
    {
        $this->messages = $messages;
        $this->response = $response;
    }
}
