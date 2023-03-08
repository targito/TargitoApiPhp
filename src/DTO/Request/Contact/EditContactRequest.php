<?php

namespace Targito\Api\DTO\Request\Contact;

use Targito\Api\DTO\Request\AbstractRequestDTO;

final class EditContactRequest extends AbstractRequestDTO
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

    /**
     * Whether the contact is opted in
     *
     * @var bool
     */
    public $isOptedIn = null;

    /**
     * List of all consents for the contact
     *
     * @var string[]|null
     */
    public $consents = null;

    /**
     * Any additional fields (must be first defined in Targito) where the array key is the column
     *
     * @var array<string,string>|null
     */
    public $columns = null;

    public function jsonSerialize(array $normalizers = []): array
    {
        $json = parent::jsonSerialize();

        if ($this->isOptedIn === null) {
            unset($json['isOptedIn']);
        }
        if ($this->consents === null) {
            unset($json['consents']);
        }

        if ($this->columns === null) {
            unset($json['columns']);
        }

        return $json;
    }
}
