<?php

namespace Targito\Api\Tests\DTO\Response\Contact;

use Targito\Api\DTO\Response\Contact\EditContactResponse;
use Targito\Api\Tests\AbstractResponseTest;

class EditContactResponseTest extends AbstractResponseTest
{
    public function testResponse()
    {
        $httpResponse = $this->createMockHttpResponse(true);
        $instance = new EditContactResponse($httpResponse);

        self::assertTrue($instance->success);
    }
}
