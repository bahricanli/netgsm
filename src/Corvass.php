<?php

namespace NotificationChannels\netgsm;

use Illuminate\Support\Facades\Facade;
use BahriCanli\netgsm\Http\Responses\netgsmResponseInterface;

/**
 * Class netgsm.
 *
 * @method static netgsmResponseInterface sendShortMessage(array|string $receivers, string|null $body = null)
 * @method static netgsmResponseInterface sendShortMessages(array $messages)
 */
class netgsm extends Facade
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
