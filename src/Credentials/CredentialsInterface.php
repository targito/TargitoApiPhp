<?php

namespace Targito\Api\Credentials;

interface CredentialsInterface
{
    /**
     * Returns the api password
     *
     * @return string
     */
    public function getApiPassword(): string;

    /**
     * Returns the account id
     *
     * @return string
     */
    public function getAccountId(): string;
}
