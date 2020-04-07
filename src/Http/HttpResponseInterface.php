<?php

namespace Targito\Api\Http;

interface HttpResponseInterface
{
    /**
     * Returns the body as a string
     *
     * @return string
     */
    public function getBody(): string;

    /**
     * Returns the body as a json decoded array
     *
     * @return array
     */
    public function getJsonBody(): array;
}
