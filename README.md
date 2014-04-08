silex-raven
===========

A basic [Silex](https://github.com/silexphp/Silex) service provider for [getsentry/raven-php](https://github.com/getsentry/raven-php).

# Installation

The recommended way to install silex-raven is through [Composer](https://getcomposer.org). Just create a composer.json file and run the php composer.phar install command to install it:

```json
{
    "require": {
        "v-six/silex-raven": "~0.1"
    }
}
```

Alternatively, you can download the silex-raven.zip file and extract it.

# Usage

```php
$app->register(new SilexRaven\RavenServiceProvider(),
    array(
        'dsn' => 'http://public:secret@example.com/1',
        'handle' => array(
            'exceptions' => false, // Disable exceptions handler
            'errors' => true, // Enable errors handler
            'fatal_errors' => true // Enable fatal_errors handler
        )
    )
);
```

All handlers are registered by default, you can disable them by setting corresponding configuration input to false.

## Custom

You can easily throw a custom error / exception with the following :

```php
// Throw an error with a message
$app['raven']->captureMessage('Oops !');

// Throw an exception
$app['raven']->captureMessage(new \Exception('Oops !'));

// Throw an exception with additional debug data
$app['raven']->captureMessage(new \Exception('Oops !'),
    array(
        'extra' => array(
            'php_version' => phpversion()
        ),
    )
);
```

Obviously you can also provide custom request context :

```php
// Bind the logged in user
$app['raven']->user_context(array('email' => 'foo@example.com'));

// Tag the request with something interesting
$app['raven']->tags_context(array('interesting' => 'yes'));

// Provide a bit of additional context
$app['raven']->extra_context(array('happiness' => 'very'));


// Clean all previously provided context
$app['raven']->context->clear();
```