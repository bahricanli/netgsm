<?php

namespace NotificationChannels\Corvass;

use Illuminate\Support\Facades\Facade;
use BahriCanli\Corvass\Http\Responses\CorvassResponseInterface;

/**
 * Class Corvass.
 *
 * @method static CorvassResponseInterface sendShortMessage(array|string $receivers, string|null $body = null)
 * @method static CorvassResponseInterface sendShortMessages(array $messages)
 */
class Corvass extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'corvass-sms';
    }
}
