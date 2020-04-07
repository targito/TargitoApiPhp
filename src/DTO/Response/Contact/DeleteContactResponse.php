<?php

namespace Targito\Api\DTO\Response\Contact;

use Targito\Api\DTO\Response\AbstractResponseDTO;

final class DeleteContactResponse extends AbstractResponseDTO
{
    /**
     * The ID of the job that will delete the contact
     *
     * @var string
     */
    public $jobId;

    protected function initialize(): void
    {
        $body = $this->response->getJsonBody();
        $this->jobId = $body['result'];
    }
}
