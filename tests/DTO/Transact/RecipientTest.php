<?php

namespace Targito\Api\Tests\DTO\Transact;

use Targito\Api\DTO\Transact\Recipient;
use PHPUnit\Framework\TestCase;

class RecipientTest extends TestCase
{

    public function testJsonSerialize()
    {
        $instance = new Recipient('me@example.com');
        self::assertEquals('me@example.com', $instance->jsonSerialize()['email']);
        self::assertArrayNotHasKey('columns', $instance->jsonSerialize());

        $instance = new Recipient('me@example.com', ['key' => 'value']);
        self::assertEquals('me@example.com', $instance->jsonSerialize()['email']);
        self::assertArrayHasKey('columns', $instance->jsonSerialize());
    }
}
