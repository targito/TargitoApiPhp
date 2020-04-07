<?php

namespace Targito\Api\Tests\Credentials;

use PHPUnit\Framework\TestCase;
use Targito\Api\Credentials\EnvironmentCredentials;

class EnvironmentCredentialsTest extends TestCase
{
    public function testEnvironmentCredentials()
    {
        putenv('TARGITO_ACCOUNT_ID=test1');
        putenv('TARGITO_API_PASSWORD=test2');
        $instance = new EnvironmentCredentials();

        self::assertEquals('test1', $instance->getAccountId());
        self::assertEquals('test2', $instance->getApiPassword());
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
}
