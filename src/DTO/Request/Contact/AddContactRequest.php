<?php

namespace Targito\Api\DTO\Request\Contact;

use Targito\Api\DTO\Request\AbstractRequestDTO;

final class AddContactRequest extends AbstractRequestDTO
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
    public $isOptedIn;

    /**
     * Whether to forbid opting in again if the contact is already in database and is opted out
     *
     * @var bool|null
     */
    public $forbidReOptIn = null;

    /**
     * List of all consents for the contact
     *
     * @var string[]|null
     */
    public $consents = null;

    /**
     * The campaign ID
     *
     * @var string|null
     */
    public $campaignId = null;

    /**
     * Any additional fields (must be first defined in Targito) where the array key is the column
     *
     * @var array<string,string>|null
     */
    public $columns = null;

    public function jsonSerialize(array $normalizers = []): array
    {
        $json = parent::jsonSerialize();

        if ($this->forbidReOptIn === null) {
            unset($json['forbidReOptIn']);
        }
        if ($this->consents === null) {
            unset($json['consents']);
        }

        if ($this->columns === null) {
            unset($json['columns']);
        }
        if ($this->campaignId === null) {
            unset($json['campaignId']);
        }

        return $json;
    }
}
