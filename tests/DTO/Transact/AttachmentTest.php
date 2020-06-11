<?php

namespace Targito\Api\Tests\DTO\Transact;

use GuzzleHttp\Psr7\Stream;
use InvalidArgumentException;
use stdClass;
use Targito\Api\DTO\Transact\Attachment;
use PHPUnit\Framework\TestCase;
use Targito\Api\Exception\TargitoException;

class AttachmentTest extends TestCase
{
    private const BASE64_CONTENT = 'dGVzdA=='; // the string "test" base64 encoded
    private const FILEPATH = __DIR__ . '/../../testFiles/test.txt';

    public function testJsonSerialize()
    {
        $attachmentString = new Attachment(
            'test.txt',
            'text/plain',
            file_get_contents(self::FILEPATH)
        );
        $serialized = $attachmentString->jsonSerialize();
        self::assertEquals('test.txt', $serialized['name']);
        self::assertEquals('text/plain', $serialized['type']);
        self::assertEquals(self::BASE64_CONTENT, $serialized['data']);

        $attachmentPhpStream = new Attachment(
            '',
            '',
            fopen(self::FILEPATH, 'r')
        );
        $serialized = $attachmentPhpStream->jsonSerialize();
        self::assertEquals(self::BASE64_CONTENT, $serialized['data']);

        $attachmentStream = new Attachment(
            '',
            '',
            new Stream(fopen(self::FILEPATH, 'r'))
        );
        $serialized = $attachmentStream->jsonSerialize();
        self::assertEquals(self::BASE64_CONTENT, $serialized['data']);

        // test that types convertible to string work
        $attachmentInt = new Attachment(
            '',
            '',
            1
        );
        $serialized = $attachmentInt->jsonSerialize();
        self::assertEquals('MQ==', $serialized['data']);

        $attachmentFloat = new Attachment(
            '',
            '',
            0.5
        );
        $serialized = $attachmentFloat->jsonSerialize();
        self::assertEquals('MC41', $serialized['data']);

        $attachmentBool = new Attachment(
            '',
            '',
            true
        );
        $serialized = $attachmentBool->jsonSerialize();
        self::assertEquals('MQ==', $serialized['data']);

        $attachmentToString = new Attachment(
            '',
            '',
            new class {
                public function __toString()
                {
                    return 'test';
                }
            }
        );
        $serialized = $attachmentToString->jsonSerialize();
        self::assertEquals(self::BASE64_CONTENT, $serialized['data']);
    }

    public function testNonConvertibleArray()
    {
        $attachment = new Attachment(
            '',
            '',
            []
        );
        $this->expectException(InvalidArgumentException::class);
        $attachment->jsonSerialize();
    }

    public function testNonConvertibleObject()
    {
        $attachment = new Attachment(
            '',
            '',
            new stdClass()
        );
        $this->expectException(InvalidArgumentException::class);
        $attachment->jsonSerialize();
    }

    public function testNonConvertibleNonStreamResource()
    {
        if (!function_exists('imagecreate')) {
            self::markTestSkipped('The function imagecreate must be present for this test');
        }
        $attachment = new Attachment(
            '',
            '',
            imagecreate(100, 100)
        );
        $this->expectException(InvalidArgumentException::class);
        $attachment->jsonSerialize();
    }
}
