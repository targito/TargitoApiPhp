<?php

namespace Targito\Api\Tests\DTO\Request\Transact;

use DateTime;
use PHPUnit\Framework\TestCase;
use Targito\Api\DTO\Request\Transact\SendMassEmailRequest;
use Targito\Api\DTO\Transact\Recipient;

class SendMassEmailRequestTest extends TestCase
{
    public function testJsonSerialize()
    {
        $instance = new SendMassEmailRequest();
        self::assertArrayHasKey('origin', $instance->jsonSerialize());
        self::assertArrayHasKey('recipients', $instance->jsonSerialize());
        self::assertArrayHasKey('mailingId', $instance->jsonSerialize());
        self::assertArrayNotHasKey('fromName', $instance->jsonSerialize());
        self::assertArrayNotHasKey('fromEmail', $instance->jsonSerialize());
        self::assertArrayNotHasKey('replyTo', $instance->jsonSerialize());
        self::assertArrayNotHasKey('sendDateTime', $instance->jsonSerialize());

        $instance->fromName = 'Me';
        $instance->fromEmail = 'me@example.com';
        $instance->replyTo = 'me@example.com';
        $instance->sendDateTime = new DateTime();
        $instance->recipients = [
            new Recipient('me@example.com', ['someVariable' => 'someValue']),
        ];

        $serialized = json_decode(json_encode($instance), true);
        self::assertArrayHasKey('fromName', $serialized);
        self::assertArrayHasKey('fromEmail', $serialized);
        self::assertArrayHasKey('replyTo', $serialized);
        self::assertArrayHasKey('sendDateTime', $serialized);
        self::assertIsString($serialized['sendDateTime']);
        self::assertIsArray($serialized['recipients'][0]);
        self::assertArrayHasKey('someVariable', $serialized['recipients'][0]['columns']);
    }
}
