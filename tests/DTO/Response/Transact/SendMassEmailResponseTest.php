<?php

namespace Targito\Api\Tests\DTO\Response\Transact;

use Targito\Api\DTO\Response\Transact\SendMassEmailResponse;
use Targito\Api\Tests\AbstractResponseTest;

class SendMassEmailResponseTest extends AbstractResponseTest
{
    public function testResponse()
    {
        $httpResponse = $this->createMockHttpResponse(false);
        $instance = new SendMassEmailResponse($httpResponse);
        self::assertFalse($instance->success);
    }
}
