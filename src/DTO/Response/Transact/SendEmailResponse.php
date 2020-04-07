<?php

namespace Targito\Api\DTO\Response\Transact;

use Targito\Api\DTO\Response\AbstractResponseDTO;

class SendEmailResponse extends AbstractResponseDTO
{
    /**
     * @var bool
     */
    public $success;

    protected function initialize(): void
    {
        $this->success = $this->response->getJsonBody()['result'];
    }
}
