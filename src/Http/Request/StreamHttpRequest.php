<?php

namespace Targito\Api\Http\Request;

use ArrayAccess;
use InvalidArgumentException;
use JsonSerializable;
use Targito\Api\Credentials\CredentialsInterface;
use Targito\Api\Exception\HttpException;
use Targito\Api\Http\HttpRequestInterface;
use Targito\Api\Http\HttpResponseInterface;
use Targito\Api\Http\Response\HttpResponse;

/**
 * Fallback HTTP request implementation using PHP stream context
 */
final class StreamHttpRequest implements HttpRequestInterface
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
        $headers = [
            'Content-Type' => 'application/json',
        ];
        if ($credentials !== null) {
            $body['accountId'] = $credentials->getAccountId();
            $headers['Authorization'] = 'Basic ' . base64_encode(
                sprintf(
                    '%s:%s',
                    $credentials->getAccountId(),
                    $credentials->getApiPassword()
                )
            );
        }
        $stringBody = json_encode($body);
        $headersString = (function () use ($headers) {
            $result = '';
            foreach ($headers as $header => $value) {
                $result .= sprintf("%s:%s\r\n", $header, $value);
            }

            return $result;
        })();

        $context = stream_context_create([
            'http' => [
                'header' => $headersString,
                'method' => 'POST',
                'content' => $stringBody,
            ],
        ]);

        $rawBody = file_get_contents($url, false, $context);
        if ($rawBody === false) {
            throw new HttpException('There was an error getting the required resource');
        }
        $body = @json_decode($rawBody, true);
        if (is_array($body) && isset($body['error']['message'])) {
            throw new HttpException('API error: ' . $body['error']['message']);
        }

        return new HttpResponse($rawBody);
    }
}
