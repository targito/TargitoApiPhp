<?php

namespace Targito\Api\Credentials;

/**
 * Credentials are given as string parameters in constructor
 */
final class Credentials implements CredentialsInterface
{
    /**
     * @var string
     */
    private $accountId;

    /**
     * @var string
     */
    private $apiPassword;

    /**
     * @param string $accountId
     * @param string $apiPassword
     */
    public function __construct(string $accountId, string $apiPassword)
    {
        $this->accountId = $accountId;
        $this->apiPassword = $apiPassword;
    }

    /**
     * @inheritDoc
     */
    public function getApiPassword(): string
    {
        return $this->apiPassword;
    }

    /**
     * @inheritDoc
     */
    public function getAccountId(): string
    {
        return $this->accountId;
    }
}
