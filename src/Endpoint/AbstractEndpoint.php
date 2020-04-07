<?php

namespace Targito\Api\Endpoint;

use InvalidArgumentException;

abstract class AbstractEndpoint
{
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
            if (is_a($requestData, $expectedClass)) {
                return null;
            }
            $expectedTypes[] = $expectedClass;
        }

        return new InvalidArgumentException(
            sprintf('Invalid request data type, expected: %s', implode(', ', $expectedTypes))
        );
    }
}
