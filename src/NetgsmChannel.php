<?php

namespace NotificationChannels\Netgsm;

use BahriCanli\Netgsm\ShortMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Netgsm\Exceptions\CouldNotSendNotification;

/**
 * Class NetgsmChannel.
 */
final class NetgsmChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed                                  $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     * @throws \NotificationChannels\Netgsm\Exceptions\CouldNotSendNotification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toNetgsm($notifiable);

        if ($message instanceof ShortMessage) {
            Netgsm::sendShortMessage($message);

            return;
        }

        $to = $notifiable->routeNotificationFor('netgsm');

        if (empty($to)) {
            throw CouldNotSendNotification::missingRecipient();
        }

        Netgsm::sendShortMessage($to, $message);
    }
}
