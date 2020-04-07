<?php

namespace Targito\Api\Tests\DTO\Request\Contact;

use PHPUnit\Framework\TestCase;
use Targito\Api\DTO\Request\Contact\EditContactRequest;

class EditContactRequestTest extends TestCase
{
    public function testJsonSerialize()
    {
        $instance = new EditContactRequest();
        self::assertArrayHasKey('email', $instance->jsonSerialize());
        self::assertArrayHasKey('origin', $instance->jsonSerialize());
        self::assertArrayNotHasKey('isOptedIn', $instance->jsonSerialize());
        self::assertArrayNotHasKey('consents', $instance->jsonSerialize());
        self::assertArrayNotHasKey('columns', $instance->jsonSerialize());

        $instance->isOptedIn = true;
        $instance->consents = [];
        $instance->columns = [];
        self::assertArrayHasKey('isOptedIn', $instance->jsonSerialize());
        self::assertArrayHasKey('consents', $instance->jsonSerialize());
        self::assertArrayHasKey('columns', $instance->jsonSerialize());
    }
}
