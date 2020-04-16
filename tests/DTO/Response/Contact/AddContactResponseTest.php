<?php

namespace Targito\Api\Tests\DTO\Response\Contact;

use Targito\Api\DTO\Response\Contact\AddContactResponse;
use Targito\Api\Tests\AbstractResponseTest;

class AddContactResponseTest extends AbstractResponseTest
{
    public function testResponse()
    {
        $httpResponse = $this->createMockHttpResponse([
            'id' => 'test',
            'isOptedIn' => true,
            'isOptedOut' => false,
        ]);

        $instance = new AddContactResponse($httpResponse);
        self::assertEquals('test', $instance->id);
        self::assertTrue($instance->isOptedIn);
        self::assertFalse($instance->isOptedOut);
        self::assertTrue($instance->isNew);
        self::assertNull($instance->previousState);
    }

    public function testResponseWithHistory()
    {
        $httpResponse = $this->createMockHttpResponse([
            '_history' => [
                'isOptedIn' => false,
                'isOptedOut' => true,
            ],
            'id' => 'test',
            'isOptedIn' => true,
            'isOptedOut' => false,
        ]);
        $instance = new AddContactResponse($httpResponse);

        self::assertEquals('test', $instance->id);
        self::assertTrue($instance->isOptedIn);
        self::assertFalse($instance->isOptedOut);
        self::assertFalse($instance->isNew);
        self::assertNotNull($instance->previousState);

        self::assertFalse($instance->previousState->isOptedIn);
        self::assertTrue($instance->previousState->isOptedOut);
    }
}
