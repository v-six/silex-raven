<?php

namespace SilexRaven;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Simple Raven Service Provider for Silex PHP micro-framework
 * @Author  Kévin Bargoin <kevin.bargoin@gmail.com>
 * @Created 08/04/2014 at 12:45
 * @Package RavenServiceProvider.php
 */
class RavenServiceProvider implements ServiceProviderInterface
{

    /**
     * Provider registration in silex application
     *
     * @param Application $app The silex application
     *
     * @throws \InvalidArgumentException
     */
    public function register(Application $app)
    {
        $app['raven'] = $app->share(
            function () use ($app) {
                $dsn = (isset($app['raven.dsn'])) ? $app['raven.dsn'] : '';
                $options = (isset($app['raven.options'])) ? $app['raven.options'] : array(
                    'logger' => 'silex-raven'
                );

                $client = new \Raven_Client($dsn, $options);

                $errorHandler = new \Raven_ErrorHandler($client);
                if (isset($app['raven.handle'])) {
                    // Register exception handler
                    if (!isset($app['raven.handle']['exceptions']) || $app['raven.handle']['exceptions']) {
                        $errorHandler->registerExceptionHandler();
                    }
                    // Register error handler
                    if (!isset($app['raven.handle']['errors']) || $app['raven.handle']['errors']) {
                        $errorHandler->registerErrorHandler();
                    }
                    // Register shutdown function (to catch fatal errors)
                    if (!isset($app['raven.handle']['fatal_errors']) || $app['raven.handle']['fatal_errors']) {
                        $errorHandler->registerShutdownFunction();
                    }
                }

                return $client;
            }
        );
    }

    /**
     * Provider bootup method
     *
     * @param Application $app The silex application
     */
    public function boot(Application $app)
    {

    }

} 