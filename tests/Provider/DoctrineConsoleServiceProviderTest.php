<?php

namespace Sergiors\Pimple\Tests\Provider;

use Pimple\Container;
use Silex\Provider\DoctrineServiceProvider;
use Symfony\Component\Console\Application;
use Doctrine\ORM\Tools\Console\Command\InfoCommand;
use Sergiors\Pimple\Provider\DoctrineCacheServiceProvider;
use Sergiors\Pimple\Provider\DoctrineOrmServiceProvider;
use Sergiors\Pimple\Provider\DoctrineConsoleServiceProvider;

class DoctrineConsoleServiceProviderTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function register()
    {
        $container = new Container();
        $container['console'] = function () {
            return new Application();
        };
        $container->register(new DoctrineServiceProvider());
        $container->register(new DoctrineCacheServiceProvider());
        $container->register(new DoctrineOrmServiceProvider());
        $container->register(new DoctrineConsoleServiceProvider());

        $container['orm.proxy_dir'] = sys_get_temp_dir();
        $container['orm.proxy_namespace'] = 'Acme\Entity';

        $this->assertInstanceOf(Application::class, $container['console']);
        $this->assertInstanceOf(InfoCommand::class, $container['console']->get('orm:info'));
    }
}
