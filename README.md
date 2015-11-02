# php-mqtt

## Install
```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/cfullelove/php-mqtt"
        }
    ],
	"require": {
        "cfullelove/php-mqtt": "dev-master"
	}
}
```

## Example
```php

require( __DIR__ . "/vendor/autoload.php" );

$loop = \React\EventLoop\Factory::create();

$client = new MQTT\Client("localhost", 1883, "client-id", $loop);

$client->on( "connect", function() use ($client, $tty ) {
	$client->subscribe( [ "#" => [ 'qos' => 0 ] ] );
});

$client->on( 'message', function( $topic, $message) {
	printf( "%s : %s" . PHP_EOL, $topic, $message );
});

$client->connect();

$loop->run();

```
