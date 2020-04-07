<?php

namespace Targito\Api\Http\Response;

use RuntimeException;
use Targito\Api\Http\HttpResponseInterface;

/**
 * Simple HTTP response wrapper implementation
 */
final class HttpResponse implements HttpResponseInterface
{
    /**
     * @var string
     */
    private $rawBody;

    /**
     * @internal
     *
     * @param string $rawBody
     */
    public function __construct(string $rawBody)
    {
        $this->rawBody = $rawBody;
    }

    /**
     * @inheritDoc
     */
    public function getBody(): string
    {
        return $this->rawBody;
    }

    /**
     * @inheritDoc
     */
    public function getJsonBody(): array
    {
        $data = json_decode($this->rawBody, true);
        if (json_last_error()) {
            throw new RuntimeException('JSON decode error: ' . json_last_error_msg());
        }

        return $data;
    }
}
