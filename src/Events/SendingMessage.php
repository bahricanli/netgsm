<?php

namespace NotificationChannels\Corvass\Events;

use BahriCanli\Corvass\ShortMessage;

/**
 * Class SendingMessage.
 */
class SendingMessage
{
    /**
     * The Corvass message.
     *
     * @var ShortMessage
     */
    public $message;

    /**
     * SendingMessage constructor.
     *
     * @param $message
     */
    public function __construct(ShortMessage $message)
    {
        $this->message = $message;
    }
}
