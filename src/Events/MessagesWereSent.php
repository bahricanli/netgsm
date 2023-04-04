<?php

namespace NotificationChannels\netgsm\Events;

use BahriCanli\netgsm\ShortMessageCollection;
use BahriCanli\netgsm\Http\Responses\netgsmResponseInterface;

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
     * @var netgsmResponseInterface
     */
    public $response;

    /**
     * MessageWasSent constructor.
     *
     * @param ShortMessageCollection  $messages
     * @param netgsmResponseInterface $response
     */
    public function __construct(ShortMessageCollection $messages, netgsmResponseInterface $response)
    {
        $this->messages = $messages;
        $this->response = $response;
    }
}
