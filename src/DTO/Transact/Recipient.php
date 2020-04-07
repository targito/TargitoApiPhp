<?php

namespace Targito\Api\DTO\Transact;

use JsonSerializable;

class Recipient implements JsonSerializable
{
    /**
     * The recipient email
     *
     * @var string
     */
    private $email;

    /**
     * List of template variables with their value where key is the variable name
     *
     * @var array<string,string>|null
     */
    private $columns;

    public function __construct(string $email, ?array $columns = null)
    {
        $this->email = $email;
        $this->columns = $columns;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        $result = [
            'email' => $this->email,
        ];

        if ($this->columns !== null) {
            $result['columns'] = $this->columns;
        }

        return $result;
    }
}
