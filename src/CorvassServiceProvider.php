<?php

namespace NotificationChannels\Corvass;

use GuzzleHttp\Client;
use UnexpectedValueException;
use BahriCanli\Corvass\Http\Clients;
use BahriCanli\Corvass\ShortMessage;
use BahriCanli\Corvass\CorvassService;
use Illuminate\Support\ServiceProvider;
use BahriCanli\Corvass\ShortMessageFactory;
use BahriCanli\Corvass\ShortMessageCollection;
use BahriCanli\Corvass\ShortMessageCollectionFactory;
use BahriCanli\Corvass\Http\Responses\CorvassResponseInterface;

/**
 * Class CorvassServiceProvider.
 */
class CorvassServiceProvider extends ServiceProvider
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
        $this->registerCorvassClient();
        $this->registerCorvassService();
    }

    /**
     * Register the Corvass Client binding with the container.
     *
     * @return void
     */
    private function registerCorvassClient()
    {
        $this->app->bind(Clients\CorvassClientInterface::class, function () {
            $client = null;
            $username = config('services.Corvass.username');
            $password = config('services.Corvass.password');
            $originator = config('services.Corvass.originator');

            switch (config('services.Corvass.client', 'http')) {
                case 'http':
                    $timeout = config('services.Corvass.timeout');
                    $endpoint = config('services.Corvass.http.endpoint');
                    $client = new Clients\CorvassHttpClient(
                        new Client(['timeout' => $timeout]), $endpoint, $username, $password, $originator);
                    break;
                case 'xml':
                    $endpoint = config('services.Corvass.xml.endpoint');
                    $client = new Clients\CorvassXmlClient($endpoint, $username, $password, $originator);
                    break;
                default:
                    throw new UnexpectedValueException('Unknown Corvass API client has been provided.');
            }

            return $client;
        });
    }

    /**
     * Register the corvass-sms service.
     */
    private function registerCorvassService()
    {
        $beforeSingle = function (ShortMessage $shortMessage) {
            event(new Events\SendingMessage($shortMessage));
        };

        $afterSingle = function (CorvassResponseInterface $response, ShortMessage $shortMessage) {
            event(new Events\MessageWasSent($shortMessage, $response));
        };

        $beforeMany = function (ShortMessageCollection $shortMessages) {
            event(new Events\SendingMessages($shortMessages));
        };

        $afterMany = function (CorvassResponseInterface $response, ShortMessageCollection $shortMessages) {
            event(new Events\MessagesWereSent($shortMessages, $response));
        };

        $this->app->singleton('corvass', function ($app) use ($beforeSingle, $afterSingle, $beforeMany, $afterMany) {
            return new CorvassService(
                $app->make(Clients\CorvassClientInterface::class),
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
            'corvass',
            Clients\CorvassClientInterface::class,
        ];
    }
}
