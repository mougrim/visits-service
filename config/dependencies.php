<?php

declare(strict_types=1);

namespace Mougrim\VisitsService\config;

use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Level as LoggerLevel;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Predis\Client as RedisClient;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $logger = new Logger('visits-service');

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler(__DIR__ . '/../log/app.log', LoggerLevel::Info);
            $logger->pushHandler($handler);

            return $logger;
        },
        RedisClient::class => function (ContainerInterface $c) {
            return new RedisClient();
        },
    ]);
};
