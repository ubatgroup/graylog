# Laravel wrapper for UbatGroup Graylog Server

It is a laravel wrapper for [bzikarsky/gelf-php](https://github.com/bzikarsky/gelf-php) package.

This package was developed for an internal need. No maintenance's planned. 

## Installation

Install via [composer](https://getcomposer.org/doc/00-intro.md)

```sh
composer require ubatgroup/graylog
```

### Only for Laravel 5 to 5.3
Add it to your providers array in `config/app.php`:

```php
Ubatgroup\Graylog\GraylogServiceProvider::class
```

To use the facade, add it to your aliases array in `config/app.php`:

```php
'Graylog' => \Ubatgroup\Graylog\Facades\Graylog::class
```

### For Laravel 5.4 and more

Laravel auto discover new packages

```sh
composer dump-autoload
```

### Configuration

Set the graylog configuration into the .env file :

* <b>GRAYLOG_SERVER</b> : server graylog ip (if this key is not set, it uses 127.0.0.1)
* <b>GRAYLOG_PORT</b> : server graylog port (if this key is not set, it uses 12201)
* <b>GRAYLOG_FACILITY</b> : graylog facility filter (if this key is not set, it uses <b>APP_URL</b> key)
* <b>GRAYLOG_APPNAME</b> : graylog source filter (if this key is not set, it uses <b>APP_NAME</b> key)

##### To override the configuration file :

First, publish the configuration file:
```sh
php artisan vendor:publish --provider="Ubatgroup\Graylog\GraylogServiceProvider"
```
See the content of the published configuration file in `config/graylog.php`.
```sh
// Address serveur host
'server'   => env( 'GRAYLOG_SERVER', '127.0.0.1' ),
 
// Port server host
'port'     => env( 'GRAYLOG_PORT', 12201 ),
 
// facility to filter logs (common use application URL)
'facility' => env( 'GRAYLOG_FACILITY', env( 'APP_URL', null ) ),
 
// host to filter logs (common use application name)
'host'     => env( 'GRAYLOG_HOST', env( 'APP_NAME', null ) ),
 
// Add Auth::user data automatically as AdditionaData in every exception handle by the connected user
'auto_log_auth_user' => true,
```

## Usage

```php
 Graylog::emergency( $message, array $context = array() );
 Graylog::alert( $message, array $context = array() );
 Graylog::critical( $message, array $context = array() );
 Graylog::error( $message, array $context = array() );
 Graylog::warning( $message, array $context = array() );
 Graylog::notice( $message, array $context = array() );
 Graylog::info( $message, array $context = array() );
 Graylog::debug( $message, array $context = array() );
```

See the [bzikarsky/gelf-php](https://github.com/bzikarsky/gelf-php/tree/master/examples) examples in his repo to find the available methods for the `Graylog` facade.

### Example

```php
Graylog::alert('There was a foo in bar', [
    'foo' => 'bar',
    'other_context_key' => 'other_context_value',
]);
```

```php
try {
    throw new \Exception('Nice exception !');
} catch (\Exception $e) {
    Graylog::emergency('Exception handled !', [
        'exception' => $e,
        'additionnal_data' => 'Hello world!
    ]);
}
```

## Note

* If <b>auto_log_auth_user</b> config key and <b>Auth::check()</b> are <b>true</b>, <b>Auth::user()</b> data are auto added to the context array (auth_user key)
* If you need to use <b>$guard</b> to get the authenticated user, turn <b>false</b> the <b>auto_log_auth_user</b> config key and add it manually in additionnal data array
* Don't use special/accentuated chars in context key for additionals data

## License

This package is released under the MIT Licence.
