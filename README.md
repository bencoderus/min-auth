# Min Auth

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bencoderus/minauth.svg?style=flat-square)](https://packagist.org/packages/bencoderus/minauth)
[![Build Status](https://img.shields.io/travis/bencoderus/min-auth/master.svg?style=flat-square)](https://travis-ci.org/bencoderus/min-auth)
[![Latest Stable Version](https://poser.pugx.org/bencoderus/minauth/v)](//packagist.org/packages/bencoderus/minauth)
[![License](https://poser.pugx.org/bencoderus/minauth/license)](//packagist.org/packages/bencoderus/minaut)

Min Auth is a package that allows you to create and manage a client based authentication system on your Laravel web
application.

## Installation

This package requires PHP >= 7.2 and above. (Laravel 8 and PHP 8 support are available).

You can install the package via composer:

```bash
composer require bencoderus/minauth
```

Publish migration and configurations.

``` bash
php artisan min-auth:install
```

Run migrations

``` bash
php artisan migrate
```

## Usage

#### Min Auth commands

Publish migration and configurations.

``` php
php artisan min-auth:install
```

Create a client

``` php
php artisan min-auth:create-client {name}
```

### Using the middleware to protect your routes.

In your route add `auth.client`

``` php
Route::get('test', function(){
    return "Hello world";
})->middleware('auth.client');
```

In your controller add `auth.client`

``` php
public function __construct(){
    $this->middleware('auth.client');
}
```

#### Using the helpers

Import Min Auth Helper

``` php
use Bencoderus\MinAuth\MinAuth;
```

Create a client

``` php

MinAuth::createClient($name);
// Optional
MinAuth::createClient($name, $ip, $isBlacklisted);
```

Find a client by API key

``` php
MinAuth::findByApiKey($apiKey);
```

Blacklist a client

``` php
MinAuth::blacklistClient($client);
```

Whitelist a client

``` php
MinAuth::whitelistClient($client);
```

Update client Ip address

``` php
$ip = "127.0.0.8";
MinAuth::updateIpAddress($client, $ip);
```

#### Configuration

You can turn off IP Address verification via config/min-auth.php

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email bencoderus@gmail.com instead of using the issue tracker.

## Credits

- [Benjamin Iduwe](https://github.com/bencoderus)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
