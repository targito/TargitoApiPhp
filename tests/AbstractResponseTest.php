<?php

namespace Targito\Api\Tests;

use PHPUnit\Framework\TestCase;
use Targito\Api\Http\HttpResponseInterface;

abstract class AbstractResponseTest extends TestCase
{
    /**
     * @param mixed $responseData
     * @param bool  $prefixWithResultKey
     *
     * @return HttpResponseInterface
     */
    protected function createMockHttpResponse($responseData, bool $prefixWithResultKey = true): HttpResponseInterface
    {
        if ($prefixWithResultKey) {
            $responseData = ['result' => $responseData];
        }

        return new class($responseData) implements HttpResponseInterface {
            /**
             * @var array
             */
            private $responseData;

            public function __construct($responseData)
            {
                $this->responseData = $responseData;
            }

            public function getBody(): string
            {
                return json_encode($this->responseData);
            }

            public function getJsonBody(): array
            {
                return $this->responseData;
            }
        };
    }
}
