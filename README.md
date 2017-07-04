## Introduction

Creating HMAC-SHA256 signature for a HTTP request.

## Installation

Add jetfueltw/signer-php as a require dependency in your composer.json file:

```
composer require jetfueltw/signer-php
```

## Usage

```
$signature = Signer::sign($appId, $appSecret, $timestamp, $method, $baseUrl, $parameters, $content);
```

+ $appId: The app identifies.
+ $appSecret: The app secret key.
+ $timestamp: This value should be the number of seconds since the Unix epoch at the point the request is generated.
+ $baseUrl: The base URL is the URL to which the request is directed, minus any query string or hash parameters.
+ $parameters: HTTP request parameters from query string. You should collect the raw values, do not double-escape any characters. 

Example, this is your request:

```
POST https://example.app/api/v1/players?title=title&author=author
{
    "title": "An encoded string!",
    "bar": {
        "sort": 79,
        "status": "ok",
    },
    "publish_at": 123546987,
    "numbers": [98, 23, 45, 78],
    "desc": "Dogs, Cats & Mice",
}
```

Your code.

```
$appId = 'ffe877812ab842a1bc30b27751bbd6ac';
$appSecret = '381ec44adb8347c68ea0eb4d43212dab';
$timestamp = (new DateTime())->getTimestamp(); // 1499158061
$baseUrl = 'https://example.app/api/v1/players';
$parameters = [
    'title'  => 'title',
    'author' => 'author',
];
$content = json_encode([
    'title'      => 'An encoded string!',
    'bar'        => [
        'sort'   => 79,
        'status' => 'ok',
    ],
    'publish_at' => 123546987,
    'numbers'    => [98, 23, 45, 78],
    'desc'       => 'Dogs, Cats & Mice',
]);

$signature = Signer::sign($appId, $appSecret, $timestamp, $method, $baseUrl, $parameters, $content);
// $signature === 'ipvDjcBgv5mt1SHhmJ7TM6nPhKz/Nwc/B8VsGNyY1Vs=';
```

## License

This package is licensed under the MIT license.
