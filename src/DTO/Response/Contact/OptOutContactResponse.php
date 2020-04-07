<?php

namespace Targito\Api\DTO\Response\Contact;

use Targito\Api\DTO\Response\AbstractResponseDTO;

final class OptOutContactResponse extends AbstractResponseDTO
{
    /**
     * Whether the operation was successful
     *
     * @var bool
     */
    public $success;

    protected function initialize(): void
    {
        $body = $this->response->getBody();
        $this->success = $body === 'true';
    }
}
