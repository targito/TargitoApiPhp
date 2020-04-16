<?php

namespace Targito\Api\Tests\DTO\Response\Contact;

use Targito\Api\DTO\Response\Contact\DeleteContactResponse;
use Targito\Api\Tests\AbstractResponseTest;

class DeleteContactResponseTest extends AbstractResponseTest
{
    public function testResponse()
    {
        $httpResponse = $this->createMockHttpResponse('random_job_id');
        $instance = new DeleteContactResponse($httpResponse);
        self::assertEquals('random_job_id', $instance->jobId);
    }
}
