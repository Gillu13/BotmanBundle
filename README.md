BotManBundle
================

Use this bundle if you want to integrate [BotMan](https://botman.io/) in your Symfony (>=3.4 <5.0) projects.

Currently it is very basic bundle but this is an ongoing work so stay tuned!

It is inspired by [Sergio Gomez BotMan symfony bundle](https://github.com/sgomez/botman-bundle) since it uses the idea of configuring Symfony's services container in the BotMan instance. All the rest is different.

# Installation

## Step 1: Download BotManBundle

***Using Composer***

Run the following command:

```bash
composer require gasciences/botman-bundle
```

## Step 2: Enable the bundle (only if you do not use Flex)

Enable the bundle in your `app/AppKernel.php`:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = [
        // ...
        new GAS\BotmanBundle\GASBotmanBundle(),
    ];
}
```

# Usage

Usage is similar to what you can read in [BotMan official doc](https://botman.io/2.0/installation#basic-usage-without-botman-studio) except that you do not have to instantiate a BotMan object since you can get it from Symfony's services container as in the following Controller example:

```php
<?php
// src/Controller/BotController.php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use BotMan\BotMan\BotMan;

class BotController extends AbstractController{

    /**
     * @Route("/chatbot", name="chatbot")
     */
    function chatbotAction(Request $request)
    {
        // get a BotMan instance from Symfony's service container
        $botman = $this->container->get('gas_botman.botman');
        
        //your logic here, for e.g the following statements
        $botman->hears('(hello|hi|hey)', function (BotMan $bot) {
            $bot->reply('Hello');
        });

        $botman->fallback(function (BotMan $bot) {
            $bot->typesAndWaits(2);
            $bot->reply("Sorry I dd not understand your request");
        });

        $botman->listen();

        return new Response();
    }
}
```

# License

The MIT License (MIT).
