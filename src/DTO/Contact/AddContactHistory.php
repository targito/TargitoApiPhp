<?php

namespace Targito\Api\DTO\Contact;

class AddContactHistory
{
    /**
     * @var bool
     */
    private $isOptedIn;

    /**
     * @var bool
     */
    private $isOptedOut;

    /**
     * @internal
     *
     * @param bool $isOptedIn
     * @param bool $isOptedOut
     */
    public function __construct(bool $isOptedIn, bool $isOptedOut)
    {
        $this->isOptedIn = $isOptedIn;
        $this->isOptedOut = $isOptedOut;
    }
}
