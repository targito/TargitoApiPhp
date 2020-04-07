<?php

namespace Targito\Api\DTO\Request\Contact;

use Targito\Api\DTO\Request\AbstractRequestDTO;

final class ExportContactByIdRequest extends AbstractRequestDTO
{
    /**
     * The contact ID
     *
     * @var string
     */
    public $id;

    /**
     * The contact origin
     *
     * @var string
     */
    public $origin;
}
