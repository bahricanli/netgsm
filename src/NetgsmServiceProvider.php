<?php

namespace NotificationChannels\Netgsm;

use GuzzleHttp\Client;
use UnexpectedValueException;
use BahriCanli\Netgsm\Http\Clients;
use BahriCanli\Netgsm\ShortMessage;
use BahriCanli\Netgsm\NetgsmService;
use Illuminate\Support\ServiceProvider;
use BahriCanli\Netgsm\ShortMessageFactory;
use BahriCanli\Netgsm\ShortMessageCollection;
use BahriCanli\Netgsm\ShortMessageCollectionFactory;
use BahriCanli\Netgsm\Http\Responses\NetgsmResponseInterface;

/**
 * Class NetgsmServiceProvider.
 */
class NetgsmServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->registerNetgsmClient();
        $this->registerNetgsmService();
    }

    /**
     * Register the Netgsm Client binding with the container.
     *
     * @return void
     */
    private function registerNetgsmClient()
    {
        $this->app->bind(Clients\NetgsmClientInterface::class, function () {
            $client = null;
            $username = config('services.netgsm.username');
            $password = config('services.netgsm.password');
            $originator = config('services.netgsm.originator');

            switch (config('services.netgsm.client', 'http')) {
                case 'http':
                    $timeout = config('services.Netgsm.timeout');
                    $endpoint = config('services.Netgsm.http.endpoint');
                    $client = new Clients\NetgsmHttpClient(
                        new Client(['timeout' => $timeout]), $endpoint, $username, $password, $originator);
                    break;
                case 'xml':
                    $endpoint = config('services.Netgsm.xml.endpoint');
                    $client = new Clients\NetgsmXmlClient($endpoint, $username, $password, $originator);
                    break;
                default:
                    throw new UnexpectedValueException('Unknown Netgsm API client has been provided.');
            }

            return $client;
        });
    }

    /**
     * Register the Netgsm-sms service.
     */
    private function registerNetgsmService()
    {
        $beforeSingle = function (ShortMessage $shortMessage) {
            event(new Events\SendingMessage($shortMessage));
        };

        $afterSingle = function (NetgsmResponseInterface $response, ShortMessage $shortMessage) {
            event(new Events\MessageWasSent($shortMessage, $response));
        };

        $beforeMany = function (ShortMessageCollection $shortMessages) {
            event(new Events\SendingMessages($shortMessages));
        };

        $afterMany = function (NetgsmResponseInterface $response, ShortMessageCollection $shortMessages) {
            event(new Events\MessagesWereSent($shortMessages, $response));
        };

        $this->app->singleton('netgsm-sms', function ($app) use ($beforeSingle, $afterSingle, $beforeMany, $afterMany) {
            return new NetgsmService(
                $app->make(Clients\NetgsmClientInterface::class),
                new ShortMessageFactory(),
                new ShortMessageCollectionFactory(),
                $beforeSingle,
                $afterSingle,
                $beforeMany,
                $afterMany
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'netgsm-sms',
            Clients\NetgsmClientInterface::class,
        ];
    }
}
