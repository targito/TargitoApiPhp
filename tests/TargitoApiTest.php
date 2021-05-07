<?php

namespace Targito\Api\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use Targito\Api\Credentials\EnvironmentCredentials;
use Targito\Api\Endpoint\AbstractEndpoint;
use Targito\Api\TargitoApi;

class TargitoApiTest extends TestCase
{
    /**
     * @var TargitoApi
     */
    private $instanceDefault;

    /**
     * @var TargitoApi
     */
    private $instanceCustom;

    private $customUrl = 'https://custom.api.targito.com/v1.0';

    protected function setUp(): void
    {
        $this->instanceDefault = new TargitoApi(new EnvironmentCredentials());
        $this->instanceCustom = new TargitoApi(new EnvironmentCredentials(), null, $this->customUrl);
    }

    public function testCustomApiDomain(): void
    {
        $module1 = $this->instanceDefault->contacts();
        $module2 = $this->instanceDefault->transact();
        self::assertEquals('https://api.targito.com/v1.0/contacts/Test', $this->getApiUrl($module1));
        self::assertEquals('https://api.targito.com/v1.0/transact/Test', $this->getApiUrl($module2));

        $module1 = $this->instanceCustom->contacts();
        $module2 = $this->instanceCustom->transact();
        self::assertEquals("{$this->customUrl}/contacts/Test", $this->getApiUrl($module1));
        self::assertEquals("{$this->customUrl}/transact/Test", $this->getApiUrl($module2));
    }

    private function getApiUrl(AbstractEndpoint $instance): string
    {
        $reflection = new ReflectionMethod($instance, 'getApiUrl');
        $reflection->setAccessible(true);

        return $reflection->invoke($instance, 'test');
    }
}
