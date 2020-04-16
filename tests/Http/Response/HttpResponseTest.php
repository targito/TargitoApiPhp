<?php

namespace Targito\Api\Tests\Http\Response;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Targito\Api\Http\Response\HttpResponse;

class HttpResponseTest extends TestCase
{
    public function testHttpResponse()
    {
        $validJsonData = json_encode(['key' => 'value', 'key2' => ['value3', 'value4']]);
        $invalidJsonData = '{"test":true';

        $validInstance = new HttpResponse($validJsonData);
        $invalidInstance = new HttpResponse($invalidJsonData);

        self::assertEquals($validJsonData, $validInstance->getBody());
        self::assertEquals($invalidJsonData, $invalidInstance->getBody());

        self::assertIsArray($validInstance->getJsonBody());
        self::assertArrayHasKey('key', $validInstance->getJsonBody());
        self::assertArrayHasKey('key2', $validInstance->getJsonBody());
        self::assertEquals('value', $validInstance->getJsonBody()['key']);
        self::assertIsArray($validInstance->getJsonBody()['key2']);
        self::assertEquals('value3', $validInstance->getJsonBody()['key2'][0]);
        self::assertEquals('value4', $validInstance->getJsonBody()['key2'][1]);

        $this->expectException(RuntimeException::class);
        $invalidInstance->getJsonBody();
    }
}
