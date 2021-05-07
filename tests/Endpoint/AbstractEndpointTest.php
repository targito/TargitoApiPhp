<?php

namespace Targito\Api\Tests\Endpoint;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use Targito\Api\Credentials\EnvironmentCredentials;
use Targito\Api\DTO\Request\AbstractRequestDTO;
use Targito\Api\Endpoint\AbstractEndpoint;
use Targito\Api\Http\Request\CurlHttpRequest;

class AbstractEndpointTest extends TestCase
{
    /**
     * @var AbstractEndpoint
     */
    private $instance;

    protected function setUp(): void
    {
        $this->instance = new class(new EnvironmentCredentials(), new CurlHttpRequest()) extends AbstractEndpoint {
            protected function getApiModule(): string
            {
                return 'test';
            }

            public function getExceptionForMissingRequiredData($data, array $required): ?InvalidArgumentException
            {
                return parent::getExceptionForMissingRequiredData($data, $required);
            }
        };
    }

    /**
     * @see https://github.com/targito/TargitoApiPhp/issues/2
     */
    public function testGetExceptionForMissingRequiredData()
    {
        $required = ['prop1', 'prop2'];

        self::assertInstanceOf(
            InvalidArgumentException::class,
            $this->instance->getExceptionForMissingRequiredData([], $required)
        );
        self::assertInstanceOf(
            InvalidArgumentException::class,
            $this->instance->getExceptionForMissingRequiredData($this->createDto([]), $required)
        );

        self::assertInstanceOf(
            InvalidArgumentException::class,
            $this->instance->getExceptionForMissingRequiredData([
                'prop1' => 'test',
            ], $required)
        );
        self::assertInstanceOf(
            InvalidArgumentException::class,
            $this->instance->getExceptionForMissingRequiredData($this->createDto([
                'prop1' => 'test',
            ]), $required)
        );

        self::assertInstanceOf(
            InvalidArgumentException::class,
            $this->instance->getExceptionForMissingRequiredData([
                'prop2' => 'test',
            ], $required)
        );
        self::assertInstanceOf(
            InvalidArgumentException::class,
            $this->instance->getExceptionForMissingRequiredData($this->createDto([
                'prop2' => 'test',
            ]), $required)
        );

        self::assertInstanceOf(
            InvalidArgumentException::class,
            $this->instance->getExceptionForMissingRequiredData([
                'prop1' => null,
                'prop2' => null,
            ], $required)
        );
        self::assertInstanceOf(
            InvalidArgumentException::class,
            $this->instance->getExceptionForMissingRequiredData($this->createDto([
                'prop1' => null,
                'prop2' => null,
            ]), $required)
        );

        self::assertNull($this->instance->getExceptionForMissingRequiredData([
            'prop1' => 'test',
            'prop2' => 'test',
        ], $required));
        self::assertNull($this->instance->getExceptionForMissingRequiredData($this->createDto([
            'prop1' => 'test',
            'prop2' => 'test',
        ]), $required));

        self::assertNull($this->instance->getExceptionForMissingRequiredData([
            'prop1' => false,
            'prop2' => false,
        ], $required));
        self::assertNull($this->instance->getExceptionForMissingRequiredData($this->createDto([
            'prop1' => false,
            'prop2' => false,
        ]), $required));

        self::assertNull($this->instance->getExceptionForMissingRequiredData([
            'prop1' => 0,
            'prop2' => 0,
        ], $required));
        self::assertNull($this->instance->getExceptionForMissingRequiredData($this->createDto([
            'prop1' => 0,
            'prop2' => 0,
        ]), $required));
    }

    public function testDifferentApiHosts(): void
    {
        self::assertEquals('https://api.targito.com/v1.0/test/Test', $this->getApiUrl($this->instance));

        $instance = new class(new EnvironmentCredentials(), new CurlHttpRequest(), 'https://custom.api.targito.com/v1.0') extends AbstractEndpoint {
            protected function getApiModule(): string
            {
                return 'test';
            }
        };
        self::assertEquals('https://custom.api.targito.com/v1.0/test/Test', $this->getApiUrl($instance));
    }

    private function createDto(array $data): AbstractRequestDTO
    {
        $dto = new class extends AbstractRequestDTO {
        };

        return $dto::fromArray([
            'additionalFields' => $data,
        ]);
    }

    private function getApiUrl(AbstractEndpoint $instance): string
    {
        $reflection = new ReflectionMethod($instance, 'getApiUrl');
        $reflection->setAccessible(true);

        return $reflection->invoke($instance, 'test');
    }
}
