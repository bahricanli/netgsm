<?php

namespace NotificationChannels\Netgsm\Events;

use BahriCanli\Netgsm\ShortMessageCollection;
use BahriCanli\Netgsm\Http\Responses\NetgsmResponseInterface;

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
     * @var NetgsmResponseInterface
     */
    public $response;

    /**
     * MessageWasSent constructor.
     *
     * @param ShortMessageCollection  $messages
     * @param NetgsmResponseInterface $response
     */
    public function __construct(ShortMessageCollection $messages, NetgsmResponseInterface $response)
    {
        $this->messages = $messages;
        $this->response = $response;
    }
}
