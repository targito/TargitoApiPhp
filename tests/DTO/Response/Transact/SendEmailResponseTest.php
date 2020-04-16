<?php

namespace Targito\Api\Tests\DTO\Response\Transact;

use Targito\Api\DTO\Response\Transact\SendEmailResponse;
use Targito\Api\Tests\AbstractResponseTest;

class SendEmailResponseTest extends AbstractResponseTest
{
    public function testResponse()
    {
        $httpResponse = $this->createMockHttpResponse(true);
        $instance = new SendEmailResponse($httpResponse);
        self::assertTrue($instance->success);
    }
}
