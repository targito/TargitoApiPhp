<?php

namespace Targito\Api\Tests\DTO\Response\Contact;

use Targito\Api\DTO\Response\Contact\OptOutContactResponse;
use Targito\Api\Tests\AbstractResponseTest;

class OptOutContactResponseTest extends AbstractResponseTest
{
    public function testResponse()
    {
        // the actual response of the http call is just a string 'true' or 'false'
        $httpResponse = $this->createMockHttpResponse(true, false);
        $instance = new OptOutContactResponse($httpResponse);
        self::assertTrue($instance->success);
    }
}
