## Introduction

Creating HMAC-SHA256 signature for a HTTP request.

## Installation

Add jetfueltw/signer-php as a require dependency in your composer.json file:

```
composer require jetfueltw/signer-php
```

## Usage

```
$signature = Signer::sign($id, $secret, $timestamp, $baseUrl, $parameters);
```

+ $id: The system App ID.
+ $secret: Secret key here.
+ $timestamp: The UTC Unix timestamp of the request.
+ $baseUrl: The base URL is the URL to which the request is directed, minus any query string or hash parameters.
+ $parameters: HTTP request parameters from query string and request body. You should collect the raw values, do not double-escape any characters. 

Example, this is your request:

```
POST https://example.app/api/v1/orders/?id=12

recipient: 'Grand Canyon'
email: 'grand@gmail.com'
address: 'PO Box 129 Grand Canyon, AZ 86023'
```

And, do this.

```
$id = 'ffe877812ab842a1bc30b27751bbd6ac';
$secret = '381ec44adb8347c68ea0eb4d43212dab';
$timestamp = 1497256470;
$baseUrl = 'https://example.app/api/v1/orders';
$parameters = [
    'id'        => 12,
    'recipient' => 'Grand Canyon',
    'email'     => 'grand@gmail.com',
    'address'   => 'PO Box 129 Grand Canyon, AZ 86023',
];

$signature = Signer::sign($id, $secret, $timestamp, $baseUrl, $parameters);
// $signature === 'i9FVroaK4yF1uOrQw09BCRFWy9RrPEl6AZus3DInUCI=';
```

## License

This package is licensed under the MIT license.
