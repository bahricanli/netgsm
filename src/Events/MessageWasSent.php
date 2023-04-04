<?php

namespace NotificationChannels\Netgsm\Events;

use BahriCanli\Netgsm\ShortMessage;
use BahriCanli\Netgsm\Http\Responses\NetgsmResponseInterface;

/**
 * Class MessageWasSent.
 */
class MessageWasSent
{
    /**
     * The sms message.
     *
     * @var ShortMessage
     */
    public $message;

    /**
     * The Api response implementation.
     *
     * @var NetgsmResponseInterface
     */
    public $response;

    /**
     * MessageWasSent constructor.
     *
     * @param ShortMessage            $message
     * @param NetgsmResponseInterface $response
     */
    public function __construct(ShortMessage $message, NetgsmResponseInterface $response)
    {
        $this->message = $message;
        $this->response = $response;
    }
}
