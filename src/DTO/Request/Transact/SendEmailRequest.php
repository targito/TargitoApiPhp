<?php

namespace Targito\Api\DTO\Request\Transact;

use DateTime;
use DateTimeZone;
use Targito\Api\DTO\Request\AbstractRequestDTO;
use Targito\Api\DTO\Transact\Attachment;

class SendEmailRequest extends AbstractRequestDTO
{
    /**
     * The website origin
     *
     * @var string
     */
    public $origin;

    /**
     * The email to send this mailing to
     *
     * @var string
     */
    public $email;

    /**
     * The mailing ID
     *
     * @var string
     */
    public $mailingId;

    /**
     * The name of the sender
     *
     * @var string|null
     */
    public $fromName = null;

    /**
     * The email of the sender
     *
     * @var string|null
     */
    public $fromEmail = null;

    /**
     * The email used when user sends a reply to the mailing
     *
     * @var string|null
     */
    public $replyTo = null;

    /**
     * The date and time the email will be sent
     *
     * @var DateTime|null
     */
    public $sendDateTime = null;

    /**
     * A map where the key is the variable name
     *
     * @var array<string,string>|null
     */
    public $columns = null;

    /**
     * @var Attachment[]|array[]|null
     */
    public $attachments = [];

    public function jsonSerialize(array $normalizers = [])
    {
        $result = parent::jsonSerialize([
            'sendDateTime' => function (?DateTime $dateTime) {
                if ($dateTime === null) {
                    return null;
                }

                return $dateTime->setTimezone(new DateTimeZone('UTC'))->format('Y-m-d H:i:s');
            },
        ]);

        foreach ($result['attachments'] as $key => $attachment) {
            if ($attachment instanceof Attachment) {
                $result['attachments'][$key] = $attachment->jsonSerialize();
            }
        }

        if (!count($result['attachments'])) {
            unset($result['attachments']);
        }

        foreach (['fromName', 'fromEmail', 'replyTo', 'sendDateTime', 'columns'] as $property) {
            if ($result[$property] === null) {
                unset($result[$property]);
            }
        }

        return $result;
    }
}
