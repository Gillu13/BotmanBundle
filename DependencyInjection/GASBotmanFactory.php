<?php

namespace GAS\BotmanBundle\DependencyInjection;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory as BaseBotManFactory;
use BotMan\BotMan\Cache\SymfonyCache;
use BotMan\BotMan\Drivers\DriverManager;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class GASBotmanFactory
{
    public static function create(ContainerInterface $container, AdapterInterface $filesystemAdapter, RequestStack $requestStack): BotMan
    {
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);
        $config = [];

        $cache = new SymfonyCache($filesystemAdapter);
        $request = $requestStack->getCurrentRequest();

        $botman = BaseBotManFactory::create($config, $cache, $request);
        $botman->setContainer($container);

        return $botman;
    }
}
