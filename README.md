Doctrine Console Service Provider
---------------------------------

To see the complete documentation, check out [Doctrine Console](http://doctrine-orm.readthedocs.org/projects/doctrine-orm/en/latest/reference/tools.html)

Install
-------
```bash
composer require sergiors/doctrine-console-service-provider "dev-master"
```

How to use
----------
Create your console file:

```php
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Sergiors\Silex\Provider\DoctrineCacheServiceProvider;
use Sergiors\Silex\Provider\DoctrineOrmServiceProvider;
use Sergiors\Silex\Provider\ConsoleServiceProvider;
use Sergiors\Silex\Provider\DoctrineConsoleServiceProvider;

$app = new Application();
$app->register(new ConsoleServiceProvider());
$app->register(new DoctrineServiceProvider());
$app->register(new DoctrineCacheServiceProvider());
$app->register(new DoctrineOrmServiceProvider());
$app->register(new DoctrineConsoleServiceProvider());

$app->boot();

$app['console']->run();
```

```bash
php console
```

Be happy!

License
-------
MIT
