<?php

require( __DIR__ . "/../vendor/autoload.php" );

$loop = \React\EventLoop\Factory::create();

$tty = new \React\Stream\CompositeStream(
			new \React\Stream\Stream( fopen( "php://stdin", "r" ), $loop ),
			new \React\Stream\Stream( fopen( "php://stdout", "w" ), $loop )
		);

$client = new MQTT\Client("dns.lan", 1883, "client-id", $loop);

$client->on( "connect", function() use ($client, $tty ) {
	$client->subscribe( [ "#" => [ 'qos' => 0 ] ] );
});

$client->on( 'message', function( $topic, $message) use ( $tty ) {
	$tty->write( sprintf( "%s : %s" . PHP_EOL, $topic, $message ) );
});

$tty->on( "data", function( $data ) use ( $client ) {
	if ( $client->isConnected() )
		$client->publish( "test-topic", trim( $data ) );
});

$client->connect();

$loop->run();
?>