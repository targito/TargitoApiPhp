<?php

namespace Targito\Api\DTO\Request;

use ArrayAccess;
use InvalidArgumentException;
use JsonSerializable;

abstract class AbstractRequestDTO implements JsonSerializable, ArrayAccess
{
    /**
     * @var array<string,mixed>
     */
    protected $additionalFields = [];

    final public function __construct()
    {
    }

    /**
     * Creates a new instance from array in format key => value
     *
     * @param array $data The data array in key => value format
     *
     * @return static
     */
    public static function fromArray(array $data)
    {
        $instance = new static();
        foreach ($data as $key => $value) {
            if (!property_exists($instance, $key)) {
                throw new InvalidArgumentException("Invalid key '${key}'");
            }
            $instance->{$key} = $value;
        }

        return $instance;
    }

    /**
     * @param string $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return property_exists($this, $offset) || isset($this->additionalFields[$offset]);
    }

    /**
     * @param string $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        if (isset($this->additionalFields[$offset])) {
            return $this->additionalFields[$offset];
        }

        return $this->{$offset};
    }

    /**
     * @param string $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (property_exists($this, $offset)) {
            $this->{$offset} = $value;
        }

        $this->additionalFields[$offset] = $value;
    }

    /**
     * @param string $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        if (property_exists($this, $offset)) {
            $this->{$offset} = null;
        } elseif (isset($this->additionalFields[$offset])) {
            unset($this->additionalFields[$offset]);
        }
    }

    /**
     * @inheritDoc
     *
     * @param array<string,callable> $normalizers
     * @return array
     */
    public function jsonSerialize(array $normalizers = [])
    {
        $result = [];
        foreach (get_object_vars($this) as $property => $value) {
            if ($property === 'additionalFields') {
                continue;
            }

            if (isset($normalizers[$property])) {
                $result[$property] = call_user_func($normalizers[$property], $value);
            } else {
                $result[$property] = $value;
            }
        }

        foreach ($this->additionalFields as $key => $value) {
            $result[$key] = $value;
        }

        return $result;
    }
}
