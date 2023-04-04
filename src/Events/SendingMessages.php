<?php

namespace NotificationChannels\Netgsm\Events;

use BahriCanli\Netgsm\ShortMessageCollection;

/**
 * Class SendingMessages.
 */
class SendingMessages
{
    /**
     * The Netgsm message.
     *
     * @var ShortMessageCollection
     */
    public $messages;

    /**
     * SendingMessage constructor.
     *
     * @param  ShortMessageCollection $messages
     */
    public function __construct(ShortMessageCollection $messages)
    {
        $this->messages = $messages;
    }
}
