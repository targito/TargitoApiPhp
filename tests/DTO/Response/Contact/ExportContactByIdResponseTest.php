<?php

namespace Targito\Api\Tests\DTO\Response\Contact;

use Targito\Api\DTO\Response\Contact\ExportContactByIdResponse;
use Targito\Api\Tests\AbstractResponseTest;

class ExportContactByIdResponseTest extends AbstractResponseTest
{
    public function testResponse()
    {
        $httpResponse = $this->createMockHttpResponse('some_job_id');
        $instance = new ExportContactByIdResponse($httpResponse);
        self::assertEquals('some_job_id', $instance->jobId);
    }
}
