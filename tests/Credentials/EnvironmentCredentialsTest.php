<?php

namespace Targito\Api\Tests\Credentials;

use PHPUnit\Framework\TestCase;
use Targito\Api\Credentials\EnvironmentCredentials;
use Targito\Api\Exception\TargitoException;

class EnvironmentCredentialsTest extends TestCase
{
    /**
     * @var EnvironmentCredentials
     */
    private $instance;

    protected function setUp(): void
    {
        $this->instance = new EnvironmentCredentials();
    }

    public function testCustomEnvironmentCredentials()
    {
        $accountIdEnv = 'CUSTOM_TARGITO_ACCOUNT_ID';
        $apiPasswordEnv = 'CUSTOM_TARGITO_API_PASSWORD';
        putenv("${accountIdEnv}=test1");
        putenv("${apiPasswordEnv}=test2");

        $instance = new EnvironmentCredentials($accountIdEnv, $apiPasswordEnv);

        self::assertEquals('test1', $instance->getAccountId());
        self::assertEquals('test2', $instance->getApiPassword());
    }

    public function testMissingCredentialsAccountId()
    {
        $this->expectException(TargitoException::class);
        $this->instance->getAccountId();
    }

    public function testMissingCredentialsApiPassword()
    {
        $this->expectException(TargitoException::class);
        $this->instance->getApiPassword();
    }

    public function testEnvironmentCredentials()
    {
        putenv('TARGITO_ACCOUNT_ID=test1');
        putenv('TARGITO_API_PASSWORD=test2');

        self::assertEquals('test1', $this->instance->getAccountId());
        self::assertEquals('test2', $this->instance->getApiPassword());
    }
}
