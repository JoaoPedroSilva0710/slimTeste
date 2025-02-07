<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\TelegramBotHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            global $env;
            
            $settings = $c->get(SettingsInterface::class);

            $loggerSettings = $settings->get('logger');
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            // $emailHandler = new StreamHandler($loggerSettings['path'], $loggerSettings['levelWarning']);
            // $logger->pushHandler($emailHandler);

            $telegramApiKey = $env['telegram']['apiKey'];
            $telegramChannel = $env['telegram']['channel'];

            $telegramHandler = new TelegramBotHandler($telegramApiKey, $telegramChannel, $loggerSettings['levelCritical']);
            $telegramHandler->setFormatter(new LineFormatter("%level_name% : %message%"));

            $logger->pushHandler($telegramHandler);
            
            return $logger;
        },
    ]);
};
