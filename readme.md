# Interspire API Wrapper

## Installation

First, pull in the package through Composer.

```js
"require": {
    "seansch/interspire": "dev-master"
}

```

And then, if using Laravel 5, include the service provider within `app/config/app.php`.

```php
'providers' => [
    'Seansch\Interspire\InterspireServiceProvider'
];

```

And, for convenience, add a facade alias to this same file at the bottom:

```php
'aliases' => [
    'Interspire' => 'Seansch\Interspire\InterspireFacade'
];

```

Publish the config file `app/config/interspire.php` and edit with your details
```php
php artisan vendor:publish

```

## Usage
Returns `bool` based on success

```php
    $result = Interspire::addSubscriberToList($email, $list_id, array $fields);
    $result = Interspire::deleteSubscriber($email, $list_id)
    $result = Interspire::isOnList($email, $list_id)
    $result = Interspire::getCustomFields($list_id)

```