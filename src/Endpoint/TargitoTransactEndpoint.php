<?php

namespace Targito\Api\Endpoint;

use Targito\Api\DTO\Request\Transact\SendEmailRequest;
use Targito\Api\DTO\Request\Transact\SendMassEmailRequest;
use Targito\Api\DTO\Response\Transact\SendEmailResponse;
use Targito\Api\DTO\Response\Transact\SendMassEmailResponse;

class TargitoTransactEndpoint extends AbstractEndpoint
{
    /**
     * Sends a single mail
     *
     * @param array|SendEmailRequest $data
     *
     * @return SendEmailResponse
     */
    public function sendEmail($data): SendEmailResponse
    {
        if ($exception = $this->getExceptionForInvalidRequestData($data, SendEmailRequest::class)) {
            throw $exception;
        }
        if ($exception = $this->getExceptionForMissingRequiredData($data, ['origin', 'email', 'mailingId'])) {
            throw $exception;
        }

        $response = $this->httpRequest->post(
            $this->getApiUrl(__FUNCTION__),
            $data,
            $this->credentials
        );

        return new SendEmailResponse($response);
    }

    /**
     * Sends a mass email to up to 100 recipients
     *
     * @param array|SendMassEmailRequest $data
     *
     * @return SendMassEmailResponse
     */
    public function sendMassEmail($data): SendMassEmailResponse
    {
        if ($exception = $this->getExceptionForInvalidRequestData($data, SendMassEmailRequest::class)) {
            throw $exception;
        }
        if ($exception = $this->getExceptionForMissingRequiredData($data, ['origin', 'recipients', 'mailingId'])) {
            throw $exception;
        }

        $response = $this->httpRequest->post(
            $this->getApiUrl(__FUNCTION__),
            $data,
            $this->credentials
        );

        return new SendMassEmailResponse($response);
    }

    /**
     * @inheritDoc
     */
    protected function getApiModule(): string
    {
        return 'transact';
    }
}
