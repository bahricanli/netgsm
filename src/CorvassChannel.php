<?php

namespace NotificationChannels\Corvass;

use BahriCanli\Corvass\ShortMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Corvass\Exceptions\CouldNotSendNotification;

/**
 * Class CorvassChannel.
 */
final class CorvassChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed                                  $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     * @throws \NotificationChannels\Corvass\Exceptions\CouldNotSendNotification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toCorvass($notifiable);

        if ($message instanceof ShortMessage) {
            Corvass::sendShortMessage($message);

            return;
        }

        $to = $notifiable->routeNotificationFor('Corvass');

        if (empty($to)) {
            throw CouldNotSendNotification::missingRecipient();
        }

        Corvass::sendShortMessage($to, $message);
    }
}
