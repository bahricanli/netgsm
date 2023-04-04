<?php

namespace NotificationChannels\Netgsm;

use Illuminate\Support\Facades\Facade;
use BahriCanli\Netgsm\Http\Responses\NetgsmResponseInterface;

/**
 * Class Netgsm.
 *
 * @method static NetgsmResponseInterface sendShortMessage(array|string $receivers, string|null $body = null)
 * @method static NetgsmResponseInterface sendShortMessages(array $messages)
 */
class Netgsm extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'netgsm-sms';
    }
}
