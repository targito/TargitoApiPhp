<?php

namespace Targito\Api\Tests\DTO\Request;

use PHPUnit\Framework\TestCase;
use Targito\Api\DTO\Request\AbstractRequestDTO;

class AbstractRequestDTOTest extends TestCase
{
    /**
     * @var AbstractRequestDTO
     */
    private $instance;

    /**
     * @var string
     */
    private $class;

    protected function setUp(): void
    {
        $this->instance = new class extends AbstractRequestDTO {
            public $testProperty1;
            public $testProperty2;
        };
        $this->class = get_class($this->instance);
    }

    public function testJsonSerialize()
    {
        self::assertArrayHasKey('testProperty1', $this->instance->jsonSerialize());
        self::assertArrayHasKey('testProperty2', $this->instance->jsonSerialize());
    }

    public function testFromArray()
    {
        $instance = $this->class::fromArray([
            'testProperty1' => 'testValue1',
            'testProperty2' => 'testValue2'
        ]);
        self::assertEquals('testValue1', $instance->testProperty1);
        self::assertEquals('testValue2', $instance->testProperty2);

        $this->expectException(\InvalidArgumentException::class);
        $instance = $this->class::fromArray([
            'nonExistentProperty' => 'test'
        ]);
    }
}
