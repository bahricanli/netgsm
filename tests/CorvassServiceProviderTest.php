<?php

namespace NotificationChannels\netgsm\Test;

use Mockery as M;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Container\ContextualBindingBuilder;
use NotificationChannels\netgsm\netgsmServiceProvider;

class netgsmServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    private $app;
    private $contextualBindingBuilder;

    public function setUp()
    {
        parent::setUp();

        $this->app = M::mock(Application::class);
        $this->contextualBindingBuilder = M::mock(ContextualBindingBuilder::class);
    }

    public function tearDown()
    {
        M::close();

        parent::tearDown();
    }

    /** @test */
    public function it_should_provide_services_on_boot()
    {
        $this->app->shouldReceive('bind')
                  ->once();

        $this->app->shouldReceive('singleton')
            ->once();

        $provider = new netgsmServiceProvider($this->app);

        $provider->boot();
    }
}
