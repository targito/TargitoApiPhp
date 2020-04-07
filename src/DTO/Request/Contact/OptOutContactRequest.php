<?php

namespace Targito\Api\DTO\Request\Contact;

use Targito\Api\DTO\Request\AbstractRequestDTO;

final class OptOutContactRequest extends AbstractRequestDTO
{
    /**
     * The contact's email
     *
     * @var string
     */
    public $email;

    /**
     * The contact origin
     *
     * @var string
     */
    public $origin;
}
