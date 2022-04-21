<?php

namespace NotificationChannels\Corvass\Events;

use BahriCanli\Corvass\ShortMessageCollection;

/**
 * Class SendingMessages.
 */
class SendingMessages
{
    /**
     * The Corvass message.
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
