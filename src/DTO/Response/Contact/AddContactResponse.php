<?php

namespace Targito\Api\DTO\Response\Contact;

use Targito\Api\DTO\Contact\AddContactHistory;
use Targito\Api\DTO\Response\AbstractResponseDTO;

final class AddContactResponse extends AbstractResponseDTO
{
    /**
     * The contact ID
     *
     * @var string
     */
    public $id;

    /**
     * Whether the contact is opted in
     *
     * @var bool
     */
    public $isOptedIn;

    /**
     * Whether the contact is opted out
     *
     * @var bool
     */
    public $isOptedOut;

    /**
     * Whether the contact is newly created or an existing one
     *
     * @var bool
     */
    public $isNew;

    /**
     * If the contact is not new, the previous state of opt-in is returned
     *
     * @var AddContactHistory|null
     */
    public $previousState = null;

    protected function initialize(): void
    {
        $body = $this->response->getJsonBody()['result'];
        if (isset($body['_history'])) {
            $this->isNew = false;
            $this->previousState = new AddContactHistory($body['_history']['isOptedIn'], $body['_history']['isOptedOut']);
        } else {
            $this->isNew = true;
        }

        $this->id = $body['id'];
        $this->isOptedIn = $body['isOptedIn'];
        $this->isOptedOut = $body['isOptedOut'];
    }
}
