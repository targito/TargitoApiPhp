<?php

namespace Targito\Api\Tests\DTO\Request\Transact;

use DateTime;
use PHPUnit\Framework\TestCase;
use Targito\Api\DTO\Request\Transact\SendEmailRequest;

class SendEmailRequestTest extends TestCase
{
    public function testJsonSerialize()
    {
        $instance = new SendEmailRequest();
        self::assertArrayHasKey('origin', $instance->jsonSerialize());
        self::assertArrayHasKey('email', $instance->jsonSerialize());
        self::assertArrayHasKey('mailingId', $instance->jsonSerialize());
        self::assertArrayNotHasKey('fromName', $instance->jsonSerialize());
        self::assertArrayNotHasKey('fromEmail', $instance->jsonSerialize());
        self::assertArrayNotHasKey('replyTo', $instance->jsonSerialize());
        self::assertArrayNotHasKey('sendDateTime', $instance->jsonSerialize());
        self::assertArrayNotHasKey('columns', $instance->jsonSerialize());

        $instance->fromName = 'Me';
        $instance->fromEmail = 'me@example.com';
        $instance->replyTo = 'me@example.com';
        $instance->sendDateTime = new DateTime();
        $instance->columns = [];
        self::assertArrayHasKey('fromName', $instance->jsonSerialize());
        self::assertArrayHasKey('fromEmail', $instance->jsonSerialize());
        self::assertArrayHasKey('replyTo', $instance->jsonSerialize());
        self::assertArrayHasKey('sendDateTime', $instance->jsonSerialize());
        self::assertArrayHasKey('columns', $instance->jsonSerialize());
        self::assertIsString($instance->jsonSerialize()['sendDateTime']);
    }
}
