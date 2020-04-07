<?php

namespace Targito\Api\DTO\Response\Contact;

use Targito\Api\DTO\Response\AbstractResponseDTO;

final class EditContactResponse extends AbstractResponseDTO
{
    /**
     * Whether the editing succeeded
     *
     * @var bool
     */
    public $success;

    protected function initialize(): void
    {
        $this->success = $this->response->getJsonBody()['result'];
    }
}
