<?php

namespace NotificationChannels\Netgsm\Events;

use BahriCanli\Netgsm\ShortMessage;

/**
 * Class SendingMessage.
 */
class SendingMessage
{
    /**
     * The Netgsm message.
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
