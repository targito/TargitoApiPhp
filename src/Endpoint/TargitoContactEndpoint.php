<?php

namespace Targito\Api\Endpoint;

use Targito\Api\DTO\Request\Contact\AddContactRequest;
use Targito\Api\DTO\Request\Contact\AddContactWithCheckRequest;
use Targito\Api\DTO\Request\Contact\ChangeContactEmailAddressRequest;
use Targito\Api\DTO\Request\Contact\DeleteContactRequest;
use Targito\Api\DTO\Request\Contact\EditContactRequest;
use Targito\Api\DTO\Request\Contact\ExportContactByIdRequest;
use Targito\Api\DTO\Request\Contact\OptOutContactRequest;
use Targito\Api\DTO\Response\Contact\AddContactResponse;
use Targito\Api\DTO\Response\Contact\AddContactWithCheckResponse;
use Targito\Api\DTO\Response\Contact\ChangeContactEmailAddressResponse;
use Targito\Api\DTO\Response\Contact\DeleteContactResponse;
use Targito\Api\DTO\Response\Contact\EditContactResponse;
use Targito\Api\DTO\Response\Contact\ExportContactByIdResponse;
use Targito\Api\DTO\Response\Contact\OptOutContactResponse;

/**
 * API endpoint for working with contacts
 */
final class TargitoContactEndpoint extends AbstractEndpoint
{
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
        if ($exception = $this->getExceptionForMissingRequiredData($data, ['email', 'origin', 'isOptedIn'])) {
            throw $exception;
        }

        $response = $this->httpRequest->post(
            $this->getApiUrl(__FUNCTION__),
            $data,
            $this->credentials
        );

        return new AddContactResponse($response);
    }

    public function addContactWithCheck($data): AddContactWithCheckResponse
    {
        if ($exception = $this->getExceptionForInvalidRequestData($data, AddContactWithCheckRequest::class)) {
            throw $exception;
        }
        if ($exception = $this->getExceptionForMissingRequiredData($data, [
            'email',
            'origin',
            'isOptedIn',
            'contactListId',
            'isInContactListMailingId',
        ])) {
            throw $exception;
        }

        $response = $this->httpRequest->post(
            $this->getApiUrl(__FUNCTION__),
            $data,
            $this->credentials
        );

        return new AddContactWithCheckResponse($response);
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
        if ($exception = $this->getExceptionForMissingRequiredData($data, ['email', 'origin'])) {
            throw $exception;
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
        if ($exception = $this->getExceptionForMissingRequiredData($data, ['id', 'origin'])) {
            throw $exception;
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
        if ($exception = $this->getExceptionForMissingRequiredData($data, ['email', 'origin'])) {
            throw $exception;
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
        if ($exception = $this->getExceptionForMissingRequiredData($data, ['id', 'origin'])) {
            throw $exception;
        }

        $response = $this->httpRequest->post(
            $this->getApiUrl(__FUNCTION__),
            $data,
            $this->credentials
        );

        return new ExportContactByIdResponse($response);
    }

    /**
     * Changes contact's email address
     *
     * @param array|ChangeContactEmailAddressRequest $data
     *
     * @return ChangeContactEmailAddressResponse
     */
    public function changeContactEmailAddress($data): ChangeContactEmailAddressResponse
    {
        if ($exception = $this->getExceptionForInvalidRequestData($data, ChangeContactEmailAddressRequest::class)) {
            throw $exception;
        }
        if ($exception = $this->getExceptionForMissingRequiredData($data, ['origin', 'oldEmail', 'newEmail', 'mergeIfExists'])) {
            throw $exception;
        }

        $response = $this->httpRequest->post(
            $this->getApiUrl(__FUNCTION__),
            $data,
            $this->credentials
        );

        return new ChangeContactEmailAddressResponse($response);
    }

    /**
     * @inheritDoc
     */
    protected function getApiModule(): string
    {
        return 'contacts';
    }
}
