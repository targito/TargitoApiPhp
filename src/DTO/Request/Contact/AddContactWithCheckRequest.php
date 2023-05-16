<?php

namespace Targito\Api\DTO\Request\Contact;

final class AddContactWithCheckRequest extends AbstractAddContactRequest
{
    /**
     * UUID of a contact list to check whether the contact is already present in
     *
     * @var string
     */
    public $contactListId;

    /**
     * UUID of a transact message to send to a contact that is already present in the contact list in $contactListId
     *
     * @var string
     */
    public $isInContactListMailingId;
}
