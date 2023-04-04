# netgsm Notification Channel For Laravel 5.3

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bahricanli/netgsm.svg?style=flat-square)](https://packagist.org/packages/bahricanli/netgsm)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/bahricanli/netgsm/master.svg?style=flat-square)](https://travis-ci.org/bahricanli/netgsm)
[![StyleCI](https://styleci.io/repos/74304440/shield?branch=master)](https://styleci.io/repos/74304440)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/ce5f111f-1be4-4848-a87d-7b2570d153d4.svg?style=flat-square)](https://insight.sensiolabs.com/projects/ce5f111f-1be4-4848-a87d-7b2570d153d4)
[![Quality Score](https://img.shields.io/scrutinizer/g/bahricanli/netgsm.svg?style=flat-square)](https://scrutinizer-ci.com/g/bahricanli/netgsm)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/bahricanli/netgsm/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/bahricanli/netgsm/?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/bahricanli/netgsm.svg?style=flat-square)](https://packagist.org/packages/bahricanli/netgsm)

This package makes it easy to send notifications using [netgsm](http://www.netgsm.com) with Laravel 5.3.

## Contents

- [Installation](#installation)
    - [Setting up the netgsm service](#setting-up-the-netgsm-service)
- [Usage](#usage)
    - [Available methods](#available-methods)
    - [Available events](#available-events)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install this package via composer:

``` bash
composer require bahricanli/netgsm
```

Next add the service provider to your `config/app.php`:

```php
/*
 * Package Service Providers...
 */

NotificationChannels\netgsm\netgsmServiceProvider::class,
```

Register the netgsm alias to your application.
This registration is not optional because the channel itself uses this very alias.

```php
'netgsm' => NotificationChannels\netgsm\netgsm::class,
```

### Setting up the netgsm service

Add your desired client, username, password, originator (outbox name, sender name) and request timeout
configuration to your `config/services.php` file:
                                                                     
```php
...
    'netgsm' => [
        'client'     => 'http', // or xml
        'http'       => [
            'endpoint' => 'https://service.jetsms.com.tr/SMS-Web/HttpSmsSend',
        ],
        'xml'        => [
            'endpoint' => 'www.biotekno.biz:8080/SMS-Web/xmlsms',
        ],
        'username'   => '',
        'password'   => '',
        'originator' => "", // Sender name.
        'timeout'    => 60,
    ],
...
```

## Usage

Now you can use the channel in your via() method inside the notification:

```php
use NotificationChannels\netgsm\netgsmChannel;
use NotificationChannels\netgsm\netgsmMessage;

class ResetPasswordWasRequested extends Notification
{
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [netgsmChannel::class];
    }
    
    /**
     * Get the netgsm representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return string|\NotificationChannels\netgsm\netgsmMessage
     */
    public function tonetgsm($notifiable) {
        return "Test notification";
        // Or
        return new ShortMessage($notifiable->phone_number, 'Test notification');
    }
}
```

Don't forget to place the dedicated method for netgsm inside your notifiables. (e.g. User)

```php
class User extends Authenticatable
{
    use Notifiable;
    
    public function routeNotificationFornetgsm()
    {
        return "905123456789";
    }
}
```

### Available methods

netgsm can also be used directly to send short messages.

Examples:
```php
netgsm::sendShortMessage($to, $message);
netgsm::sendShortMessages([[
    'recipient' => $to,
    'message'   => $message,
], [
    'recipient' => $anotherTo,
    'message'   => $anotherMessage,
]]);
```

see: [netgsm-php](https://github.com/erdemkeren/netgsm-php) documentation for more information.

### Available events

netgsm Notification channel comes with handy events which provides the required information about the SMS messages.

1. **Message Was Sent** (`NotificationChannels\netgsm\Events\MessageWasSent`)
2. **Messages Were Sent** (`NotificationChannels\netgsm\Events\MessageWasSent`)
3. **Sending Message** (`NotificationChannels\netgsm\Events\SendingMessage`)
4. **Sending Messages** (`NotificationChannels\netgsm\Events\SendingMessages`)

Example:

```php
namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\netgsm\Events\MessageWasSent;

class SentMessageHandler
{
    /**
     * Handle the event.
     *
     * @param  MessageWasSent  $event
     * @return void
     */
    public function handle(MessageWasSent $event)
    {
        $response = $event->response;
        $message = $event->message;
    }
}
```

### Notes

$response->groupId() will throw BadMethodCallException if the client is set to 'http'. 
$response->messageReportIdentifiers() will throw BadMethodCallException if the client is set to 'xml'.

change client configuration with caution.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email bahri@bahri.info instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Bahri Meriç Canlı](https://github.com/bahricanli)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
