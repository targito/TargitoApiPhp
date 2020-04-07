<?php

namespace Targito\Api\DTO\Response\Contact;

use Targito\Api\DTO\Response\AbstractResponseDTO;

final class ExportContactByIdResponse extends AbstractResponseDTO
{
    /**
     * The ID of the job that will perform the contact
     *
     * @var string
     */
    public $jobId;

    protected function initialize(): void
    {
        $this->jobId = $this->response->getJsonBody()['result'];
    }
}
