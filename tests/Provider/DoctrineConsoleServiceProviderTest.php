<?php

namespace Sergiors\Silex\Tests\Provider;

use Silex\Application;
use Silex\WebTestCase;
use Silex\Provider\DoctrineServiceProvider;
use Symfony\Component\Console\Application as ConsoleApplication;
use Doctrine\ORM\Tools\Console\Command\InfoCommand;
use Sergiors\Silex\Provider\ConsoleServiceProvider;
use Sergiors\Silex\Provider\DoctrineCacheServiceProvider;
use Sergiors\Silex\Provider\DoctrineOrmServiceProvider;
use Sergiors\Silex\Provider\DoctrineConsoleServiceProvider;

class DoctrineConsoleServiceProviderTest extends WebTestCase
{
    /**
     * @test
     */
    public function register()
    {
        $app = $this->createApplication();
        $app->register(new ConsoleServiceProvider());
        $app->register(new DoctrineServiceProvider());
        $app->register(new DoctrineCacheServiceProvider());
        $app->register(new DoctrineOrmServiceProvider());
        $app->register(new DoctrineConsoleServiceProvider());

        $app['orm.proxy_dir'] = sys_get_temp_dir();
        $app['orm.proxy_namespace'] = 'Acme\Entity';

        $this->assertInstanceOf(ConsoleApplication::class, $app['console']);
        $this->assertInstanceOf(InfoCommand::class, $app['console']->get('orm:info'));
    }

    public function createApplication()
    {
        $app = new Application();
        $app['debug'] = true;
        $app['exception_handler']->disable();

        return $app;
    }
}
