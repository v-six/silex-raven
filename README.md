silex-raven
===========

A basic [Silex](https://github.com/silexphp/Silex) service provider for [getsentry/raven-php](https://github.com/getsentry/raven-php).

# Installation

The recommended way to install silex-raven is through [Composer](https://getcomposer.org). Just create a composer.json file and run the php composer.phar install command to install it:

```json
{
    "require": {
        "v-six/silex-raven": "~0.1.1"
    }
}
```

Alternatively, you can download the silex-raven.zip file and extract it.

# Usage

```php
$app->register(new SilexRaven\RavenServiceProvider(),
    array(
        'raven.dsn' => 'http://public:secret@example.com/1',
        'raven.options' => array(
            'logger' => 'my-logger-name' // Set custom logger name
        )
        'raven.handle' => array(
            'exceptions' => false, // Disable exceptions handler
            'errors' => true, // Enable errors handler
            'fatal_errors' => true, // Enable fatal_errors handler
        )
    )
);
```

If necessary, set your own options in `raven.options` (see [Raven documentation](https://github.com/getsentry/raven-php#configuration)).
All handlers are registered by default, you can disable them by setting corresponding configuration input to false in `raven.handle`.

## Custom

You can easily capture an error or an exception with the following :

```php
// Capture an error
$app['raven']->captureMessage('Oops !');

// Capture an exception
$app['raven']->captureException(new \Exception('Oops !'));

// Capture an exception with additional debug data
$app['raven']->captureException(new \Exception('Oops !'),
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

Here is a full example coupled with [Silex](https://github.com/silexphp/Silex) error handler (see (Silex error handlers documentation)[http://silex.sensiolabs.org/doc/usage.html#error-handlers]) :

```php
$app->error(function (\Exception $e, $code) use($app, $user) {
    $app['raven']->user_context(array('email' => $user->email));
    $app['raven']->captureException($e)
    $app['raven']->context->clear();

    return new Response("There is an error !");
});
```

# Resources

* (Silex error handlers documentation)[http://silex.sensiolabs.org/doc/usage.html#error-handlers]
* (Raven documentation)[https://github.com/getsentry/raven-php]