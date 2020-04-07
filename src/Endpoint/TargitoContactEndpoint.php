<?php

namespace Targito\Api\Endpoint;

use LogicException;
use Targito\Api\Credentials\CredentialsInterface;
use Targito\Api\DTO\Request\Contact\AddContactRequest;
use Targito\Api\DTO\Request\Contact\DeleteContactRequest;
use Targito\Api\DTO\Request\Contact\EditContactRequest;
use Targito\Api\DTO\Request\Contact\ExportContactByIdRequest;
use Targito\Api\DTO\Request\Contact\OptOutContactRequest;
use Targito\Api\DTO\Response\Contact\AddContactResponse;
use Targito\Api\DTO\Response\Contact\DeleteContactResponse;
use Targito\Api\DTO\Response\Contact\EditContactResponse;
use Targito\Api\DTO\Response\Contact\ExportContactByIdResponse;
use Targito\Api\DTO\Response\Contact\OptOutContactResponse;
use Targito\Api\Http\HttpRequestInterface;
use Targito\Api\TargitoApi;

/**
 * API endpoint for working with contacts
 */
final class TargitoContactEndpoint extends AbstractEndpoint
{
    private const ENDPOINT = 'contacts';

    /**
     * @var CredentialsInterface
     */
    private $credentials;

    /**
     * @var HttpRequestInterface
     */
    private $httpRequest;

    public function __construct(CredentialsInterface $credentials, HttpRequestInterface $httpRequest)
    {
        $this->credentials = $credentials;
        $this->httpRequest = $httpRequest;
    }

    /**
     * Creates a new contact
     *
     * @param array|AddContactRequest $data
     *
     * @return AddContactResponse
     */
    public function addContact($data): AddContactResponse
    {
        if ($exception = $this->getExceptionForInvalidRequestData($data, AddContactRequest::class)) {
            throw $exception;
        }
        if (!$data['email'] || !$data['origin'] || !$data['isOptedIn']) {
            throw new LogicException("'email', 'origin' and 'isOptedIn' parameters are required");
        }

        $response = $this->httpRequest->post(
            $this->getApiUrl(__FUNCTION__),
            $data,
            $this->credentials
        );

        return new AddContactResponse($response);
    }

    /**
     * Edits existing contact
     *
     * @param array|EditContactRequest $data
     *
     * @return EditContactResponse
     */
    public function editContact($data): EditContactResponse
    {
        if ($exception = $this->getExceptionForInvalidRequestData($data, EditContactRequest::class)) {
            throw $exception;
        }
        if (!$data['email'] || !$data['origin']) {
            throw new LogicException("'email' and 'origin' parameters are required");
        }

        $response = $this->httpRequest->post(
            $this->getApiUrl(__FUNCTION__),
            $data,
            $this->credentials
        );

        return new EditContactResponse($response);
    }

    /**
     * Deletes an existing contact (asynchronously)
     *
     * @param array|DeleteContactRequest $data
     *
     * @return DeleteContactResponse
     */
    public function deleteContact($data): DeleteContactResponse
    {
        if ($exception = $this->getExceptionForInvalidRequestData($data, DeleteContactRequest::class)) {
            throw $exception;
        }

        if (!$data['id'] || !$data['origin']) {
            throw new LogicException("'id' and 'origin' parameters are required");
        }

        $response = $this->httpRequest->post(
            $this->getApiUrl(__FUNCTION__),
            $data,
            $this->credentials
        );

        return new DeleteContactResponse($response);
    }

    /**
     * Opts out the contact
     *
     * @param array|OptOutContactRequest $data
     *
     * @return OptOutContactResponse
     */
    public function optOutContact($data): OptOutContactResponse
    {
        if ($exception = $this->getExceptionForInvalidRequestData($data, OptOutContactRequest::class)) {
            throw $exception;
        }

        if (!$data['email'] || !$data['origin']) {
            throw new LogicException("'email' and 'origin' parameters are required");
        }

        $response = $this->httpRequest->post(
            $this->getApiUrl(__FUNCTION__),
            $data,
            $this->credentials
        );

        return new OptOutContactResponse($response);
    }

    /**
     * Creates an export of the contact data (asynchronously)
     *
     * @param array|ExportContactByIdRequest $data
     *
     * @return ExportContactByIdResponse
     */
    public function exportContactById($data): ExportContactByIdResponse
    {
        if ($exception = $this->getExceptionForInvalidRequestData($data, ExportContactByIdRequest::class)) {
            throw $exception;
        }

        if (!$data['id'] || !$data['origin']) {
            throw new LogicException("'id' and 'origin' parameters are required");
        }

        $response = $this->httpRequest->post(
            $this->getApiUrl(__FUNCTION__),
            $data,
            $this->credentials
        );

        return new ExportContactByIdResponse($response);
    }

    private function getApiUrl(string $method): string
    {
        return sprintf('%s/%s/%s', TargitoApi::API_URL, self::ENDPOINT, ucfirst($method));
    }
}
