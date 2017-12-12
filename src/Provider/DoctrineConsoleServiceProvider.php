<?php

namespace Sergiors\Pimple\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\DBAL\Tools\Console\Command\ImportCommand;
use Doctrine\DBAL\Tools\Console\Command\ReservedWordsCommand;
use Doctrine\DBAL\Tools\Console\Command\RunSqlCommand;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Doctrine\ORM\Tools\Console\Command\ClearCache\MetadataCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\ResultCommand;
use Doctrine\ORM\Tools\Console\Command\ClearCache\QueryCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand;
use Doctrine\ORM\Tools\Console\Command\EnsureProductionSettingsCommand;
use Doctrine\ORM\Tools\Console\Command\ConvertDoctrine1SchemaCommand;
use Doctrine\ORM\Tools\Console\Command\GenerateRepositoriesCommand;
use Doctrine\ORM\Tools\Console\Command\GenerateEntitiesCommand;
use Doctrine\ORM\Tools\Console\Command\GenerateProxiesCommand;
use Doctrine\ORM\Tools\Console\Command\ConvertMappingCommand;
use Doctrine\ORM\Tools\Console\Command\RunDqlCommand;
use Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand;
use Doctrine\ORM\Tools\Console\Command\InfoCommand;
use Doctrine\ORM\Tools\Console\Command\MappingDescribeCommand;
use Symfony\Component\Console\Application as ConsoleApplication;

/**
 * @author Sérgio Rafael Siqueira <sergio@inbep.com.br>
 */
class DoctrineConsoleServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $container)
    {
        if (!isset($container['console'])) {
            throw new \LogicException(
                'You must register the ConsoleServiceProvider to use the DoctrineConsoleServiceProvider.'
            );
        }

        if (!isset($container['orm'])) {
            throw new \LogicException(
                'You must register the DoctrineOrmServiceProvider to use the DoctrineConsoleServiceProvider.'
            );
        }

        $container['console'] = $container->extend('console', function (ConsoleApplication $console) use ($container) {
            $helper = $console->getHelperSet();
            $helper->set(new ConnectionHelper($container['db']), 'db');
            $helper->set(new EntityManagerHelper($container['orm']), 'em');

            $console->add(new ImportCommand());
            $console->add(new ReservedWordsCommand());
            $console->add(new RunSqlCommand());
            $console->add(new MetadataCommand());
            $console->add(new ResultCommand());
            $console->add(new QueryCommand());
            $console->add(new CreateCommand());
            $console->add(new UpdateCommand());
            $console->add(new DropCommand());
            $console->add(new EnsureProductionSettingsCommand());
            $console->add(new ConvertDoctrine1SchemaCommand());
            $console->add(new GenerateRepositoriesCommand());
            $console->add(new GenerateEntitiesCommand());
            $console->add(new GenerateProxiesCommand());
            $console->add(new ConvertMappingCommand());
            $console->add(new RunDqlCommand());
            $console->add(new ValidateSchemaCommand());
            $console->add(new InfoCommand());
            $console->add(new MappingDescribeCommand());

            return $console;
        });
    }
}
