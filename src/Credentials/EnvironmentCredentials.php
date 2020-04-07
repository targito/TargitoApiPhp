<?php

namespace Targito\Api\Credentials;

use Targito\Api\Exception\TargitoException;

/**
 * Credentials are fetched from environment variables
 * The default variables can be changed in constructor parameters
 */
final class EnvironmentCredentials implements CredentialsInterface
{
    /**
     * @var string
     */
    private $accountIdEnv;

    /**
     * @var string
     */
    private $apiPasswordEnv;

    public function __construct(
        string $accountIdEnv = 'TARGITO_ACCOUNT_ID',
        string $apiPasswordEnv = 'TARGITO_API_PASSWORD'
    ) {
        $this->accountIdEnv = $accountIdEnv;
        $this->apiPasswordEnv = $apiPasswordEnv;
    }

    /**
     * @inheritDoc
     *
     * @throws TargitoException
     */
    public function getApiPassword(): string
    {
        $apiKey = getenv($this->apiPasswordEnv);
        if (!is_string($apiKey)) {
            throw new TargitoException(
                sprintf("The environment variable '%s' not found", $this->apiPasswordEnv)
            );
        }

        return $apiKey;
    }

    /**
     * @inheritDoc
     *
     * @throws TargitoException
     */
    public function getAccountId(): string
    {
        $accountId = getenv($this->accountIdEnv);
        if (!is_string($accountId)) {
            throw new TargitoException(
                sprintf("The environment variable '%s' not found", $this->accountIdEnv)
            );
        }

        return $accountId;
    }
}
