<?php
/**
 * Include the Composer autoloader.
 */
require '../vendor/autoload.php';

/**
 * And kickstart the framework!
 */

// create an instance of the DiC
$dic = new FuelPHP\DependencyInjection\Container();

// register the Environment class to the DiC
$dic->register('env', 'FuelPHP\Foundation\Environment', function($entry) {
	$entry->preferSingleton();
});

// create the environment instance, configure it, and start the application...
$dic->resolve('env', null, $dic)
	->setConfig(array())
	->setApp('../application/demoapp')
	->execute();
