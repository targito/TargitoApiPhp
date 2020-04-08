# Targito API implementation for PHP 7.2+

![Build status](https://img.shields.io/travis/com/targito/TargitoApiPhp/master)

## Installation

`composer require targito/targito-api`

## Usage

The api is accessed by creating a new instance of `\Targito\Api\TargitoApi` and providing correct credentials.

```php
<?php

use Targito\Api\TargitoApi;

$api = new TargitoApi($credentials);

// do stuff with api
```

### Obtaining credentials

The credentials are provided using an object that implements the `\Targito\Api\Credentials\CredentialsInterface`.

By default there are two such classes, `\Targito\Api\Credentials\Credentials` and
`\Targito\Api\Credentials\EnvironmentCredentials`.

The `Credentials` class accepts your account id and api password as its constructor parameters, while the
`EnvironmentCredentials` gets them from environment variables (by default `TARGITO_ACCOUNT_ID` and
`TARGITO_API_PASSWORD`).

```php
<?php

use Targito\Api\TargitoApi;
use Targito\Api\Credentials\Credentials;
use Targito\Api\Credentials\EnvironmentCredentials;

// provide the credentials in constructor
$credentials = new Credentials('my-account-id', 'my-api-password');
$api = new TargitoApi($credentials);

// get them automatically from environment variables using default TARGITO_ACCOUNT_ID and TARGITO_API_PASSWORD variables
$credentials = new EnvironmentCredentials();
$api = new TargitoApi($credentials);

// customize the environment variables
$credentials = new EnvironmentCredentials('MY_CUSTOM_ACCOUNT_ID_VARIABLE', 'MY_CUSTOM_API_PASSWORD_VARIABLE');
$api = new TargitoApi($credentials);
```

### Making requests

The HTTP requests are made using an object implementing `\Targito\Api\Http\HttpRequestInterface`.

There are two classes implementing the interface, `\Targito\Api\Http\Request\CurlHttpRequest` and
`\Targito\Api\Http\Request\StreamHttpRequest`.

If you don't provide an object for http requests, default one is used based on your php settings - if you have the
`curl` extension enabled `CurlHttpRequest` is used, `StreamHttpRequest` otherwise.

Note that `CurlHttpRequest` should be always used if possible as the `StreamHttpRequest` is just a fallback
implementation.

> Note: The interface is considered semi-internal - if you provide your own implementation, be aware that there
> may be new methods added regularly which will break your implementation. Otherwise backward compatibility is
> maintained.

The `TargitoApi` class contains methods for accessing individual API modules (e.g. contacts, transactions etc.)
which in turn contain methods for making the API requests.

```php
<?php

use Targito\Api\TargitoApi;
use Targito\Api\Credentials\EnvironmentCredentials;
use Targito\Api\DTO\Request\Contact\DeleteContactRequest;

// get credentials from env variables and use the default http request implementation
$api = new TargitoApi(new EnvironmentCredentials());

// get the contacts API module
$contactsApi = $api->contacts();

$result = $contactsApi->deleteContact(DeleteContactRequest::fromArray([
    'id' => 'contact_id',
    'origin' => 'contact_origin'
]));

echo $result->jobId;
```

Each api method accepts the data as either an array or the respective DTO object. Each DTO object can also be created
from array. These all are valid and functionally equal:

```php
<?php

use Targito\Api\TargitoApi;
use Targito\Api\Credentials\EnvironmentCredentials;
use Targito\Api\DTO\Request\Contact\DeleteContactRequest;

$api = new TargitoApi(new EnvironmentCredentials());

// provide data as array
$api->contacts()->deleteContact([
    'id' => 'contact_id',
    'origin' => 'contact_origin'
]);

// create the DeleteContactRequest from array
$api->contacts()->deleteContact(DeleteContactRequest::fromArray([
    'id' => 'contact_id',
    'origin' => 'contact_origin'
]));

// create the DeleteContactRequest manually
$deleteRequest = new DeleteContactRequest();
$deleteRequest->id = 'contact_id';
$deleteRequest->origin = 'contact_origin';

$api->contacts()->deleteContact($deleteRequest);
```

Each method returns a response specific to the method (e.g. `AddContactResponse`, `DeleteContactResponse` etc.).
See individual classes for list of available properties.

## Modules

### Contacts

The module is accessed by calling `contacts()` on the api object or constructing
`\Targito\Api\Endpoint\TargitoContactEndpoint` manually.

### Methods

- `addContact`
    - request data: `\Targito\Api\DTO\Request\Contact\AddContactRequest`
    - properties:
        - string `email` - the email of the contact you're adding
        - string `origin` - the contact origin
        - bool   `isOptedIn` - whether the contact is opted in
        - bool   `forbidReOptIn` (optional) - whether to forbid opting in again if the contact is already in database and
        is opted out
        - array  `consents` (optional) - string array containing list of consents the contact has given
        - array  `columns` (optional) - any additional columns (which must be defined in Targito), where the array key
        is the column name
    - return value:
        - class: `\Targito\Api\DTO\Response\Contact\AddContactResponse`
        - properties:
            - string `id` - the ID of the contact
            - bool   `isOptedIn` - whether the contact is opted in
            - bool   `isOptedOut` - whether the contact is opted out
            - bool   `isNew` - whether the contact is newly created or it existed before
            - `previousState` - if the contact existed previously, this property will be instance of
            `\Targito\Api\DTO\Contact\AddContactHistory` otherwise null.
                - `AddContactHistory` contains these properties: `bool isOptedIn` and `bool isOptedOut`
- `editContact`
    - request data: `\Targito\Api\DTO\Request\Contact\EditContactRequest`
    - properties:
        - string `email` - the email of the contact you're editing
        - string `origin` - the contact origin
        - bool   `isOptedIn` (optional) - whether the contact is opted in
        - array  `consents` (optional) - string array containing list of consents the contact has given
        - array  `columns` (optional) - any additional columns (which must be defined in Targito), where the array key
        is the column name
    - return value:
        - class: `\Targito\Api\DTO\Response\Contact\EditContactResponse`
        - properties:
            - bool `success` - whether the editing succeeded or not
- `deleteContact`
    - request data: `\Targito\Api\DTO\Request\Contact\DeleteContactRequest`
    - properties:
        - string `id` - the contact ID
        - string `origin` - the contact origin
    - return value:
        - class: `\Targito\Api\DTO\Response\Contact\DeleteContactResponse`
        - properties:
            - string `jobId` - the ID of the job that will perform the deletion
- `optOutContact`
    - request data: `\Targito\Api\DTO\Request\Contact\OptOutContactRequest`
    - properties:
        - string `email` - the email of the contact you're deleting
        - string `origin` - the contact origin 
    - return value:
        - class: `\Targito\Api\DTO\Response\Contact\OptOutContactResponse`
        - properties:
            - bool `success` - whether opting out succeeded or not
- `exportContactById`
    - request data: `\Targito\Api\DTO\Request\Contact\ExportContactByIdRequest`
    - properties:
        - string `id` - the contact ID
        - string `origin` - the contact origin
    - return value:
        - class: `\Targito\Api\DTO\Response\Contact\ExportContactByIdResponse`
        - properties:
            - string `jobId` - the ID of the job that will perform the export
