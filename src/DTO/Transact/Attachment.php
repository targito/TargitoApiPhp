<?php

namespace Targito\Api\DTO\Transact;

use InvalidArgumentException;
use JsonSerializable;
use Psr\Http\Message\StreamInterface;
use Targito\Api\Exception\TargitoException;

final class Attachment implements JsonSerializable
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $mediaType;

    /**
     * @var StreamInterface|resource|string
     */
    private $attachment;

    /**
     * Attachment constructor.
     *
     * @param string                          $name       The attachment filename
     * @param string                          $mediaType  The attachment media type (also known as MIME type)
     * @param StreamInterface|resource|string $attachment The attachment either as a string content a resource (e.g. from fopen) or StreamInterface
     */
    public function __construct(string $name, string $mediaType, $attachment)
    {
        $this->name = $name;
        $this->mediaType = $mediaType;
        $this->attachment = $attachment;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getMediaType(): string
    {
        return $this->mediaType;
    }

    /**
     * @throws TargitoException
     *
     * @return string
     */
    public function getContent(): string
    {
        if (class_exists(StreamInterface::class) && $this->attachment instanceof StreamInterface) {
            return $this->attachment->getContents();
        }
        if (is_resource($this->attachment) && get_resource_type($this->attachment) === 'stream') {
            $result = stream_get_contents($this->attachment, -1, 0);
            if (!is_string($result)) {
                throw new TargitoException('The attachment stream is not readable');
            }

            return $result;
        }
        if (
            is_string($this->attachment)
            || (is_object($this->attachment) && method_exists($this->attachment, '__toString'))
            || is_numeric($this->attachment)
            || is_bool($this->attachment)
        ) {
            return (string) $this->attachment;
        }

        throw new InvalidArgumentException('The attachment must be a php stream, convertible to string or instance of ' . StreamInterface::class);
    }

    /**
     * @throws TargitoException
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getName(),
            'type' => $this->getMediaType(),
            'data' => base64_encode($this->getContent()),
        ];
    }
}
