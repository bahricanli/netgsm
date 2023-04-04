<?php

namespace NotificationChannels\netgsm\Events;

use BahriCanli\netgsm\ShortMessage;

/**
 * Class SendingMessage.
 */
class SendingMessage
{
    /**
     * The netgsm message.
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
