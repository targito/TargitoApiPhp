<?php

namespace Targito\Api\Tests\DTO\Request\Contact;

use PHPUnit\Framework\TestCase;
use Targito\Api\DTO\Request\Contact\AddContactRequest;

class AddContactRequestTest extends TestCase
{
    public function testJsonSerialize()
    {
        $instance = new AddContactRequest();
        self::assertArrayHasKey('email', $instance->jsonSerialize());
        self::assertArrayHasKey('origin', $instance->jsonSerialize());
        self::assertArrayHasKey('isOptedIn', $instance->jsonSerialize());
        self::assertArrayNotHasKey('forbidReOptIn', $instance->jsonSerialize());
        self::assertArrayNotHasKey('consents', $instance->jsonSerialize());
        self::assertArrayNotHasKey('columns', $instance->jsonSerialize());

        $instance->forbidReOptIn = true;
        $instance->consents = [];
        $instance->columns = [];
        self::assertArrayHasKey('forbidReOptIn', $instance->jsonSerialize());
        self::assertArrayHasKey('consents', $instance->jsonSerialize());
        self::assertArrayHasKey('columns', $instance->jsonSerialize());
    }
}
