<?php

namespace Targito\Api\Http\Request;

use ArrayAccess;
use InvalidArgumentException;
use JsonSerializable;
use Targito\Api\Credentials\CredentialsInterface;
use Targito\Api\Exception\HttpCurlException;
use Targito\Api\Exception\HttpException;
use Targito\Api\Http\HttpRequestInterface;
use Targito\Api\Http\HttpResponseInterface;
use Targito\Api\Http\Response\HttpResponse;

/**
 * HTTP request class using curl as the backend
 */
final class CurlHttpRequest implements HttpRequestInterface
{
    /**
     * @inheritDoc
     */
    public function post(string $url, $body, CredentialsInterface $credentials = null): HttpResponseInterface
    {
        if (!is_array($body) && (!$body instanceof JsonSerializable || !$body instanceof ArrayAccess)) {
            throw new InvalidArgumentException(
                sprintf(
                    'The body must be an array or an object that implements %s and %s',
                    JsonSerializable::class,
                    ArrayAccess::class
                )
            );
        }
        if ($credentials !== null) {
            $body['accountId'] = $credentials->getAccountId();
        }
        $stringBody = json_encode($body);

        /** @var resource $curl */
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $stringBody);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        if ($credentials !== null) {
            curl_setopt($curl, CURLOPT_USERPWD, sprintf(
                '%s:%s',
                $credentials->getAccountId(),
                $credentials->getApiPassword()
            ));
        }

        /** @var string $rawBody */
        $rawBody = curl_exec($curl);
        if (curl_errno($curl)) {
            throw new HttpCurlException(
                sprintf(
                    'There was an error when processing request: %s',
                    curl_error($curl)
                )
            );
        }
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $body = @json_decode($rawBody, true);
        if ($statusCode >= 300 || (is_array($body) && isset($body['error']))) {
            $errorMessage = "The request resulted in error (status code ${statusCode})";
            if (is_array($body) && isset($body['error']['message'])) {
                $errorMessage = 'API error: ' . $body['error']['message'] . " (status code ${statusCode})";
            }
            throw new HttpException($errorMessage);
        }

        return new HttpResponse($rawBody);
    }
}
