<?php

namespace Targito\Api\DTO\Request\Contact;

use Targito\Api\DTO\Request\AbstractRequestDTO;

final class ChangeContactEmailAddressRequest extends AbstractRequestDTO
{
    /**
     * The contact origin
     *
     * @var string
     */
    public $origin;

    /**
     * The old e-mail address of the contact
     *
     * @var string
     */
    public $oldEmail;

    /**
     * The new e-mail address of the contact
     *
     * @var string
     */
    public $newEmail;

    /**
     * When set to true all event data will be merged if contact with the new email already exists
     *
     * @var bool
     */
    public $mergeIfExists = true;
}
