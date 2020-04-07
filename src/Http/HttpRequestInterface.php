<?php

namespace Targito\Api\Http;

use ArrayAccess;
use JsonSerializable;
use Targito\Api\Credentials\CredentialsInterface;

interface HttpRequestInterface
{
    /**
     * @param string                             $url
     * @param array|JsonSerializable&ArrayAccess $body
     * @param CredentialsInterface|null          $credentials
     *
     * @return HttpResponseInterface
     */
    public function post(string $url, $body, CredentialsInterface $credentials = null): HttpResponseInterface;
}
