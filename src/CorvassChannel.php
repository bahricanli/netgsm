<?php

namespace NotificationChannels\netgsm;

use BahriCanli\netgsm\ShortMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\netgsm\Exceptions\CouldNotSendNotification;

/**
 * Class netgsmChannel.
 */
final class netgsmChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed                                  $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     * @throws \NotificationChannels\netgsm\Exceptions\CouldNotSendNotification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->tonetgsm($notifiable);

        if ($message instanceof ShortMessage) {
            netgsm::sendShortMessage($message);

            return;
        }

        $to = $notifiable->routeNotificationFor('netgsm');

        if (empty($to)) {
            throw CouldNotSendNotification::missingRecipient();
        }

        netgsm::sendShortMessage($to, $message);
    }
}
