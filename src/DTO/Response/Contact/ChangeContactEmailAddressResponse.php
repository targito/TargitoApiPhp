<?php

namespace Targito\Api\DTO\Response\Contact;

use Targito\Api\DTO\Response\AbstractResponseDTO;

final class ChangeContactEmailAddressResponse extends AbstractResponseDTO
{
    /**
     * Whether the email address change succeeded
     *
     * @var bool
     */
    public $success;

    protected function initialize(): void
    {
        $this->success = $this->response->getJsonBody()['result'];
    }
}
