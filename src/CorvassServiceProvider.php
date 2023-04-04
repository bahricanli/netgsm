<?php

namespace NotificationChannels\netgsm;

use GuzzleHttp\Client;
use UnexpectedValueException;
use BahriCanli\netgsm\Http\Clients;
use BahriCanli\netgsm\ShortMessage;
use BahriCanli\netgsm\netgsmService;
use Illuminate\Support\ServiceProvider;
use BahriCanli\netgsm\ShortMessageFactory;
use BahriCanli\netgsm\ShortMessageCollection;
use BahriCanli\netgsm\ShortMessageCollectionFactory;
use BahriCanli\netgsm\Http\Responses\netgsmResponseInterface;

/**
 * Class netgsmServiceProvider.
 */
class netgsmServiceProvider extends ServiceProvider
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
        $this->registernetgsmClient();
        $this->registernetgsmService();
    }

    /**
     * Register the netgsm Client binding with the container.
     *
     * @return void
     */
    private function registernetgsmClient()
    {
        $this->app->bind(Clients\netgsmClientInterface::class, function () {
            $client = null;
            $username = config('services.netgsm.username');
            $password = config('services.netgsm.password');
            $originator = config('services.netgsm.originator');

            switch (config('services.netgsm.client', 'http')) {
                case 'http':
                    $timeout = config('services.netgsm.timeout');
                    $endpoint = config('services.netgsm.http.endpoint');
                    $client = new Clients\netgsmHttpClient(
                        new Client(['timeout' => $timeout]), $endpoint, $username, $password, $originator);
                    break;
                case 'xml':
                    $endpoint = config('services.netgsm.xml.endpoint');
                    $client = new Clients\netgsmXmlClient($endpoint, $username, $password, $originator);
                    break;
                default:
                    throw new UnexpectedValueException('Unknown netgsm API client has been provided.');
            }

            return $client;
        });
    }

    /**
     * Register the netgsm-sms service.
     */
    private function registernetgsmService()
    {
        $beforeSingle = function (ShortMessage $shortMessage) {
            event(new Events\SendingMessage($shortMessage));
        };

        $afterSingle = function (netgsmResponseInterface $response, ShortMessage $shortMessage) {
            event(new Events\MessageWasSent($shortMessage, $response));
        };

        $beforeMany = function (ShortMessageCollection $shortMessages) {
            event(new Events\SendingMessages($shortMessages));
        };

        $afterMany = function (netgsmResponseInterface $response, ShortMessageCollection $shortMessages) {
            event(new Events\MessagesWereSent($shortMessages, $response));
        };

        $this->app->singleton('netgsm-sms', function ($app) use ($beforeSingle, $afterSingle, $beforeMany, $afterMany) {
            return new netgsmService(
                $app->make(Clients\netgsmClientInterface::class),
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
            Clients\netgsmClientInterface::class,
        ];
    }
}
