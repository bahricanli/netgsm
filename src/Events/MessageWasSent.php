<?php

namespace NotificationChannels\netgsm\Events;

use BahriCanli\netgsm\ShortMessage;
use BahriCanli\netgsm\Http\Responses\netgsmResponseInterface;

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
     * @var netgsmResponseInterface
     */
    public $response;

    /**
     * MessageWasSent constructor.
     *
     * @param ShortMessage            $message
     * @param netgsmResponseInterface $response
     */
    public function __construct(ShortMessage $message, netgsmResponseInterface $response)
    {
        $this->message = $message;
        $this->response = $response;
    }
}
