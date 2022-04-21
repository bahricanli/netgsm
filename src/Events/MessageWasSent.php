<?php

namespace NotificationChannels\Corvass\Events;

use BahriCanli\Corvass\ShortMessage;
use BahriCanli\Corvass\Http\Responses\CorvassResponseInterface;

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
     * @var CorvassResponseInterface
     */
    public $response;

    /**
     * MessageWasSent constructor.
     *
     * @param ShortMessage            $message
     * @param CorvassResponseInterface $response
     */
    public function __construct(ShortMessage $message, CorvassResponseInterface $response)
    {
        $this->message = $message;
        $this->response = $response;
    }
}
