<?php

namespace Targito\Api\DTO\Response;

use Targito\Api\Http\HttpResponseInterface;

abstract class AbstractResponseDTO
{
    /**
     * @var HttpResponseInterface
     */
    protected $response;

    /**
     * @internal
     *
     * @param HttpResponseInterface $response
     */
    public function __construct(HttpResponseInterface $response)
    {
        $this->response = $response;
        $this->initialize();
    }

    abstract protected function initialize(): void;
}
