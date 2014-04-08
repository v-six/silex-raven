<?php

namespace SilexRaven\Tests;

use Silex\Application;
use SilexRaven\RavenServiceProvider;

/**
 * Test for Raven provider for Silex framework
 * @Author  Kévin Bargoin <kb@4x.fr>
 * @Created 08/04/2014 at 15:19
 * @Package RavenServiceProviderTest.php
 */
class RavenServiceProviderTest extends \PHPUnit_Framework_TestCase
{

    public function testInitializer()
    {
        $app = new Application();
        $app->register(
            new RavenServiceProvider(),
            array(
                'raven.dsn' => 'http://public:secret@example.com/1',
                'raven.handle.exceptions' => false
            )
        );

        $this->assertInstanceOf('\Raven_Client', $app['raven']);
    }

} 