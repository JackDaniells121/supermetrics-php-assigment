<?php

declare(strict_types = 1);

namespace Tests\unit;

use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use SocialPost\Driver\Factory\FictionalDriverFactory;
use Dotenv\Dotenv;

/**
 * Class ATestTest
 *
 * @package Tests\unit
 */
class ApiConnectionTest extends TestCase
{
    /**
     * @test
     */
    public function testApiConnection(): void
    {
        $dotEnv = Dotenv::createImmutable(__DIR__ . '/../..');
        $dotEnv->load();

        $factory = new FictionalDriverFactory();
        $driver = $factory->create();
//        $accessToken = $driver->getAccessToken(); //  Protected method

        $method = new ReflectionMethod('SocialPost\Driver\FictionalDriver', 'getAccessToken');
        $method->setAccessible(true);

        try {
            $accessToken = $method->invoke($driver);
        } catch (\Exception $exception) {
            $accessToken = null;
        }

        $this->assertNotNull($accessToken);
    }
}
