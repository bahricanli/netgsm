<?php

namespace NotificationChannels\netgsm\Events;

use BahriCanli\netgsm\ShortMessageCollection;

/**
 * Class SendingMessages.
 */
class SendingMessages
{
    /**
     * The netgsm message.
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
