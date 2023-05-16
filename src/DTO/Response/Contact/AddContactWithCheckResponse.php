<?php

namespace Targito\Api\DTO\Response\Contact;

final class AddContactWithCheckResponse extends AbstractAddContactResponse
{
    /**
     * Whether the contact is in the contact list specified in the request
     *
     * @var bool
     */
    public $isInContactList;

    protected function initialize(): void
    {
        parent::initialize();

        $body = $this->response->getJsonBody()['result'];
        $this->isInContactList = $body['isInContactList'] ?? false;
    }
}
