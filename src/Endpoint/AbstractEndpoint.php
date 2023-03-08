<?php

namespace Targito\Api\Endpoint;

use ArrayAccess;
use InvalidArgumentException;
use Targito\Api\Credentials\CredentialsInterface;
use Targito\Api\Http\HttpRequestInterface;
use Targito\Api\TargitoApi;

abstract class AbstractEndpoint
{
    /**
     * @var CredentialsInterface
     */
    protected $credentials;

    /**
     * @var HttpRequestInterface
     */
    protected $httpRequest;

    /**
     * @var string
     */
    protected $apiUrl;

    public function __construct(
        CredentialsInterface $credentials,
        HttpRequestInterface $httpRequest,
        string $apiUrl = TargitoApi::API_URL
    ) {
        $this->credentials = $credentials;
        $this->httpRequest = $httpRequest;
        $this->apiUrl = $apiUrl;
    }

    /**
     * Returns the api module, e.g. the part of the url after version
     *
     * @return string
     */
    abstract protected function getApiModule(): string;

    /**
     * Checks whether the parameter $requestData is array or an instance of the $expectedClass.
     * If it is, null is returned, correctly formatted exception otherwise.
     *
     * @param mixed       $requestData
     * @param string|null $expectedClass
     *
     * @return InvalidArgumentException|null
     */
    protected function getExceptionForInvalidRequestData($requestData, string $expectedClass = null): ?InvalidArgumentException
    {
        if (is_array($requestData)) {
            return null;
        }
        $expectedTypes = ['array'];

        if ($expectedClass !== null) {
            if (is_object($requestData) && is_a($requestData, $expectedClass)) {
                return null;
            }
            $expectedTypes[] = $expectedClass;
        }

        return new InvalidArgumentException(
            sprintf('Invalid request data type, expected: %s', implode(', ', $expectedTypes))
        );
    }

    protected function getApiUrl(string $method): string
    {
        return sprintf(
            '%s/%s/%s',
            $this->apiUrl,
            $this->getApiModule(),
            ucfirst($method)
        );
    }

    /**
     * @param array|ArrayAccess $data
     * @param array             $required
     *
     * @return InvalidArgumentException|null
     */
    protected function getExceptionForMissingRequiredData($data, array $required): ?InvalidArgumentException
    {
        $missing = [];
        foreach ($required as $requiredParameter) {
            if (!isset($data[$requiredParameter])) {
                $missing[] = $requiredParameter;
            }
        }

        if (!count($missing)) {
            return null;
        }

        return new InvalidArgumentException(sprintf(
            'The following parameters are required: %s. Missing: %s',
            implode(', ', $required),
            implode(', ', $missing)
        ));
    }
}
